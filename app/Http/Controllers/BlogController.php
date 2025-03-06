<?php

namespace App\Http\Controllers;

use App\Models\blog;
use App\Http\Requests\StoreblogRequest;
use App\Http\Requests\UpdateblogRequest;

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
        try{
            $validatedData = $request->validated();

            if($request->hasFile('cover')){
                $cover = $request->file('cover')->getClientOriginalName();
                $request->file('cover')->storeAs('public/covers', $cover);
                $validatedData['cover'] = $cover;   
            }
            $blog = blog::create($validatedData);
            return response()->json(['message' => 'blog created successfully']);
        }catch(\Exception $error){
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
        try{
            $validatedData = $request->validated();
            $blog = blog::findOrFail($id);
            if($request->hasFile('cover')){
                $cover = $request->file('cover')->getClientOriginalName();
                $request->file('cover')->storeAs('public/covers', $cover);
                $validatedData['cover'] = $cover;   
            }
            $blog = blog::create($validatedData);
            return response()->json(['message' => 'blog created successfully']);
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
            $blog = blog::findOrFail($id);
            $blog->delete();
            return response()->json(['message' => 'blog deleted successfully']);
        }catch(\Exception $error){
            return response()->json(['message' => $error->getMessage()], $error->getCode());
        }
    }
}
