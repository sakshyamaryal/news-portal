<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        $latestArticles = Article::where('status', 'published')
            ->latest()
            ->take(5)
            ->get();
        
        $featuredArticle = Article::where('status', 'published')
            ->inRandomOrder()
            ->first();
    

        return view('welcome', compact('categories', 'latestArticles', 'featuredArticle'));
    }


    public function showCategory($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $articles = $category->articles()->latest()->get();

        $categories = Category::all();

        return view('news.category', compact('category', 'articles', 'categories'));
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $articles = Article::where('title', 'like', '%' . $query . '%')
            ->orWhere('content', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(10);

        $categories = Category::withCount('articles')->get();

        return view('news.search', compact('articles', 'query'));
    }
    public function showArticle($id)
    {
        $article = Article::findOrFail($id);
    
        $categories = Category::withCount('articles')->get();
    
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();
    
    
        $mostReadArticles = Article::orderBy('view_count', 'desc')
            ->take(5)
            ->get();
    
        $article->increment('view_count');
    
        return view('news.article', compact(
            'article', 
            'categories', 
            'relatedArticles',
            'mostReadArticles'
        ));
    }
}
