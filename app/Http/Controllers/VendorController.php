<?php

namespace App\Http\Controllers;

use App\Vendor;
use Illuminate\Http\Request;
use Str;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendors.index')->with('vendors', $vendors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vendors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([]);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
