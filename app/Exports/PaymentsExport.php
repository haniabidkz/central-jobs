<?php

namespace App\Exports;

use App\Http\Model\Payment;
use Maatwebsite\Excel\Concerns\FromArray;

class PaymentsExport implements FromArray
{
    protected $payments;
    public function __construct(array $payments)
    {
        $this->payments = $payments;
    }

    public function array(): array
    {
        return $this->payments;
    }
}
