<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Invoice;
use App\Http\Requests\InvoiceRequest;

use App\Model\Apteka\Product;
use App\Model\Apteka\Supplier;
use App\Model\Apteka\Incoming;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('apteka.invoice.index', ['items' => Invoice::all()]);
    }

    public function create()
    {
        return view('apteka.invoice.create', ['suppliers' => Supplier::all()]);
    }

    public function store(InvoiceRequest $request, Invoice $invoice)
    {
        $invoice = $invoice->create($request->all());

        return redirect()->route('apteka.invoice.show', ['invoice' => $invoice]);
    }

    public function show(Invoice $invoice, Product $products)
    {
        return view('apteka.invoice.show', [
            'invoice' => $invoice,
            'incomings' => Incoming::with('product', 'product.outcoming')->where('invoice_id',$invoice->id)->get(),
            'products' => Product::all(),
            ]);
    }

    public function edit(Invoice $invoice)
    {
        return view('apteka.invoice.edit', [
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

        return redirect()->route('apteka.invoice.show', ['invoice' => $invoice]);
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return 'success';
    }
}
