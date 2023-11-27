# Laravel News Aggregator

This Laravel project is a news aggregator that fetches articles from various sources and provides API endpoints for interacting with the backend.

## Installation

1. Clone the repository:

```bash
git clone  https://github.com/adilmaqsood786/articles_data.git

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate
Usage

Fetch and Store Articles
To fetch and store articles from the Guardian and New York Times APIs, use the following Artisan command:
php artisan serve

php artisan fetch:articles


API Endpoints
The following API endpoints are available:

Search Articles:

GET /api/articles/search?query={your-query}

GET /api/articles/filter?date={yyyy-mm-dd}&category={category-name}&source={source-name}



This README provides basic instructions for installing, running, and using the Laravel News Aggregator. Adjust it according to your project's specifics and include additional sections or information as needed.


