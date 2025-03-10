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
        $forms = ContactUs::all();
        return response()->json($forms);
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
    public function show($id)
    {
        try{
            $form = ContactUs::find($id);
            return response()->json($form);
        }catch(\Exception $e){
            return response()->json(['message'=>'Something went wrong'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $form = ContactUs::find($id);
            $form->delete();
            return response()->json(['message'=>'Form Deleted Successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['message'=> $e->getMessage()], 500);
        }
    }
}
