<?php

namespace App\Http\Controllers\Apteka;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Apteka\Client;
use App\Http\Requests\ClientRequest;

use App\Model\Apteka\Product;

class ClientController extends Controller
{
    public function index()
    {
        return view('apteka.client.index', ['items' => Client::orderBy('title', 'asc')->get()]);
    }

    public function create()
    {
        return view('apteka.client.create');
    }

    public function store(ClientRequest $request, Client $client)
    {
        $client = $client->create($request->all());

        if($request->ajax()){
            $response = [
                "id" => $client->id,
                "title" => $client->title
                ];
            return json_encode($response);
        }

        return redirect()->route('apteka.client.index');
    }

    public function show(Client $client, Product $products)
    {
        return view('apteka.client.show', ['client' => $client]);
    }

    public function edit(Client $client)
    {
        return view('apteka.client.edit', ['client' => $client]);
    }

    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->all());

        return redirect()->route('apteka.client.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return 'success';
    }
}
