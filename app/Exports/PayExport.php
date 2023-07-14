<?php

namespace App\Exports;

use App\Models\Pay;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayExport implements FromCollection
{
    protected $invoices;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($invoices)
    {
        if ($invoices == 'allPay'){
            $this->invoices = Pay::all();
        }
        if ($invoices == 'todayPay'){
            $this->invoices = Pay::whereDate('created_at',Carbon::today())->get();
        }
    }
    public function collection()
    {
        return $this->invoices ;
    }
}
