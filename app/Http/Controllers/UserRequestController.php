<?php

namespace App\Http\Controllers;

use App\User_request;
use App\Category;
use App\Status;
use App\Asset;

use Illuminate\Http\Request;

use Auth;
use Str;

class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();

        if (Auth::user()->role_id === 2) {
            $user_id = Auth::user()->id;
            $userRequests = User_request::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();
            return view('user_requests.index')
                ->with('userRequests', $userRequests)
                ->with('statuses', $statuses);
        }
        
        if (Auth::user()->role_id === 1) {
            $userRequests = User_request::orderBy('created_at', 'DESC')->get();
            return view('user_requests.index')
                ->with('userRequests', $userRequests)
                ->with('statuses', $statuses);
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Category $category)
    {
        dd($request);
        return view('user_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        "category_id" => "2"
        "borrow_date" => "11/30/2019"
        "request_date" => "11/22/2019"
        "quantity" => "7"
            request_number
            description -> nullable
            borrow_date
            return_date
            status_id (pending) may default sa migration
            user_id
            category_id
            asset_id (to be assigned)
        */
        // dd(Auth::user()->id);
        // dd($request->all());

        $request_number = Auth::user()->id . "_" . Str::random(10) . "_" . time();
        $description = $request->input('description');
        $borrow_date = $request->input('borrow_date');
        $return_date = $request->input('return_date');
        $user_id = Auth::user()->id;
        $category_id = $request->input('category_id');

        $userRequest = new User_request;
        $userRequest->request_number = $request_number; 
        $userRequest->description = $description; 
        $userRequest->borrow_date = $borrow_date; 
        $userRequest->return_date = $return_date; 
        $userRequest->user_id = $user_id; 
        $userRequest->category_id = $category_id; 
        $userRequest->quantity = $request->input('quantity'); 
        $userRequest->save();

        return redirect(route('user_requests.show', ['user_request' => $userRequest->id ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_request  $user_request
     * @return \Illuminate\Http\Response
     */
    public function show(User_request $user_request)
    {
        // $userRequests = User_request::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();
        
        $category_items = Asset::where('category_id', $user_request->category_id)->get();

        return view('user_requests.show', ['user_request'=>$user_request])->with('category_items', $category_items);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_request  $user_request
     * @return \Illuminate\Http\Response
     */
    public function edit(User_request $user_request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_request  $user_request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_request $user_request)
    {
        // dd($request->all());
        /*
          "request_id" => "4"
          "quantity" => array:2 [▼
            0 => "120"
            1 => "3"
          ]
          "category_item_id" => array:2 [▼
            0 => "3"
            1 => "2"
        */

        // $products = Product::find($cart_ids);
        $assets_quantities = $request->input('quantity');
        $assets_items = $request->input('category_item_id');

        // dd($assets_items, $assets_quantities);

        $assets = Asset::find($assets_items);
        
        // dd($user_request);
        // dd($assets, $assets_quantities, $assets_items);

        $assigned_items;
        $array = [];

        foreach ($assets_items as $asset_item => $asset_id) {
            foreach ($assets_quantities as $assets_quantity => $quantity) {
                if ($asset_item == $assets_quantity ) {
                    $assigned_items[$asset_id] = $quantity;
                    // $array[$asset_id] = $quantity;
                }
            }
        }


        foreach ($assigned_items as $asset_id => $quantity) {
            foreach ($assets as $asset) {
                if ($asset_id == $asset->id) {
                    $user_request->assets()->attach(
                    $asset->id,
                    [
                        'quantity' => $quantity
                    ]
                    );
                }
            }
        }
        

        // $user_request->asset_id

        $user_request->status_id = 2;
        $user_request->save();

        return redirect(route('user_requests.show', ['user_request' => $user_request->id]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_request  $user_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_request $user_request)
    {
        //
    }

    public function request_category(Category $category_id){
        // dd($category_id);
        return view('user_requests.create')->with('category', $category_id);
    }

    public function return_asset(){


        echo "Im returning my asset";
    }

}
