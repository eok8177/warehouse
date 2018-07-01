<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\Work;
use App\Http\Requests\WorkRequest;

use App\Model\Lpz;
use App\Model\WorkCategories;

class WorkController extends Controller
{
    public function index()
    {
        return view('backend.work.index', [
            'items' => Work::orderBy('id', 'desc')->paginate(50)]
        );
    }

    public function create()
    {
        return view('backend.work.create', [
            'lpz' => Lpz::orderBy('name', 'asc')->pluck('name', 'id')->all(),
            'cat' => WorkCategories::pluck('name', 'id')->all(),
            ]);
    }

    public function store(WorkRequest $request, Work $work)
    {
        $work = $work->create($request->all());

        return redirect()->route('backend.work.index');
    }

    public function show(Work $work)
    {
        return view('backend.work.show', ['work' => $work]);
    }

    public function edit(Work $work)
    {
        return view('backend.work.edit', [
            'work' => $work,
            'lpz' => Lpz::orderBy('name', 'asc')->pluck('name', 'id')->all(),
            'cat' => WorkCategories::pluck('name', 'id')->all(),
            ]);
    }

    public function update(WorkRequest $request, Work $work)
    {
        $work->update($request->all());

        return redirect()->route('backend.work.index');
    }

    public function destroy(Work $work)
    {
        $work->delete();

        return 'success';
    }
}
