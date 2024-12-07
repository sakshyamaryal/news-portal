<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage category')->except('index');
    }
    public function index()
    {
        try {
            $categories = Category::all();
            return view('categories.index', compact('categories'));
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads', 'public');
                $imagePath = 'storage/' . $imagePath;
            }

            $category = Category::create([
                'name' => $request->name,
                'image' => $imagePath,
            ]);

            return response()->json($category);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return response()->json($category);
        } catch (Exception $e) {
            return response()->json(['error' =>$e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $category = Category::findOrFail($id);
            $category->name = $request->name;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads', 'public');
                $category->image = 'storage/' . $imagePath;
            }

            $category->save();

            return response()->json($category);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            if ($category->image) {
                Storage::delete('public/' . str_replace('storage/', '', $category->image));
            }
            
            $category->delete();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}