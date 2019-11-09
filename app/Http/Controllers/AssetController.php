<?php

namespace App\Http\Controllers;

use App\Asset;
use Illuminate\Http\Request;

use App\Vendor;
use App\Asset_status;
use App\Category;
use App\User_request;
use DB;
use Str;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Asset $asset)
    {
        $this->authorize('viewAny', $asset);
        $assets = Asset::all();
        $user_requests = User_request::all();
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
        // dd($lent_items);
        // $lent_items = User_request::find($ass)

        $categories = Category::all();
        $vendors = Vendor::all();
    
        return view('assets.index')
            ->with('assets', $assets)
            ->with('lent_items', $lent_items)
            ->with('categories', $categories)
            ->with('vendors', $vendors);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Asset $asset)
    {
        $this->authorize('create', $asset);
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
    public function store(Request $request,Asset $asset)
    {

        $this->authorize('create', $asset);
        // dd($request->all());
        // "name" => "123"
        // "quantity" => "123"
        // "description" => "123"
        // "vendor" => "1"
        // "category" => "3"
        $request->validate([
            "name" => "required|string",
            "quantity" => "required|digits_between:1,9999",
            "description" => "required|string|max:191",
            "vendor" => "required",
            "category" => "required",
            "image" => "required|image|max:30000"
        ]);

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
        $sku_number = $vendor->vendor_sku . "_" . $category->category_sku . "_" . Str::random(5) . "_" . date('mHdYis') ;

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
        $this->authorize('update', $asset);
        $vendors = Vendor::all();
        $categories = Category::all();
        $asset_statuses = Asset_status::all();
        return view('assets.edit')
            ->with('asset', $asset)
            ->with('vendors', $vendors)
            ->with('categories', $categories)
            ->with('asset_statuses', $asset_statuses);
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
        $this->authorize('update', $asset);
        
        $available = $request->input('available');
        $name = $request->input('name');
        $quantity_available = $request->input('quantity');
        $description = $request->input('description');
        $asset_status_id = $request->input('asset_status_id');
        $category_id = $request->input('category');
        $vendor_id = $request->input('vendor');
        

        if( !$request->hasFile('image') &&
            $asset->name == $name &&
            $asset->quantity_available == $quantity_available &&
            $asset->description == $description &&
            $asset->asset_status_id == $asset_status_id &&
            $asset->available == $available &&
            $asset->category_id == $category_id &&
            $asset->vendor_id == $vendor_id
        )
            $request->session()->flash('update_failed','There are no changes made.');
        else {

            if($request->file('image')){
                $file = $request->file('image');
                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_extension = $file->extension();
                $random_chars = Str::random(10);
                $new_file_name = date('Y-m-d-H-i-s') . "_" . $random_chars . "_" . $file_name . "." . $file_extension;
                $file_path = $file->storeAs('images', $new_file_name, 'public');
                $image = $file_path;

                $asset->image = $image;
            }

            $asset->name = $name;
            $asset->quantity_available = $quantity_available;
            $asset->description = $description;
            $asset->asset_status_id = $asset_status_id;
            $asset->available = $available;
            $asset->category_id = $category_id;
            $asset->vendor_id = $vendor_id;
            $asset->save();

            $request->session()->flash('update_success', 'Asset information successfully updated.');
        }

        return redirect(route('assets.edit', ['asset' => $asset->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Asset  $asset
     * @return \Illuminate\Http\Response
     */
    public function destroy(Asset $asset)
    {
        $this->authorize('update', $asset);
        $asset->delete();
        return redirect(route('assets.index'))->with('destroy_success', 'Asset Removed.');    
    }
}
