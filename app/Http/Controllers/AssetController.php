<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;

use App\Vendor;
use App\Category;
use DB;
use Str;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assets = Asset::all();
        return view('assets.index')->with('assets', $assets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::all();
        $categories = Category::all();
        return view('assets.create')->with('vendors', $vendors)->with('categories', $categories);
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

        $file = $request->file('image');
        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $file_extension = $file->extension();
        $random_chars = Str::random(10);
        $new_file_name = date('Y-m-d-H-i-s') . "_" . $random_chars . "_" . $file_name . "." . $file_extension;
        $file_path = $file->storeAs('images', $new_file_name, 'public');

        

        

        $name = $request->input('name');
        $image = $file_path;
        $description = $request->input('description');
        $quantity_available = $request->input('quantity');
        $category_id = $request->input('category');
        $vendor_id = $request->input('vendor');

        $vendor = Vendor::find($vendor_id);
        $category = Category::find($category_id);

        // dd($vendor->vendor_sku);
        // dd($category->category_sku);

        //generate sku number
        $sku_number = $vendor->vendor_sku . "_" . $category->category_sku . "_" . "_" . Str::random(5) . "_" . date('Y-m-d-H-i-s') ;

        $available = true;
        $asset_status_id = 1;

        $asset = new Asset;
        $asset->name = $name;
        $asset->image = $image;
        $asset->description = $description;
        $asset->quantity_available = $quantity_available;
        $asset->sku_number = $sku_number;
        $asset->available = $available;

        $asset->asset_status_id = $asset_status_id;
        $asset->category_id = $category_id;
        $asset->vendor_id = $vendor_id;
        $asset->save();

        return redirect(route( 'assets.show', ['asset' => $asset->id] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function show(Asset $asset)
    {

        return view('assets.show')->with('asset', $asset);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function edit(Asset $asset)
    {
        $vendors = Vendor::all();
        $categories = Category::all();
        return view('assets.edit')->with('asset', $asset)->with('vendors', $vendors)->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asset $asset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        //
    }
}
