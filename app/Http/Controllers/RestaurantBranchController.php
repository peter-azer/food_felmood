<?php

namespace App\Http\Controllers;

use App\Models\RestaurantBranch;
use App\Http\Requests\StoreRestaurantBranchRequest;
use App\Http\Requests\UpdateRestaurantBranchRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'menu' => 'required|array',
                'menu.*' => 'required|image',
                'restaurant_id' => 'required|integer|exists:restaurants,id',
                'area_id' => 'required|integer|exists:areas,id',
                'branch_code' => 'required|string|max:255',
                'phone_number' => 'required|string|max:255',
                'optional_phone_number' => 'nullable|string|max:255',
                'location' => 'required|string|max:255',
                'address' => 'required|string|max:255',
            ]);

            //Handle menu images upload 
            $menu = [];
            if ($request->hasFile('menu') && is_array($request->file('menu'))) {
                $pages = $request->file('menu');
                foreach ($pages as $page) {
                    $pagePath = $page->store('menus', 'public');
                    $menu[] = URL::to(Storage::url($pagePath));
                }
                $validatedData['menu'] = implode(',', $menu);
            }

            $branch = RestaurantBranch::create($validatedData);
            return response()->json(["message" => "Branch Added Successfully!"]);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $branch = RestaurantBranch::findOrFail($id);
            return response()->json($branch);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'menu' => 'sometimes|array',
                'menu.*' => 'sometimes|image',
                'restaurant_id' => 'sometimes|integer|exists:restaurants,id',
                'area_id' => 'sometimes|integer|exists:areas,id',
                'branch_code' => 'sometimes|string|max:255',
                'phone_number' => 'sometimes|string|max:255',
                'optional_phone_number' => 'nullable|string|max:255',
                'location' => 'sometimes|string|max:255',
                'address' => 'sometimes|string|max:255',
            ]);
            $branch = RestaurantBranch::findOrFail($id);

            //Handle menu images upload
            $menu = [];
            $oldMenu = explode(',', $branch->menu);
            if ($request->hasFile('menu')) {
                $pages = $request->file('menu');
                   // Delete the old images if they exist
                   foreach ($oldMenu as $oldImage) {
                       Storage::dist('public')->delete($oldImage);
                   }
                foreach ($pages as $page) {
                    $pagePath = $page->store('menus', 'public');
                    $menu[] = URL::to(Storage::url($pagePath));
                }
                $validatedData['menu'] = implode(',', $menu);
            }
            $branch->update($validatedData);
            return response()->json(['message' => 'Branch updated successfully!']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $branch = RestaurantBranch::find($id);
            $branch->delete();
            return response()->json(['message' => 'Branch deleted successfully!']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }
}
