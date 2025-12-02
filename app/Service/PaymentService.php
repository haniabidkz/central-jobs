<?php

namespace App\Service;

use App\Repository\CommonRepository;
use App\Http\Model\Payment;
use App\Http\Model\PaymentCms;
use App\Http\Model\UserPayment;
use App\Http\Model\UserTransactionDetails;
use App\Http\Model\CompanyTransactionHistory;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentEmail;
use Stripe\StripeClient;
use Carbon\Carbon;
use Auth;

class PaymentService
{
    protected $paymentRepository;

    public function __construct(Payment $payment, PaymentCms $paymentCms)
    {
        $this->paymentRepository = new CommonRepository($payment);
        $this->paymentCmsRepository = new CommonRepository($paymentCms);
    }
    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 20/03/2020
    @FunctionFor: Payment all list
    */
    public function getAllList($request)
    {
        $data = $request->all();
        $condition  = [];
        $condition1  = [];
        if (request()->input('start_date', false) != false) {
            $filterData['start'] = date('Y-m-d', strtotime($data['start_date']));
            $from    = Carbon::parse($filterData['start'])
                ->startOfDay()        // 2018-09-29 00:00:00.000000
                ->toDateTimeString();
            $condition[] = ['created_at', '>=', $from];
        }
        if (request()->input('end_date', false) != false) {
            $filterData['end'] = date('Y-m-d', strtotime($data['end_date']));
            $to      = Carbon::parse($filterData['end'])
                ->endOfDay()          // 2018-09-29 23:59:59.000000
                ->toDateTimeString(); // 2018-09-29 23:59:59
            $condition[] = ['created_at', '<=', $to];
        }
        if (request()->input('status', false) != false) {
            if ($data['status'] == 3) {
                $data['status'] = 0;
            }
            $condition[] = ['status', $data['status']];
        }
        if (request()->input('service_id', false) != false) {
            $condition[] = ['service_id', $data['service_id']];
        }
        if (request()->input('subscription_id', false) != false) {
            $condition[] = ['subscription_id', 'Like', '%' . $data['subscription_id'] . '%'];
        }

        $limit = env('ADMIN_PAGINATION_LIMIT');
        $relation = ['subscription', 'user', 'order'];
        $payment = $this->paymentRepository->getSearchWithUser($condition, $condition1, $limit, $relation);
        return $payment;
    }

    /*
    @DevelopedBy: Rumpa Ghosh
    @Date: 23/03/2020
    @FunctionFor: Payment details 
    */
    public function getDetails($data)
    {
        $id = $data['id'];
        $where = [['id', $id]];
        $relation = ['subscription', 'user', 'order'];
        $payment = $this->paymentRepository->showWith($where, $relation);
        return $payment;
    }

    /** 
     * Get All category List
     */
    public function fetchList()
    {
        $data = PaymentCms::orderBy("id", "DESC")->paginate(env('ADMIN_PAGINATION_LIMIT'));
        return $data;
    }

    public function details($id)
    {
        $data = PaymentCms::where('id', $id)->get()->first();
        return $data;
    }

    public function updateDetails($request)
    {
        $id = $request['id'];
        $oldData = PaymentCms::where('id', $id)->get()->first();
        $insertArr['value'] = $request['value'];
        $insertArr['status'] = 1;
        $data = PaymentCms::where('id', $id)->update($insertArr);
        return $data;
    }

    public function getPaymentValue()
    {
        $data = PaymentCms::where('status', 1)->orderBy("id")->get();
        return $data;
    }

    public function getPaymentValueById($id)
    {
        $data = PaymentCms::where('status', 1)->where('id', $id)->first();
        return $data;
    }

