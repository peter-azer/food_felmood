<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantBranch;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Services\CodeGenerator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = Restaurant::query()
            ->with('branches', 'foodTypes', 'socialMediaURL', 'visits', 'weeklySchedule')
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
    public function store(Request $request)
    {
        try {
            //generate a unique restaurant code
            $restaurantCode = CodeGenerator::generateCode();
            $validatedData = $request->validate([
                'food_type_ids' => 'required|array',
                'food_type_ids.*' => 'required|integer|exists:food_types,id',
                'name' => 'required|string',
                'name_ar' => 'required|string',
                'logo' => 'required|image',
                'thumbnail' => 'required|image',
                'description' => 'required|string',
                'description_ar' => 'required|string',
                'slug' => 'required|string',
                'slug_ar' => 'required|string',
                'Rank' => 'required|integer|min:0',
                'recommendation' => 'required|integer|min:0',
                'cost' => 'required|string',
                'restaurant_code' => 'required|string',
                'images' => 'required|array',
                'images.*' => 'required|image',
                'hotline' => 'required|string',
            ]);
            //Handle image and logo upload
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validatedData['logo'] = URL::to(Storage::url($logoPath));
            }
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
                $validatedData['thumbnail'] = URL::to(Storage::url($thumbnailPath));
            }

            $imgs = [];
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imagePath = $image->store('images', 'public');
                    $imgs[] = URL::to(Storage::url($imagePath));
                }
                $validatedData['images'] = json_encode($imgs);
            }
            $validatedData['restaurant_code'] = $restaurantCode;
            $restaurant = Restaurant::create($validatedData);

            return response()->json(["message" => "Restaurant created successfully!"], 201);
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
                    $imgs[] = $image->getClientOriginalName();
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
