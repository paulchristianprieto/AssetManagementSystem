<?php

namespace App\Http\Controllers;

use App\Category;
use App\Asset;
use App\User_request;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function filter_assets($category_id){
        // $transactions = Transaction::where('user_id', $user_id)->get();
        // dd($category);
        $assets = Asset::where('category_id', $category_id)->get();
        // dd($assets);
        $categories = Category::all();
        $user_requests = User_request::all();

        $category_available_items = [];
        $total_available =0;
        $category_lent_items = [];
        $total_lent =0;

        foreach ($categories as $category) {
            foreach ($assets as $asset) {
                if ($asset->category_id == $category->id) {
                    $total_available += $asset->quantity_available;
                }
            }
            $category_available_items[$category->id] = $total_available;
            $total_available = 0;

            // accessing pivot table
            foreach ($user_requests as $user_request) {
                // dd($user_request->assets);
                foreach ($user_request->assets as $user_request_asset) {
                    // dd($user_request_asset->category_id);
                    if($user_request_asset->pivot->asset_status == "Lent" && $user_request_asset->category_id == $category->id){
                        $total_lent += $user_request_asset->pivot->quantity;
                    }
                }
            }
            $category_lent_items[$category->id] = $total_lent;

            $total_lent = 0;
        }
        // dd($category_available_items, $category_lent_items);

        foreach ($user_requests as $user_request) {
            foreach ($user_request->assets as $user_request_asset) {
                // dd($user_request_asset);
            }
        }

        $lent_items = [];
        // accessing pivot table
        foreach ($assets as $asset) {
            $temp =0;
            // echo $asset->id;
            $lent_items[$asset->id] =0;
            foreach ($user_requests as $user_request) {
                // dd($user_request->assets);
                foreach ($user_request->assets as $user_request_asset) {
                    // dd($user_request_asset->pivot->asset_id);
                    // dd( $user_request_asset->pivot->quantity);
                    // dd($asset);

                    if($user_request_asset->pivot->asset_status == "Lent" && $user_request_asset->pivot->asset_id == $asset->id){
                        $temp += $user_request_asset->pivot->quantity;

                        // echo $user_request_asset->pivot->quantity;
                    }
                }
            }
            $lent_items[$asset->id] = $temp;
        }
        
        // dd($total_available);

        return view('categories.index')->with('categories', $categories)
            ->with('assets', $assets)
            ->with('category_available_items', $category_available_items)
            ->with('category_lent_items', $category_lent_items)
            ->with('category_id', $category_id)
            ->with('lent_items',$lent_items);
    }

    //not used
    // public function index()
    // {
    //     $categories = Category::all();
    //     $assets = Asset::all();
    //     $user_requests = User_request::all();

    //     $category_available_items = [];
    //     $total_available =0;
    //     $category_lent_items = [];
    //     $total_lent =0;

    //     foreach ($categories as $category) {
    //         foreach ($assets as $asset) {
    //             if ($asset->category_id == $category->id) {
    //                 $total_available += $asset->quantity_available;
    //             }
    //         }
    //         $category_available_items[$category->id] = $total_available;
    //         $total_available = 0;

    //         // accessing pivot table
    //         foreach ($user_requests as $user_request) {
    //             // dd($user_request->assets);
    //             foreach ($user_request->assets as $user_request_asset) {
    //                 // dd($user_request_asset->category_id);
    //                 if($user_request_asset->pivot->asset_status == "Lent" && $user_request_asset->category_id == $category->id){
    //                     $total_lent += $user_request_asset->pivot->quantity;
    //                 }
    //             }
    //         }
    //         $category_lent_items[$category->id] = $total_lent;

    //         $total_lent = 0;
    //     }
    //     // dd($category_available_items, $category_lent_items);

    //     return
        

    //     return view('categories.index')->with('categories', $categories)
    //         ->with('assets', $assets)
    //         ->with('category_available_items', $category_available_items)
    //         ->with('category_lent_items', $category_lent_items);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Category $category)
    {
        $this->authorize('create', $category);
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        // dd($request->all());
        $this->authorize('create', $category);
        // validate

        $request->validate([
            'name' => 'required|string',
            'category_sku' => 'required|string|max:4|unique:categories,category_sku',
            // 'image' => 'required|image|max:30000',
            'description' => 'nullable|string|max:191'
        ]);

        $new_category = new Category;
        $new_category->name = $request->input('name');
        $new_category->category_sku = $request->input('category_sku');

        $new_category->save();

        $request->session()->flash('category_message', 'Category successfully added!');

        return redirect(route('category_filtered_assets', ['category_id'=>1]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // dd($category);
        $categories = Category::all();
        return view('categories.show')
            ->with('category', $category)
            ->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
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
        $this->authorize('update', $category);
        $request->validate([
            'name' => 'required|string',
            'category_sku' => 'required|string|max:4|unique:categories,category_sku',
            // 'image' => 'required|image|max:30000',
            'description' => 'nullable|string|max:191'
        ]);
        
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
        $this->authorize('delete', $category);
        $category->delete();
        return redirect(route('categories.index'))->with('destroy_success', 'Category Removed.');
    }
}
