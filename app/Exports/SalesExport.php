<?php

namespace App\Exports;

use App\Payment;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excels.sales', [
            'payments' => Payment::with("guestUser")
            ->with(['productPurchases.productColorSize' => function ($q) {
                $q->withTrashed();
                $q->with(['product' => function ($k) {
                    $k->withTrashed();
                }]);
                $q->with(['size' => function ($k) {
                    $k->withTrashed();
                }]);
                $q->with(['color' => function ($k) {
                    $k->withTrashed();
                }]);
            }])->get()
        ]);
    }
}
