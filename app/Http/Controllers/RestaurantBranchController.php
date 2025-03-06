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
        try{
            $validatedData = $request->validated();
            
            //Handle menu images upload 
            $imgs = [];
            if($request->hasFile('menu')){
                $images = $request->file('menu');
                foreach($images as $image){
                    $image->storeAs('public/menus', $image->getClientOriginalName());
                    $imgs[]= $image->getClientOriginalName();
                }
                $validatedData['menu'] = $imgs;
            }

            $branch = RestaurantBranch::create($validatedData);
            return response()->json(["message" => "Branch Added Successfully!"]);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 500);
        }
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
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantBranchRequest $request, $id)
    {
        try{
            $validatedData = $request->validated();
            $branch = RestaurantBranch::findOrFail($id);

            //Handle menu images upload
            $imgs = [];
            if($request->hasFile('menu')){
                $images = $request->file('menu');
                foreach($images as $image){
                    $image->storeAs('public/menus', $image->getClientOriginalName());
                    $imgs[]= $image->getClientOriginalName();
                }
                $validatedData['menu'] = $imgs;
            }
            $branch->update($validatedData);
            return response()->json(['message' => 'Branch updated successfully!']);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], 500);
        }
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
