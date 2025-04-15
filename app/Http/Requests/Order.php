<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Order extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
  
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // "candidate_name" => 'required',
            "subscription_id" => 'required',
            "candidate_email" => 'required|email',
            "amount" => 'required|numeric',
            // "service_start_from" => 'required',
            // "additional_info" => 'required'
        ];
    }
}
