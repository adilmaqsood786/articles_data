<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function search(Request $request)
    {
        $searchQuery = $request->input('query');

        $articles = Article::query();
        if ($searchQuery){
         $articles = $articles->where('title', 'like', "%$searchQuery%")
                ->orWhere('content', 'like', "%$searchQuery%");
        }
        $articles = $articles->get();
        return response()->json(['articles' => $articles]);

    }

    public function filter(Request $request)
    {
        $request->validate([
            'date' => 'date',
            'category' => 'string',
            'source' => 'string',
        ]);


        $dateFilter = $request->input('date');
        $categoryFilter = $request->input('category');
        $sourceFilter = $request->input('source');

        $query = Article::query();

        // Apply filters

        if ($dateFilter) {
            $query->whereDate('published_at', '=', $dateFilter);
        }

        if ($categoryFilter) {
            $query->whereHas('category', function ($query) use ($categoryFilter) {
                $query->where('name', $categoryFilter);
            });
        }

        if ($sourceFilter) {
            $query->whereHas('source', function ($query) use ($sourceFilter) {
                $query->where('name', $sourceFilter);
            });
        }

        $filteredArticles = $query->get();

        return response()->json(['articles' => $filteredArticles]);
    }
}
