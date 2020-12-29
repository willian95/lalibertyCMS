<?php

namespace App\Exports;

use App\ProductColorSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('excels.products', [
            'products' => ProductColorSize::with("product", "size", "color")->get()
        ]);
    }
}
