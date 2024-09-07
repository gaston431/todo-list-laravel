<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $item = Item::create(array_merge($validated, ['completed' => 0]));

        return response()->json(['id' => $item->id]);
        // redirect(route('items.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        /* $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]); */
        
        $item->update(['completed' => request('completed')]);
 
        return response()->json(['id' => $item->id]);
        // return redirect(route('items.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return response()->json('deleted');
        // return redirect(route('items.index'));
    }
}
