<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Supplier;
use App\Http\Requests\SupplierRequest;

use App\Model\Apteka\Product;

class SupplierController extends Controller
{
    public function index()
    {
        return view('apteka.supplier.index', ['items' => Supplier::orderBy('title', 'asc')->get()]);
    }

    public function create()
    {
        return view('apteka.supplier.create');
    }

    public function store(SupplierRequest $request, Supplier $supplier)
    {
        $supplier = $supplier->create($request->all());

        if($request->ajax()){
            $response = [
                "id" => $supplier->id,
                "title" => $supplier->title
                ];
            return json_encode($response);
        }

        return redirect()->route('apteka.supplier.index');
    }

    public function show(Supplier $supplier, Product $products)
    {
        return view('apteka.supplier.show', ['supplier' => $supplier]);
    }

    public function edit(Supplier $supplier)
    {
        return view('apteka.supplier.edit', ['supplier' => $supplier]);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());

        return redirect()->route('apteka.supplier.index');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return 'success';
    }
}
