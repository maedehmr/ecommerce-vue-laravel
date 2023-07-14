<?php

namespace App\Exports;

use App\Models\Post;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;

class PostExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $invoices;

    public function __construct($invoices)
    {
        if ($invoices == 'allProduct'){
            $this->invoices = Post::all();
        }
        if ($invoices == 'todayProduct'){
            $this->invoices = Post::whereDate('created_at',Carbon::today())->get();
        }
    }

    public function collection()
    {
        return $this->invoices ;
    }
}
