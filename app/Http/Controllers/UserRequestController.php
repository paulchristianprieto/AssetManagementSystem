<?php

namespace App\Http\Controllers;

use App\User_request;
use App\Category;
use Illuminate\Http\Request;

class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            request_number
            description -> nullable
            borrow_date
            return_date
            status_id (pending)
            user_id
            category_id
            asset_id (to be assigned)
        */

        dd($request->all());
        echo "IM STORE";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_request  $user_request
     * @return \Illuminate\Http\Response
     */
    public function show(User_request $user_request)
    {
        //
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
        //
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

}
