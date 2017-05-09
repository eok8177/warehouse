<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Bill;
use App\Http\Requests\BillRequest;

use App\Model\Apteka\Product;

class BillController extends Controller
{
    public function index()
    {
        return view('apteka.bill.index', ['items' => Bill::all()]);
    }

    public function create()
    {
        return view('apteka.bill.create');
    }

    public function store(BillRequest $request, Bill $bill)
    {
        $bill = $bill->create($request->all());

        return redirect()->route('apteka.bill.index');
    }

    public function show(Bill $bill, Product $products)
    {
        return view('apteka.bill.show', ['bill' => $bill]);
    }

    public function edit(Bill $bill)
    {
        return view('apteka.bill.edit', ['bill' => $bill]);
    }

    public function update(BillRequest $request, Bill $bill)
    {
        $bill->update($request->all());

        return redirect()->route('apteka.bill.index');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();

        return 'success';
    }
}
