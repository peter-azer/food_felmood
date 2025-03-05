<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBranch;
use App\Http\Requests\StoreRestaurantBranchRequest;
use App\Http\Requests\UpdateRestaurantBranchRequest;

class RestaurantBranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurantBranches = RestaurantBranch::selectRaw('restaurant_id, COUNT(*) as branch_count')
        ->groupBy('restaurant_id')
        ->with('restaurant')
        ->get();

        return response()->json($restaurantBranches);
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
    public function store(StoreRestaurantBranchRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
            $branch = RestaurantBranch::findOrFail($id);
            return response()->json($branch);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RestaurantBranch $restaurantBranch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantBranchRequest $request, RestaurantBranch $restaurantBranch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $branch = RestaurantBranch::find($id);
            $branch->delete();
            return response()->json(['message' => 'Branch deleted successfully!']);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }
}
