<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Bill;
use App\Http\Requests\BillRequest;

use App\Model\Sklad\Product;

class BillController extends Controller
{
    public function index()
    {
        return view('sklad.bill.index', ['items' => Bill::all()]);
    }

    public function create()
    {
        return view('sklad.bill.create');
    }

    public function store(BillRequest $request, Bill $bill)
    {
        $bill = $bill->create($request->all());

        return redirect()->route('sklad.bill.index');
    }

    public function show(Bill $bill, Product $products)
    {
        return view('sklad.bill.show', ['bill' => $bill]);
    }

    public function edit(Bill $bill)
    {
        return view('sklad.bill.edit', ['bill' => $bill]);
    }

    public function update(BillRequest $request, Bill $bill)
    {
        $bill->update($request->all());

        return redirect()->route('sklad.bill.index');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();

        return 'success';
    }
}
