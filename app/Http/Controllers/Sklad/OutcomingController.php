<?php

namespace App\Http\Controllers\Sklad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Sklad\Outcoming;
use App\Http\Requests\OutcomingRequest;
use App\Model\Sklad\Product;
use App\Model\Sklad\Client;

class OutcomingController extends Controller
{
    public function create(Product $product)
    {
        $returnHTML = view('sklad.outcoming.create', [
            'product' => $product,
            'clients' => Client::all(),
            ])->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function store(OutcomingRequest $request, Outcoming $outcoming)
    {
        $outcoming = $outcoming->create($request->all());

        $sum = $outcoming->product->sum / $outcoming->product->quantity * $outcoming->count;

        $outcoming->product->quantity -= $outcoming->count;
        $outcoming->product->sum -= $sum;
        $outcoming->product->save();

        $outcoming->sum = $sum;
        $outcoming->save();

        return redirect()->route('sklad.product.show', ['id' => $outcoming->product->id]);
    }


    public function edit(Outcoming $outcoming)
    {
        return view('sklad.outcoming.edit', ['outcoming' => $outcoming]);
    }

    public function update(OutcomingRequest $request, Outcoming $outcoming)
    {
        $outcoming->product->quantity -= $outcoming->count;
        $outcoming->product->save();

        $outcoming->update($request->all());

        $outcoming->product->quantity += $outcoming->count;
        $outcoming->product->save();

        return redirect()->route('sklad.invoice.show', ['id' => $outcoming->invoice_id]);
    }

    public function destroy(Outcoming $outcoming)
    {
        $outcoming->product->quantity += $outcoming->count;
        $outcoming->product->save();

        $outcoming->delete();

        return 'success';
    }
}
