<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Incoming;
use App\Http\Requests\IncomingRequest;
use App\Model\Sklad\Product;
use App\Model\Sklad\Invoice;

class IncomingController extends Controller
{
    public function create(Invoice $invoice)
    {
        $returnHTML = view('sklad.incoming.create', [
            'invoice' => $invoice,
            'products' => Product::orderBy('title', 'asc')->get(),
            ])->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function store(IncomingRequest $request, Incoming $incoming)
    {
        $newIncoming = $request->all();
        $newIncoming['sum'] = $newIncoming['price'] * $newIncoming['count'];
        $incoming = $incoming->create($newIncoming);

        $incoming->product->quantity += $incoming->count;
        $incoming->product->sum += $incoming->count * $incoming->price;
        $incoming->product->save();

        $incoming->date = $incoming->invoice->date;
        $incoming->save();

        return redirect()->route('sklad.invoice.show', ['id' => $incoming->invoice_id]);
    }


    public function edit(Incoming $incoming)
    {
        return view('sklad.incoming.edit', ['incoming' => $incoming]);
    }

    public function update(IncomingRequest $request, Incoming $incoming)
    {
        $incoming->product->quantity -= $incoming->count;
        $incoming->product->save();

        $incoming->update($request->all());

        $incoming->product->quantity += $incoming->count;
        $incoming->product->save();

        return redirect()->route('sklad.invoice.show', ['id' => $incoming->invoice_id]);
    }

    public function destroy(Incoming $incoming)
    {
        $incoming->product->quantity -= $incoming->count;
        $incoming->product->sum -= $incoming->count * $incoming->price;
        $incoming->product->save();

        $incoming->delete();

        return 'success';
    }
}
