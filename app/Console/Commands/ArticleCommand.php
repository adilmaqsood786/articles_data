<?php

namespace App\Console\Commands;

use App\Services\ArticleService;
use Illuminate\Console\Command;

class ArticleCommand extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:articles';
    protected $description = 'Fetch articles from data sources';

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(ArticleService $articleService)
    {

        //News API Data Fetch and Store
        $articleService->fetchAndStoreArticlesNewsApi('newspapers');
        $articleService->fetchAndStoreArticlesNewsApi('magazines');
        $articleService->fetchAndStoreArticlesNewsApi('blogs');
        //Guardian API Data Fetch and Store
        $articleService->fetchAndStoreArticlesGuardianApi('newspapers');
        $articleService->fetchAndStoreArticlesGuardianApi('magazines');
        $articleService->fetchAndStoreArticlesGuardianApi('blogs');
        //New York API Data Fetch and Store
        $articleService->fetchAndStoreArticlesNewYorkApi('newspapers');
        $articleService->fetchAndStoreArticlesNewYorkApi('magazines');
        $articleService->fetchAndStoreArticlesNewYorkApi('blogs');
        return  $this->info('Articles fetched and stored successfully');
    }
}
