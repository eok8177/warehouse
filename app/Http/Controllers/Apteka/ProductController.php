<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Bill;
use App\Model\Apteka\Product;
use App\Http\Requests\ProductRequest;
use App\Model\Apteka\Incoming;
use App\Http\Requests\IncomingRequest;
use App\Model\Apteka\Outcoming;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $bill = $request->input('bill', 0);
        $rest = $request->input('rest', 1);
        $title = $request->input('title', false);

        $bills = Bill::all();

        $items = Incoming::with('product', 'outcoming')->orderBy('product_id', 'asc');

        if ($rest != 0) $items->where('rest','>',0);

        if ($bill > 0)
            $items->whereHas('product', function ($query) use($bill) {
                $query->where('bill_id', '=', $bill);
            });

        if ($title)
            $items->whereHas('product', function ($query) use($title) {
                $query->where('title', 'LIKE', '%'.$title.'%');
            });

        return view('apteka.product.index', [
            'items' => $items->get(),
            'bills' => $bills
            ]);
    }

    public function create()
    {
        return view('apteka.product.create', ['bills' => Bill::forSelect()]);
    }

    public function store(ProductRequest $request, Product $product)
    {
        $request_product = $request->all();
        $request_product['bill_id'] = (array_key_exists('bill_id', $request_product)) ? $request_product['bill_id'] : 1;

        $product = $product->create($request_product);

        if($request->ajax()){
            $response = [
                "id" => $product->id,
                "title" => $product->title .' /('. $product->measure .')',
                ];
            return json_encode($response);
        }

        return redirect()->route('apteka.invoice.show', ['id' => $product->invoice_id]);
    }

    public function show(Product $product)
    {
        return view('apteka.product.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('apteka.product.edit', [
            'product' => $product,
            'bills' => Bill::forSelect(),
            ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route('apteka.product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return 'success';
    }
}
