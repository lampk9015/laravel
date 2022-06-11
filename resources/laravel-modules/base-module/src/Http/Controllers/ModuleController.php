<?php

namespace Modules\{Module}\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\{Module}\Models\{Model};

class {Module}Controller extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        ${model_} = {Model}::get();

        return view('{module-}::index', compact('{model_}'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('{module-}::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        {Model}::create([
            'name' => $request->input('name')
        ]);

        return redirect(route('app.{module-}.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        ${model_} = {Model}::findOrFail($id);

        return view('{module-}::show', compact('{model_}'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        ${model_} = {Model}::findOrFail($id);

        return view('{module-}::edit', compact('{model_}'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        {Model}::findOrFail($id)->update([
            'name' => $request->input('name')
        ]);

        return redirect(route('app.{module-}.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        {Model}::findOrFail($id)->delete();

        return redirect(route('app.{module-}.index'));
    }
}
