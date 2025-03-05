<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Http\Requests\StoreFoodTypeRequest;
use App\Http\Requests\UpdateFoodTypeRequest;

class FoodTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodTypes = FoodType::all();
        return response()->json($foodTypes);
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
    public function store(StoreFoodTypeRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $foodType = FoodType::find($id);
            return response()->json($foodType);
        }catch(\Exception $e){
            return response()->json(['message' => 'Food Type not found!'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodType $foodType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodTypeRequest $request, FoodType $foodType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $type = FoodType::find($id);
            $type->delete();
            return response()->json(['message' => 'Food Type deleted successfully!']);        
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