    public function makePayment($payId, $getRequest = null)
    {
        $user = Auth::user();

        $user->is_payment_done = ($payId == 1) ? 1 : 2;
        $user->save();

        if ($payId != 1) {

            try {
                $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));

                $user_customerId = UserTransactionDetails::where('user_id', $user->id)->first();
                if (is_null($user->customer_id) || $user->customer_id == '') {
                    $customer = $stripe->customers->create([
                        'email' => $user->email,
                        'name' => $user->first_name . ' ' . $user->last_name,
                        'phone' => $user->telephone,
                    ]);
                } else {
                    // keep minimal shape compatible with existing code
                    $customer = ['id' => $user->customer_id];
                }

                if (is_null($user->card_id) || $user->card_id == '') {
                    $token = $stripe->tokens->create([
                        'card' => [
                            'number'    => $getRequest['card'],
                            'exp_month' => $getRequest['exp_month'],
                            'cvc'       => $getRequest['cvc'],
                            'exp_year'  => $getRequest['exp_year'],
                        ],
                    ]);

                    // Attach token as a source to the customer
                    $card = $stripe->customers->createSource($customer['id'], [
                        'source' => $token['id'],
                    ]);
                } else {
                    $card = ['id' => $user->card_id];
                }

                if (is_null($user->subscription_id) || $user->subscription_id == '') {
                    // Create subscription using Prices API (items with price)
                    $subscription = $stripe->subscriptions->create([
                        'customer' => $customer['id'],
                        'items' => [
                            ['price' => $getRequest['plan_id']],
                        ],
                    ]);
                } else if ($user->subscription_plan_id != $getRequest['plan_id']) {
                    // Cancel existing subscription then create new one
                    try {
                        $stripe->subscriptions->cancel($user->subscription_id, []);
                    } catch (\Exception $e) {
                        // ignore cancellation errors and proceed to create
                    }
                    $subscription = $stripe->subscriptions->create([
                        'customer' => $customer['id'],
                        'items' => [
                            ['price' => $getRequest['plan_id']],
                        ],
                    ]);
                } else {
                    $subscription = ['id' => $user->subscription_id];
                }

                $user->customer_id = $customer['id'];
                $user->subscription_plan_id = $getRequest['plan_id'];
                $user->card_id = $card['id'];
                $user->subscription_id = $subscription['id'];
                $user->save();


                $plan = $stripe->plans->retrieve($getRequest['plan_id']);
                $original_amount = $plan['amount'];

                $transaction['user_id'] = $user->id;
                $transaction['subscription_plan_id'] = $getRequest['plan_id'];
                $transaction['card_id'] = $card['id'];
                $transaction['currency'] = 'USD';
                $transaction['amount'] = $original_amount / 100;
                $transaction['customer_id'] = $customer['id'];
                $transaction['subscription_id'] = $subscription['id'];
                $transactionInfo = UserTransactionDetails::create($transaction);

                Mail::to($user->email)->send(new PaymentEmail($transactionInfo, $user));

                $user->highlight_cv = 1;
                $user->save();
            } catch (\Exception $ex) {
                dd($ex);
            }
        }

        $userPayment = UserPayment::where('user_id', $user->id)->first();
        if ($userPayment == NULL) {
            $userPayment = new UserPayment;
        }
        $userPayment->user_id = $user->id;
        $userPayment->payment_id = $payId;
        $userPayment->status = ($payId == 1) ? 0 : 1;
        $userPayment->save();

        return true;
    }

    public function getPlans()
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        if (Auth::user() && Auth::user()->user_type == 1) {
            $plansCollection = $stripe->plans->all();
        } else {
            $plansCollection = $stripe->plans->all(['active' => true]);
        }

        $results = [];
        foreach ($plansCollection->data as $planObj) {
            try {
                $product = $stripe->products->retrieve($planObj->product);
            } catch (\Exception $e) {
                continue;
            }

            $isArchived = false;
            if (isset($product->metadata)) {
                // metadata can be array or Stripe object
                $meta = is_array($product->metadata) ? $product->metadata : (method_exists($product, 'toArray') ? $product->metadata->toArray() : (array) $product->metadata);
                if (isset($meta['is_archived']) && $meta['is_archived'] == 1) {
                    $isArchived = true;
                }
            }

            if ($isArchived) {
                continue;
            }

            $planArr = method_exists($planObj, 'toArray') ? $planObj->toArray() : (array) $planObj;
            $planArr['product'] = method_exists($product, 'toArray') ? $product->toArray() : (array) $product;
            $results[] = $planArr;
        }

        return $results;
        //return response()->json(["data" => $plans], 200);
    }

    public function getPlanDetailsById($id)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $plan = $stripe->plans->retrieve($id);
        $product = $stripe->products->retrieve($plan->product);
        $planArr = method_exists($plan, 'toArray') ? $plan->toArray() : (array) $plan;
        $planArr['product'] = isset($product->description) ? $product->description : (isset($product['description']) ? $product['description'] : null);
        $planArr['product_metadata'] = isset($product->metadata) ? (method_exists($product->metadata, 'toArray') ? $product->metadata->toArray() : (array) $product->metadata) : [];
        return $planArr;
    }

    public function updatePlanDetailsById($request)
    {
        //dd($general);
        $id                     = $request->input('plan_id');
        $name                   = $request->input('plan_name');
        $desc                   = $request->input('desc');
        $plan_desc              = $request->input('plan_desc');
        $general                = $request->input('general') == null ? ' ' : $request->input('general');
        $free                   = $request->input('free') == null ? ' ' : $request->input('free');
        $below_description      = $request->input('below_description') == null ? ' ' : $request->input('below_description');

        try {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
            $plan = $stripe->plans->update($id, [
                'name' => $name,
                'statement_descriptor' => $desc
            ]);

            $product = $stripe->products->update($plan['product'], [
                'description' => $plan_desc,
                'metadata' => [
                    'General'           => $general,
                    'Free'              => $free,
                    'Below Description' => $below_description
                ]
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        return $plan;
    }

    public function changePlanStatus($id, $status)
    {
        try {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
            $plan = $stripe->plans->update($id, [
                'active' => $status
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            dd($e->getMessage());
        }
        return $plan;
    }

    public function upgradeSubscription($request)
    {
        $getRequest = $request->all();
        $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
        $getUser = Auth::user();

        $user_customerId = UserTransactionDetails::where('user_id', $getUser->id)->first();

        try {
            $stripe->subscriptions->cancel($getUser->subscription_id, []);
        } catch (\Exception $e) {
            // ignore cancel errors
        }

        $subscription = $stripe->subscriptions->create([
            'customer' => $getUser->customer_id,
            'items' => [
                ['price' => $getRequest['plan_id']],
            ],
        ]);


        $getUser->subscription_plan_id = $getRequest['plan_id'];
        $getUser->subscription_id = $subscription['id'];
        $getUser->save();

        $getUser->plan = $stripe->plans->retrieve($getRequest['plan_id']);
        $transaction['user_id'] = $getUser->id;
        $transaction['subscription_plan_id'] = $getRequest['plan_id'];
        $transaction['card_id'] = $getUser->card_id;
        $transaction['currency'] = 'USD';
        $transaction['amount'] = $getUser->plan['amount'];
        $transaction['customer_id'] = $getUser->customer_id;
        $transaction['subscription_id'] = $subscription['id'];
        Transaction::create($transaction);

        //return response()->json(["message"=>"Subscription successfully upgraded", "data" => $getUser], 200);
    }

    public function addProduct($request)
    {
        $id                     = $request->input('plan_id');
        $name                   = $request->input('plan_name');
        $amount                 = $request->input('amount');
        $interval               = $request->input('interval');
        $desc                   = $request->input('desc');
        $plan_desc              = $request->input('plan_desc');
        $general                = $request->input('general');
        $free                   = $request->input('free');
        $below_description      = $request->input('below_description');

        try {
            $stripe = new StripeClient(env('STRIPE_SECRET_KEY'));
            $plan = $stripe->plans->create([
                'id'                   => $id,
                'name'                 => $name,
                'amount'               => $amount,
                'currency'             => 'EUR',
                'interval'             => $interval,
                'statement_descriptor' => $desc
            ]);

            $product = $stripe->products->update($plan['product'], [
                'description' => $plan_desc,
                'metadata' => [
                    'General'           => $general,
                    'Free'              => $free,
                    'Below Description' => $below_description
                ]
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
            dd($e->getMessage());
            return false;
        }

        return $plan;
    }

    public function CreateChargeForCompany($getRequest)
    {

        $user       = Auth::user();
        $stripe     =  new StripeClient(env('STRIPE_SECRET_KEY'));
        $plan       = $this->getPaymentValueById(base64_decode($getRequest['plan_id']));

        try {

            $token = $stripe->tokens->create([
                'card' => [
                    'number'    => $getRequest['card'],
                    'exp_month' => $getRequest['exp_month'],
                    'cvc'       => $getRequest['cvc'],
                    'exp_year'  => $getRequest['exp_year'],
                ],
            ]);

            $charge = $stripe->charges->create([
                'source'     => $token['id'],
                'currency' => 'EUR',
                'amount'   => $plan->value,
            ]);

            if ($charge['id']) {

                // insert payment details 
                $payment                        = new CompanyTransactionHistory;
                $payment->payment_id            = $charge['id'];
                $payment->user_id               = $user->id;
                $payment->amount                = $charge['amount'] / 100;
                $payment->currency              = $charge['currency'];
                $payment->payment_status        = $charge['status'];
                $payment->balance_transaction   = $charge['balance_transaction'];
                $payment->captured              = $charge['captured'];
                $payment->paid                  = $charge['paid'];
                $payment->disputed              = $charge['disputed'];
                $payment->payment_method        = $charge['payment_method'];
                $payment->receipt_url           = $charge['receipt_url'];
                $payment->description           = 'Initial Payment';
                if ($payment->save()) {

                    Mail::to($user->email)->send(new PaymentEmail($payment, $user));
                }
            } else {
                return false;
            }
            return $charge;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function CandidatetransactionList()
    {
        try {

            $candidates         = UserTransactionDetails::with('user')->paginate(10);

            foreach ($candidates as $key => $candidate) {
                $plan                       = $this->getPlanDetailsById($candidate->subscription_plan_id);
                $candidates[$key]['plan']   = $plan;
            }

            return $candidates;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function CompanyTransactionList()
    {
        try {
            $company = CompanyTransactionHistory::with('user')->paginate(10);

            return $company;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
