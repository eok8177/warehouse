<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Lpz;
use App\Http\Requests\LpzRequest;

class LpzController extends Controller
{
    public function index()
    {
        return view('backend.lpz.index', ['items' => Lpz::all()]);
    }

    public function create()
    {
        return view('backend.lpz.create');
    }

    public function store(LpzRequest $request, Lpz $lpz)
    {
        $lpz = $lpz->create($request->all());

        return redirect()->route('backend.lpz.index');
    }

    public function show(Lpz $lpz)
    {
        return view('backend.lpz.show', ['lpz' => $lpz]);
    }

    public function edit(Lpz $lpz)
    {
        return view('backend.lpz.edit', ['lpz' => $lpz]);
    }

    public function update(LpzRequest $request, Lpz $lpz)
    {
        $lpz->update($request->all());

        return redirect()->route('backend.lpz.index');
    }

    public function destroy(Lpz $lpz)
    {
        $lpz->delete();

        return 'success';
    }
}
