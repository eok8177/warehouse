<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Invoice;
use App\Http\Requests\InvoiceRequest;

use App\Model\Sklad\Product;
use App\Model\Sklad\Supplier;
use App\Model\Sklad\Incoming;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('sklad.invoice.index', ['items' => Invoice::all()]);
    }

    public function create()
    {
        return view('sklad.invoice.create', ['suppliers' => Supplier::all()]);
    }

    public function store(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice = $invoice->create($request->all());

        return redirect()->route('sklad.invoice.show', ['invoice' => $invoice]);
    }

    public function show(Invoice $invoice, Product $products)
    {
        return view('sklad.invoice.show', [
            'invoice' => $invoice,
            'incomings' => Incoming::with('product', 'product.outcoming')->where('invoice_id',$invoice->id)->get(),
            'products' => Product::all(),
            ]);
    }

    public function edit(Invoice $invoice)
    {
        return view('sklad.invoice.edit', [
            'invoice' => $invoice,
            'suppliers' => Supplier::all(),
            ]);
    }

    public function update(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice->update($request->all());

        foreach ($invoice->products as $incoming) {
            $incoming->date = $invoice->date;
            $incoming->save();
        }

        return redirect()->route('sklad.invoice.show', ['invoice' => $invoice]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return 'success';
    }
}
