<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Http\Requests\StoreContactUsRequest;
use App\Http\Requests\UpdateContactUsRequest;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactUsRequest $request)
    {
        try{
            $validatedData = $request->validate([
                'full_name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'subject' => 'required|string',
                'message' => 'required|string',
            ]);
            $contactUs = ContactUs::create($validatedData);   
            return response()->json(['message'=>'Thank you for Reaching Us'], 201);
        }catch(\Exception $e){
            return response()->json(['message'=>'Something went wrong'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactUsRequest $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
