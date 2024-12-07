<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Image;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categoryId = $request->get('category');
        $authorId = $request->get('author');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $timeframe = $request->get('timeframe');
        $status = $request->get('status'); 
        $articles = Article::with('category', 'author');
    
        if ($categoryId) {
            $articles->where('category_id', $categoryId);
        }
    
        if ($authorId) {
            $articles->where('author_id', $authorId);
        }
    
        if ($status) { 
            $articles->where('status', $status);
        }
        if ($startDate && $endDate) {
            $articles->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        if ($timeframe == 'last_month') {
            $articles->where('created_at', '>=', Carbon::now()->subMonth());
        }
    

        $articles = $articles->get();
    
        $categories = Category::all();
        $authors = User::all();
    
        return view('articles.index', compact('articles', 'categories', 'authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image files
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['author_id'] = auth()->id();
        $article = Article::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads', 'public');
                $article->images()->create([
                    'file_path' => 'storage/' . $path,
                    'file_type' => $image->getMimeType(),
                ]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image files
            'status' => 'required|in:draft,published,archived',
        ]);

        $article->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads', 'public');
                $article->images()->create([
                    'file_path' => 'storage/' . $path,
                    'file_type' => $image->getMimeType(),
                ]);
            }
        }

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    public function destroyImage(Image $image)
    {
        if (file_exists(public_path($image->file_path))) {
            unlink(public_path($image->file_path));
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }
}
