<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\RestaurantBranch;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::query()
            ->with('branches','foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule')
            ->get();

        return response()->json($restaurants);
    }

    /**
     * search for restaurant based on the area and the food type.
     */
    public function search(Request $request)
    {
        try {
            $branches = RestaurantBranch::query()
                ->where('area_id', $request->area_id)
                ->get();
            $restaurants = Restaurant::query()
                ->whereIn('id', $branches->pluck('restaurant_id'))
                ->where('food_type_ids', $request->food_type_ids)
                ->with('branches', 'foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule')
                ->get();

            return response()->json($restaurants);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
    public function recommended()
    {
        try {
            $restaurant = Restaurant::query()
                ->where('Rank', '>=', 4)
                ->where('recommendation', '>=', 4)
                ->with('foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule', 'branches')
                ->orderBy('Rank', 'desc')
                ->get();
            return response()->json($restaurant);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        try{
                $validatedData = $request->validated();
                //Handle image and logo upload
                $logo = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/logos', $logo);

                $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/thumbnails', $thumbnail);

                $imgs = [];
                if($request->hasFile('images')){
                    $images = $request->file('images');
                    foreach($images as $image){
                        $image->storeAs('public/images', $image->getClientOriginalName());
                        $imgs [] = $image->getClientOriginalName();
                    }
                    $validatedData['images'] = $imgs;
                }
            
                $restaurant = Restaurant::create($validatedData);
            
                return response()->json(['message' => 'Product Created Successfully']);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $restaurant = Restaurant::query()
                ->where('id', $id)
                ->with('foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule', 'branches')
                ->get();
            return response()->json($restaurant);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $restaurant = Restaurant::findOrFail($id);

            // Handle image and logo upload
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->storeAs('public/logos', $logo);
                $validatedData['logo'] = $logo;
            }

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                $request->file('thumbnail')->storeAs('public/thumbnails', $thumbnail);
                $validatedData['thumbnail'] = $thumbnail;
            }
            
            $imgs = [];
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $image->storeAs('public/images', $image->getClientOriginalName());
                    $imgs [] = $image->getClientOriginalName();
                }
                $validatedData['images'] = $imgs;
            }

            $restaurant->update($validatedData);

            return response()->json(['message' => 'Restaurant updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();
            return response()->json(['message' => 'Restaurant deleted successfully!']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }
}
