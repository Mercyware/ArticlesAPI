<?php

namespace App\Http\Controllers;


use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Interfaces\IArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    /**
     * @var IArticleService
     */
    private $articleService;

    public function __construct(IArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ArticleCollection
     */
    public function getArticles()
    {
        return $this->articleService->getArticles();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Article $article
     *
     * @return ArticleResource
     */
    public function getAnArticle($article_id)
    {
        $article = $this->articleService->getAnArticle($article_id);
        if (!$article) {
            return abort(404);
        }

        return $article;
    }

    public function searchArticle(Request $request)
    {
        $articles = $this->articleService->searchArticle($request->q);
        return $articles;

    }

    public function createArticles(Request $request)
    {
        return $this->articleService->createArticle($request);
    }

    public function updateArticle(Request $request)
    {

        return $this->articleService->updateArticle($request, 51);
    }

    public function deleteArticle($article_id)
    {


        return $this->articleService->deleteArticle($article_id);
    }


    public function rateArticle(Request $request, $article_id)
    {
        return $this->articleService->rateArticle($request, $article_id);
    }
}
