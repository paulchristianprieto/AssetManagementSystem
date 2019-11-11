<?php

namespace App\Http\Controllers;

use App\User_request;
use App\Category;
use App\Status;
use App\Asset;
use App\Asset_status;

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
    public function index(User_request $user_request)
    {
        $this->authorize('viewAny', $user_request);
        $statuses = Status::all();
        $categories = Category::all();
        $assets = Asset::all();
        $user_requests = User_request::all();
        $asset_statuses = Asset_status::all();
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

        if (Auth::user()->role_id === 2) {
            $user_id = Auth::user()->id;
            $userRequests = User_request::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();
            return view('user_requests.index')
                ->with('userRequests', $userRequests)
                ->with('statuses', $statuses)
                ->with('assets', $assets)
                ->with('lent_items', $lent_items)
                ->with('asset_statuses', $asset_statuses)
                ->with('categories', $categories);
        }

        if (Auth::user()->role_id === 1) {
            $userRequests = User_request::orderBy('created_at', 'DESC')->get();
            return view('user_requests.index')
                ->with('userRequests', $userRequests)
                ->with('statuses', $statuses)
                ->with('assets', $assets)
                ->with('lent_items', $lent_items)
                ->with('asset_statuses', $asset_statuses)
                ->with('categories', $categories);
        }

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Category $category, User_request $user_request)
    {
        // dd($request);
        $this->authorize('create', $user_request);

        return view('user_requests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User_request $user_request)
    {
        $this->authorize('create', $user_request);
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
        
        
        $request->validate([
            'borrow_date' => "required|date|before:return_date",
            'return_date' => "required|date",
            'description' => "nullable|string|max:191",
            'category_id' => "required",
            'quantity' => "required|digits_between:1,9999"
        ]);

        

        $request_number = Auth::user()->id . "_" . Str::random(10) . "_" . time();
        $description = $request->input('description');
        $borrow_date = $request->input('borrow_date');
        $return_date = $request->input('return_date');

        $borrow_date = date('Y-m-d H:i:s', strtotime($borrow_date)); 
        $return_date = date('Y-m-d H:i:s', strtotime($return_date)); 
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
        $this->authorize('view', $user_request);

        
        $assets = Asset::all();
        $asset_statuses = Asset_status::all();
        $category_items = Asset::where('category_id', $user_request->category_id)->get();
        // $userRequests = User_request::where('user_id', $user_id)->orderBy('created_at', 'DESC')->get();


        $user_requests = User_request::all();
        $lent_items = [];
        // accessing pivot table
        foreach ($assets as $asset) {
            $temp =0;
            // echo $asset->id;
            $lent_items[$asset->id] =0;
            foreach ($user_requests as $user_request_from_array) {
                // dd($user_request->assets);
                foreach ($user_request_from_array->assets as $user_request_asset) {
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
        // dd($user_request->id);

        if($user_request->asset_id){
            $asset = Asset::find($user_request->asset_id);
            return view('user_requests.show', ['user_request'=>$user_request])
                ->with('category_items', $category_items)
                ->with('asset', $asset)
                ->with('assets', $assets)
                ->with('user_requests', $user_requests)
                ->with('asset_statuses', $asset_statuses)
                ->with('lent_items', $lent_items);
        }


        
        return view('user_requests.show', ['user_request'=>$user_request])
            ->with('category_items', $category_items)
            ->with('assets', $assets)
            ->with('user_requests', $user_requests)
            ->with('lent_items', $lent_items);
        
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
        $this->authorize('update', $user_request);
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
        $this->authorize('delete', $user_request);
        $user_request->delete();
        // return redirect(route('category_filtered_assets', ['category_id'=>1]))->with('request_destroy_success', 'User request declined.');
        return redirect(route('user_requests.index'))->with('request_destroy_success', 'User request declined.');
        
    }

    public function request_category(Category $category_id, User_request $user_request){
        // dd($category_id);
        $this->authorize('create', $user_request);
        return view('user_requests.create')->with('category', $category_id);
    }

    public function approve(Request $request, User_request $user_request)
    {
        $this->authorize('update', $user_request);
        // dd( $request->input('asset_id') );
        // dd($user_request);
        /*
        "id" => 4
        "request_number" => "1_nOyLxCW55E_1573136969"
        "description" => "12"
        "borrow_date" => "2020-01-01 01:00:00"
        "return_date" => "2019-01-01 01:00:00"
        "quantity" => 2
        "status_id" => 1
        "user_id" => 1
        "category_id" => 1
        "asset_id" => null
        "created_at" => "2019-11-07 14:29:29"
        "updated_at" => "2019-11-07 14:29:29"
        "deleted_at" => null
        */

        // $products = Product::find($cart_ids);
        // $assets_quantities = $request->input('quantity');
        // $assets_items = $request->input('category_item_id');


        // validate if quantity is less than available quantity // this wont show in UI but no validation yet in backend
        $this->authorize('update', $user_request);

        $asset = Asset::find($request->input('asset_id'));

        $user_request->assets()->attach(
            $asset->id,
            [
                'quantity' => $user_request->quantity
            ]
        );

        $assigned_items;

        // foreach ($assets_items as $asset_item => $asset_id) {
        //     foreach ($assets_quantities as $assets_quantity => $quantity) {
        //         if ($asset_item == $assets_quantity ) {
        //             $assigned_items[$asset_id] = $quantity;
        //         }
        //     }
        // }


        // foreach ($assigned_items as $asset_id => $quantity) {
        //     foreach ($assets as $asset) {
        //         if ($asset_id == $asset->id) {
        //             $user_request->assets()->attach(
        //             $asset->id,
        //             [
        //                 'quantity' => $quantity
        //             ]
        //             );
        //         }
        //     }
        // }
        
        // $user_request->asset_id

        $asset->quantity_available = $asset->quantity_available - $user_request->quantity;
        if ($asset->quantity_available < 1) {
            $asset->available = false;
        }
        $asset->save();
        $user_request->asset_id = $request->input('asset_id');
        $user_request->status_id = 2;
        $user_request->save();

        return redirect(route('user_requests.show', ['user_request' => $user_request->id]));
    }

    public function assign(User_request $user_request){
        // dd($user_request);

        $this->authorize('update', $user_request);
        $assets = Asset::all();
        return view('user_requests.assign')->with('user_request', $user_request)->with('assets', $assets);
    }

    public function return_page(User_request $user_request){
        // dd($user_request);
        $this->authorize('update', $user_request);
        $assets = Asset::all();
        return view('user_requests.return')->with('user_request', $user_request)->with('assets', $assets);
    }

    public function return_asset(Request $request, User_request $user_request){
        // dd($user_request);
        // dd($request->all());
        $this->authorize('update', $user_request);
        $asset = Asset::find($request->input('asset_id'));
        // dd($user_request);
        // $user_request->pivot->asset_status = "Returned";
            
        // $transaction_products = $transaction->products;
        // dd($transaction_products);
        // foreach ($transaction_products as $product) {
        //     dd($product->pivot);
        //     $total += $product->pivot->subtotal;
        // }


        // dd($user_request->assets);
        // foreach ($user_request->assets as $asset) {

        //     $asset->pivot->asset_status = "Returned";
        // }


        // updating pivot table
        $user_request->assets()->updateExistingPivot($request->input('asset_id'), ['asset_status' => 'Returned'] );

        // dd($user_request->assets);
        // dd($user_request->asset);
        // $user_request_assets = $user_request->asset_id; 
        

        
        // $user_request->asset_id

        $asset->quantity_available = $asset->quantity_available + $user_request->quantity;
        if ($asset->quantity_available > 0) {
            $asset->available = true;
        }
        $asset->save();

        $user_request->asset_id = $request->input('asset_id');
        $user_request->status_id = 3;
        $user_request->save();

        return redirect(route('user_requests.show', ['user_request' => $user_request->id]));
    }

    

}
