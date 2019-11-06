<?php

namespace App\Http\Controllers;

use App\Category;
use App\Asset;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $assets = Asset::all();
        return view('categories.index')->with('categories', $categories)->with('assets', $assets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // validate

        $new_category = new Category;
        $new_category->name = $request->input('name');
        $new_category->category_sku = $request->input('category_sku');

        $new_category->save();

        $request->session()->flash('category_message', 'Category successfully added!');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $name = $request->input('name');
        $category_sku = $request->input('category_sku');
        $description = $request->input('description');
        
        if( $category->name == $name &&
            $category->description == $description &&
            $category->category_sku == $category_sku 
        )
            $request->session()->flash('update_failed','There are no changes made.');

        else {
            $category->name = $name;
            $category->category_sku = $category_sku; 
            $category->description = $description;
            $category->save();

            $request->session()->flash('update_success', 'Category information successfully updated.');
        }

        return redirect(route('categories.edit', ['category' => $category->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('categories.index'))->with('destroy_success', 'Category Removed.');
    }
}
