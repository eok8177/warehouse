<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Supplier;
use App\Http\Requests\SupplierRequest;

use App\Model\Sklad\Product;

class SupplierController extends Controller
{
    public function index()
    {
        return view('sklad.supplier.index', ['items' => Supplier::orderBy('title', 'asc')->get()]);
    }

    public function create()
    {
        return view('sklad.supplier.create');
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

        return redirect()->route('sklad.supplier.index');
    }

    public function show(Supplier $supplier, Product $products)
    {
        return view('sklad.supplier.show', ['supplier' => $supplier]);
    }

    public function edit(Supplier $supplier)
    {
        return view('sklad.supplier.edit', ['supplier' => $supplier]);
    }

    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->all());

        return redirect()->route('sklad.supplier.index');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return 'success';
    }
}
