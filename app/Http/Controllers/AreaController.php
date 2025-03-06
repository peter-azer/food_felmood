<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Http\Requests\StoreAreaRequest;
use App\Http\Requests\UpdateAreaRequest;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $area = Area::all();
        return response()->json($area);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAreaRequest $request)
    {
        try{
            $validatedData = $request->validated();
            $area = Area::create($validatedData);
            return response()->json(['message' => 'Area created successfully!']);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $area = Area::findOrFail($id);
        return response()->json($area);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAreaRequest $request, $id)
    {
        try{
            $validatedData = $request->validated();
            $area = Area::findOrFail($id);
            $area->update($validatedData);
            return response()->json(['message' => 'Area updated successfully!']);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $area = Area::find($id);
            $area->delete();
            return response()->json(['message' => 'Area deleted successfully!']);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }
}
