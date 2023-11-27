<?php

return [
    //The News API
    "news_api_key"=>env('NEWS_API_KEY'),
    "news_api_base_url"=>"https://newsapi.org/v2/everything",
    //The Guardian API
    "guardian_api_key"=>env('GUARDIAN_API_KEY'),
    "guardian_api_base_url"=>"https://content.guardianapis.com/",
    //The New York API
    "new_york_api_key"=>env('NEW_YORK_API_KEY'),
    "new_york_api_base_url"=>"https://api.nytimes.com/svc/search/v2/articlesearch.json/",

];
