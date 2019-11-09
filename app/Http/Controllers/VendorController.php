<?php

namespace App\Http\Controllers;

use App\Vendor;
use App\Asset;
use App\User_request;

use Illuminate\Http\Request;
use Str;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Vendor $vendor)
    {
        $this->authorize('viewAny', $vendor);
        $user_requests = User_request::all();
        $vendors = Vendor::all();
        $assets = Asset::all();
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
        return view('vendors.index')
            ->with('vendors', $vendors)
            ->with('lent_items', $lent_items)
            ->with('assets', $assets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Vendor $vendor)
    {
        $this->authorize('create', $vendor);
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Vendor $vendor)
    {
        $this->authorize('create', $vendor);
        // $request->validate([]);
        // $request->validate([
        //     'name' => 'required|string',
        //     'price' => 'required|numeric',
        //     'category' => 'required',
        //     'image' => 'required|image|max:30000',
        //     'description' => 'required|string'
        // ]);



        // dd($request);

        $request->validate([
            "sku_id" => 'required|string|max:4|unique:vendors,vendor_sku',
            "name" => 'required|string',
            "address" => 'nullable|string',
            'image' => 'image|max:30000',
            "company_email" => 'email:rfc',
            "description" => 'nullable|string'
        ]);

        $name = $request->input('name');
        $vendor_sku = $request->input('sku_id');
        $address = $request->input('address');
        $company_email = $request->input('company_email');
        $description = $request->input('description');

        $vendor = new Vendor;

        if($request->file('image')){
            // when request have image
            $file = $request->file('image');
            $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file_extension = $file->extension();
            $random_chars = Str::random(10);
            $new_file_name = date('Y-m-d-H-i-s') . "_" . $random_chars . "_" . $file_name . "." . $file_extension;
            $file_path = $file->storeAs('images', $new_file_name, 'public');
            $image = $file_path;


            $vendor->image = $image;
        }
        
        
        $vendor->name = $name;
        $vendor->vendor_sku = $vendor_sku;
        $vendor->address = $address;
        $vendor->company_email = $company_email;
        $vendor->description = $description;
        $vendor->save();
        

        return redirect(route( 'vendors.show', ['vendor' => $vendor->id] ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        $this->authorize('view', $vendor);
        return view('vendors.show')->with('vendor', $vendor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        $this->authorize('update', $vendor);
        return view('vendors.edit')->with('vendor', $vendor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $this->authorize('update', $vendor);
        // validate

        $name = $request->input('name');
        $vendor_sku = $request->input('sku_id');
        $address = $request->input('address');
        $company_email = $request->input('company_email');
        $description = $request->input('description');


        if( !$request->hasFile('image') &&
            $vendor->name == $name &&
            $vendor->vendor_sku == $vendor_sku &&
            $vendor->address == $address &&
            $vendor->company_email == $company_email &&
            $vendor->description == $description 
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

                $vendor->image = $image;
            }
            
            $vendor->name = $name;
            $vendor->vendor_sku = $vendor_sku;
            $vendor->address = $address;
            $vendor->company_email = $company_email;
            $vendor->description = $description;
            $vendor->save();

            $request->session()->flash('update_success', 'Vendor information successfully updated.');
        }

        return redirect(route('vendors.edit', ['vendor' => $vendor->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        $this->authorize('delete', $vendor);
        $vendor->delete();
        return redirect(route('vendors.index'))->with('destroy_success', 'Vendor Removed.');
    }
}
