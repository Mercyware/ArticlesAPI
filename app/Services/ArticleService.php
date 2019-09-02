<?php


namespace App\Services;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\RateResource;
use App\Interfaces\IArticleRepository;
use App\Interfaces\IArticleService;
use http\Exception;
use phpDocumentor\Reflection\Types\Null_;

class ArticleService implements IArticleService
{

    /**
     * @var IArticleRepository
     */
    private $articleRepository;

    public function __construct(IArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticles()
    {


        return new ArticleCollection($this->articleRepository->getArticles());

    }

    public function getAnArticle($article_id)
    {


        ArticleResource::withoutWrapping();
        $article = $this->articleRepository->getAnArticleByArticleID($article_id);

        if ($article) {
            return new ArticleResource($article);

        } else {
            return null;
        }


    }

    public function searchArticle($search_string)
    {
        return new ArticleCollection($this->articleRepository->searchArticles($search_string));
    }


    public function createArticle($attributes)
    {


        ArticleResource::withoutWrapping();
        $article = $this->articleRepository->createArticle($attributes);
        if ($article) {
            return new ArticleResource($article);

        }
        return null;

    }

    public function updateArticle($attributes, $article_id)
    {

        ArticleResource::withoutWrapping();
        $article = $this->articleRepository->getAnArticleByArticleID($article_id);
        if ($article) {
            $this->articleRepository->updateArticle($attributes, $article_id);
            return new ArticleResource($article);
        }

        return null;


    }

    public function deleteArticle($article_id)
    {
        $this->articleRepository->deleteArticle($article_id);
        return null;
    }

    public function rateArticle($attributes, $article_id)
    {

        RateResource::withoutWrapping();
        $rate = $this->articleRepository->rateArticle($attributes, $article_id);
        if ($rate) {
            return new RateResource($rate);

        }
        return null;
    }
}
