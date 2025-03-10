<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Http\Requests\StoreblogRequest;
use App\Http\Requests\UpdateblogRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = blog::all();
        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreblogRequest $request)
    {
        try {
            $validatedData = $request->validated();

            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('blogs_covers', 'public');
                $validatedData['cover'] = URL::to(Storage::url($coverPath));
            }
            $blog = blog::create($validatedData);
            return response()->json(['message' => 'blog created successfully']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $blog = blog::findOrFail($id);
            return response()->json($blog);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateblogRequest $request, $id)
    {
        try {
            $validatedData = $request->validate([
                "title" => "sometimes|string|max:255",
                "content" => "sometimes|string",
                "cover" => "sometimes|image|mimes:jpeg,png,jpg,gif,svg",
            ]);
            $blog = blog::findOrFail($id);
            $oldCover = $blog->cover;
            // dd($blog);
            if ($request->hasFile('cover')) {
                // Delete the old images if they exist
                Storage::dist('public')->delete($oldCover);
                $coverPath = $request->file('cover')->store('blogs_covers', 'public');
                $validatedData['cover'] = URL::to(Storage::url($coverPath));
            }
            $blog->update($validatedData);
            return response()->json(['message' => 'blog updated successfully'], 200);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $blog = blog::findOrFail($id);
            $blog->delete();
            return response()->json(['message' => 'blog deleted successfully']);
        } catch (\Exception $error) {
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }
}
