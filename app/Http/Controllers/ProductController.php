<?php

namespace App\Http\Controllers;

use Domain\Product\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class ProductController extends Controller
{

    public function __invoke(Product $product): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $product->load(['optionValues.option']);

        session()->put('also.' . $product->id, $product->id);

        $also = Product::query()
            ->where(function ($q) use ($product){
                $q->whereIn('id', session('also'))
                    ->where('id', '!=', $product->id);
            })
            ->get();


        return view('product.show', [
            'product' => $product,
            'options' => $product->optionValues->keyValues(),
            'also' => $also
        ]);
    }
}
