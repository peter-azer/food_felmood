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
     * Store a newly created resource in storage.
     */
    public function store(StoreFoodTypeRequest $request)
    {
        try{
            $validated = $request->validated();
            $foodType = FoodType::create($validated);
            return response()->json(['message' => 'Food Type created successfully!']); 
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 404);
        }
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
     * Update the specified resource in storage.
     */
    public function update(UpdateFoodTypeRequest $request, $id)
    {
        try{
            $validated = $request->validated();
            $type = FoodType::findOrFail($id);
            $type->update($validated);
            return response()->json(['message' => 'Food Type updated successfully!']);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 404);
        }
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
