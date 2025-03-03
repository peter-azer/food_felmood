<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::query()
        ->with('foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule')
        ->get();

        return response()->json($restaurants);
    }

    /**
     * search for restaurant based on the area and the food type.
     */
    public function search(Request $request)
    {
        try{
            $restaurants = Restaurant::query()
            ->where('area_id', $request->area_id)
            ->where('food_type_ids', 'LIKE', '%'.$request->food_type_id.'%')
            ->with('branches', 'foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule')
            ->get();
            
            return response()->json($restaurants);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        try{
            $restaurant->load('foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule', 'branches');
            return response()->json($restaurant);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * get all the top ranked and recommended restaurants.
     */
    public function recommended()
    {
        $recommendedRestaurants = Restaurant::query()
        ->where('Rank', '>', 4)
        ->where('recommendation', '>', 4)
        ->with('foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule', 'branches')
        ->orderBy('Rank', 'desc')
        ->get();

        return response()->json($recommendedRestaurants);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}
