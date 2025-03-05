<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use App\Http\Requests\StoreNewsletterRequest;
use App\Http\Requests\UpdateNewsletterRequest;

class NewsletterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $newsletters = Newsletter::all();
        return response()->json($newsletters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNewsletterRequest $request)
    {
        try{
            $validatedData = $request->validate([
                'email' => 'required|email',
            ]);

            $newsletter = Newsletter::create($validatedData);
            return response()->json(['message'=>'Thank you for subscribing'], 201); 
        }catch(\Exception $e){
            return response()->json(['message'=>'Something went wrong'], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Newsletter $newsletter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNewsletterRequest $request, Newsletter $newsletter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $newsletter = Newsletter::findOrFail($id);
            $newsletter->delete();
            return response()->json(['message'=>'Newsletter deleted successfully'], 200);
        }catch(\Exception $e){
            return response()->json(['message'=> $e->getMessage()], $e->getCode());
        }
    }
}
