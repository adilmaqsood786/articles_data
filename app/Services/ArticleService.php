<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use DateTime;
use Illuminate\Support\Facades\Http;
use App\Models\Author;
use App\Models\Source;

class ArticleService
{
    public function fetchAndStoreArticlesNewsApi($type)
    {
        $newsApiBaseUrl = config('newsapi.news_api_base_url');
        $newsApi = config('newsapi.news_api_key');
        $apiResponse = Http::get($newsApiBaseUrl."/"."?q=$type&sortBy=popularity&apiKey=".$newsApi);
        if ($apiResponse->successful()) {
            $articles = $apiResponse->json('articles');
            foreach ($articles as $articleData) {
                $sourceName = $articleData['source']['name'];
                $authorName = $articleData['author'];
                $source = Source::firstOrCreate(['name' => $sourceName]);
                $author = Author::firstOrCreate(['name' => $authorName]);
                $category = Category::firstOrCreate(['name' => $type]);
                $dateTimeString = $articleData['publishedAt'];
                $dateTime = new DateTime($dateTimeString);
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
                Article::updateOrCreate(
                    ['title' => $articleData['title']],
                    [
                        'content' => $articleData['description'],
                        'source_id' => $source->id,
                        'author_id' => $author->id,
                        'category_id' => $category->id,
                        'source_url' => $articleData['url'],
                        'published_at' => $formattedDateTime,
                    ]
                );
            }
        }
    }
    public function fetchAndStoreArticlesGuardianApi($type)
    {
        $guardianApiBaseUrl = config('newsapi.guardian_api_base_url');
        $guardianApi = config('newsapi.guardian_api_key');
        $apiResponse = Http::get($guardianApiBaseUrl."search?q=$type&sortBy=popularity&api-key=".$guardianApi);
        if ($apiResponse->successful()) {
            $articles =  $apiResponse->json('response')['results'];
            foreach ($articles as $articleData) {
                $sourceName = $articleData['sectionName'];
                $authorName = $articleData['author']??"";
                $source = Source::firstOrCreate(['name' => $sourceName]);
                $author = Author::firstOrCreate(['name' => $authorName]);
                $category = Category::firstOrCreate(['name' => $articleData['pillarName']]);
                $dateTimeString = $articleData['webPublicationDate'];
                $dateTime = new DateTime($dateTimeString);
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
                Article::updateOrCreate(
                    ['title' => $articleData['webTitle']],
                    [
                        'content' => $articleData['description']??"",
                        'source_id' => $source->id,
                        'author_id' => $author->id,
                        'category_id' => $category->id,
                        'source_url' => $articleData['webUrl'],
                        'published_at' => $formattedDateTime,
                    ]
                );
            }
        }
    }
    public function fetchAndStoreArticlesNewYorkApi($type)
    {
        $newYorkApiBaseUrl = config('newsapi.new_york_api_base_url');
        $newYorkApi = config('newsapi.new_york_api_key');
        $apiResponse = Http::get($newYorkApiBaseUrl."?q=$type&api-key=".$newYorkApi);
        if ($apiResponse->successful()) {
            $articles =  $apiResponse->json('response')['docs'];
            foreach ($articles as $articleData) {
                $sourceName = $articleData['source'];
                $authorName = $articleData['author']??"";
                $categoryName =  $articleData['news_desk'];
                $source = Source::firstOrCreate(['name' => $sourceName]);
                $author = Author::firstOrCreate(['name' => $authorName]);
                $category = Category::firstOrCreate(['name' =>$categoryName ]);
                $dateTimeString = $articleData['pub_date'];
                $dateTime = new DateTime($dateTimeString);
                $formattedDateTime = $dateTime->format('Y-m-d H:i:s');
                Article::updateOrCreate(
                    ['title' => $articleData['abstract']],
                    [
                        'content' => $articleData['lead_paragraph']??"",
                        'source_id' => $source->id,
                        'author_id' => $author->id,
                        'category_id' => $category->id,
                        'source_url' => $articleData['uri'],
                        'published_at' => $formattedDateTime,
                    ]
                );
            }
        }
    }

}
