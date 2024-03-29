<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
    /**
     * Get authicanted user id
     */
    public function getUserId()
    {
        return auth()->id();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if (auth()->user()->role == 'admin') {
            $this->authorize('isAdmin');
        }
        if (auth()->user()->role == 'owner') {
            $this->authorize('owner');
        }

        $filtered_data = Item::with('categories')->get()->all();
        // dd($filtered_data);
        foreach($filtered_data as $item){
            $nama_category = $item->categories;
        }
        // dd($nama_category);
        return view('itemView.itemIndex', [
            'isLogin' => false,
            'data' => $filtered_data,
            'category' => $nama_category
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 'admin') {
            $this->authorize('isAdmin');
        }
        if (auth()->user()->role == 'owner') {
            $this->authorize('owner');
        }
        $data = Categories::get();
        // dd($data);
        return view('itemView.itemCreate', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedRequest = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock_level' => 'required|numeric',
            'categories_id' => 'required',
            'cost_price' => 'required|numeric',
            'item_image' => 'image'
        ]);

        if($request->categories_id == 'select'){
            unset($validatedRequest['categories_id']);
        }

        // dd($validatedRequest);
        if ($request->hasFile('item_image')) {
            $path = $request->file('item_image')->store('ItemImage');
            $validatedRequest['item_image'] = $path;
        }

        Item::create($validatedRequest);

        return redirect(route('items.create'))->with('success', 'Item Successfully Added');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->role == 'admin') {
            $this->authorize('isAdmin');
        }
        if (auth()->user()->role == 'owner') {
            $this->authorize('owner');
        }
        $data = Item::find($id);
        $categories = Categories::get()->all();
        return view('itemView.itemEdit', [
            'data' => $data,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedRequest = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock_level' => 'required|numeric',
            'categories_id' => 'required',
            'cost_price' => 'required|numeric',
            'item_image' => 'image',
        ]);

        if ($request->hasFile('item_image')) {
            $path = $request->file('item_image')->store('ItemImage');
            $validatedRequest['item_image'] = $path;
        }

        Item::where('id', $id)->update($validatedRequest);

        return redirect(route('items.edit', $id))->with('success', 'Data Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Item::where('id', $id)->delete();

        return redirect(route('items.index'))->with('success', 'Data Successfully Deleted');
    }
}
