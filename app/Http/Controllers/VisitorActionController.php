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
        $visitorActions = VisitorAction::all();
        return response()->json($visitorActions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVisitorActionRequest $request)
    {
        try {
            $validatedDate = $request->validate([
                'restaurant_id' => 'required|exists:restaurants,id',
                'action_type' => 'required|string', //view, click
                'ip_address' => 'required|string',
            ]);
            $visitorAction = VisitorAction::create($validatedDate);
            return response()->json(201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $visitorAction = VisitorAction::findOrFail($id);
            return response()->json($visitorAction);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $visitorAction = VisitorAction::findOrFail($id);
            $visitorAction->delete();
            return response()->json(200);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 500);
        }
    }
}
