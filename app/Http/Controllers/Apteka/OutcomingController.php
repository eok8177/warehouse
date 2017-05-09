<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Outcoming;
use App\Http\Requests\OutcomingRequest;
use App\Model\Apteka\Product;
use App\Model\Apteka\Client;

class OutcomingController extends Controller
{
    public function create(Product $product)
    {
        $returnHTML = view('apteka.outcoming.create', [
            'product' => $product,
            'clients' => Client::orderBy('title', 'asc')->get(),
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

        return redirect()->route('apteka.product.show', ['id' => $outcoming->product->id]);
    }


    public function edit(Outcoming $outcoming)
    {
        $returnHTML = view('apteka.outcoming.edit', [
            'outcoming' => $outcoming,
            'clients' => Client::orderBy('title', 'asc')->get(),
            ])->render();

        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function update(OutcomingRequest $request, Outcoming $outcoming)
    {
        $price = $outcoming->sum / $outcoming->count;
        $outcoming->product->quantity += $outcoming->count;
        $outcoming->product->sum += $outcoming->sum;

        $outcoming->update($request->all());
        $outcoming->sum = $outcoming->count * $price;
        $outcoming->save();

        $outcoming->product->quantity -= $outcoming->count;
        $outcoming->product->sum -= $outcoming->sum;
        $outcoming->product->save();

        return redirect()->route('apteka.product.show', ['id' => $outcoming->product->id]);
    }

    public function destroy(Outcoming $outcoming)
    {
        $outcoming->product->quantity += $outcoming->count;
        $outcoming->product->sum += $outcoming->sum;
        $outcoming->product->save();

        $outcoming->delete();

        return 'success';
    }
}
