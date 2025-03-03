<?php

namespace App\Http\Controllers;

use App\Models\VisitorAction;
use App\Http\Requests\StoreVisitorActionRequest;
use App\Http\Requests\UpdateVisitorActionRequest;

class VisitorActionController extends Controller
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
    public function store(StoreVisitorActionRequest $request)
    {
        try{
            $validatedDate = $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id',
                'action_type' => 'required|string', //view, click
                'ip_address' => 'required|string',
            ]);
            $visitorAction = VisitorAction::create($validatedDate);
            return response()->json($visitorAction, 201);
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VisitorAction $visitorAction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VisitorAction $visitorAction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVisitorActionRequest $request, VisitorAction $visitorAction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisitorAction $visitorAction)
    {
        //
    }
}
