<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
   
    public function index()
    {
        $access = $this->middleware('can:dashboard');
        if (!$access) {
            abort(403, 'You do not have access to dashboard');
        }
      
        $articlesCount = Article::count(); 
        $pageViews = Article::sum('view_count'); 
        $usersCount = User::count(); 
        $commentsCount = Comment::count();
    
        return view('Dashboard.index', [
            'articlesCount' => $articlesCount,
            'pageViews' => $pageViews,
            'usersCount' => $usersCount,
            'commentsCount' => $commentsCount,
        ]);
    }
    public function getDashboardData()
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Bar Chart Data (Page Views by Month)
        $pageViewsData = Article::selectRaw('MONTH(created_at) as month, SUM(view_count) as total_views')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $pageViewsLabels = $pageViewsData->map(function ($item) {
            return Carbon::create()->month($item->month)->format('M');
        });
        $pageViewsValues = $pageViewsData->map(function ($item) {
            return (int) $item->total_views;
        });

        // Line Chart Data (Articles Published by Month)
        $articlesPublishedData = Article::selectRaw('MONTH(created_at) as month, COUNT(*) as articles_count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $articlesPublishedLabels = $articlesPublishedData->map(function ($item) {
            return Carbon::create()->month($item->month)->format('M');
        });
        $articlesPublishedValues = $articlesPublishedData->map(function ($item) {
            return $item->articles_count;
        });

        // Doughnut Chart Data (Article Distribution by Category)
        $categoryDistributionData = Category::withCount('articles')
            ->get()
            ->pluck('articles_count', 'name');

        $topCommentedArticles = Article::withCount('comments') 
        ->orderByDesc('comments_count') 
        ->take(20)
        ->get();
    
        $pieChartLabels = $topCommentedArticles->pluck('title'); 
        $pieChartValues = $topCommentedArticles->pluck('comments_count'); 

        return response()->json([
            'pageViewsData' => [
                'labels' => $pageViewsLabels,
                'values' =>  $pageViewsValues,
            ],
            'articlesPublishedData' => [
                'labels' => $articlesPublishedLabels,
                'values' => $articlesPublishedValues,
            ],
            'categoryDistribution' => [
                'labels' => $categoryDistributionData->keys(),
                'values' => $categoryDistributionData->values(),
            ],
            'topCommentedArticles' => [
                'labels' => $pieChartLabels, 
                'values' => $pieChartValues,
            ],
        ]);
    }
}