<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Bill;
use App\Model\Sklad\Product;
use App\Http\Requests\ProductRequest;
use App\Model\Sklad\Incoming;
use App\Http\Requests\IncomingRequest;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $bill = $request->input('bill', 0);
        $title = $request->input('title', false);

        $bills = Bill::all();

        $items = Product::with('bill', 'incoming', 'outcoming')->orderBy('title', 'asc');

        if ($bill > 0) $items = $items->where('bill_id', '=', $bill);
        if ($title) $items = $items->where('title', 'LIKE', '%'.$title.'%');

        return view('sklad.product.index', [
            'items' => $items->get(),
            'bills' => $bills
            ]);
    }

    public function create()
    {
        return view('sklad.product.create', ['bills' => Bill::pluck('title', 'id')->all()]);
    }

    public function store(ProductRequest $request, Product $product)
    {
        $product = $product->create($request->all());

        if($request->ajax()){
            $response = [
                "id" => $product->id,
                "title" => $product->title .' /('. $product->measure .')',
                ];
            return json_encode($response);
        }

        return redirect()->route('sklad.invoice.show', ['id' => $product->invoice_id]);
    }

    public function show(Product $product)
    {
        return view('sklad.product.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        return view('sklad.product.edit', [
            'product' => $product,
            'bills' => Bill::pluck('title', 'id')->all(),
            ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route('sklad.product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return 'success';
    }
}
