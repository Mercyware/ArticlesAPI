<?php

namespace App\Http\Controllers;


use App\Http\Requests\ArticleRequest;
use App\Http\Requests\RateRequest;
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
        $articles = $this->articleService->getArticles();
        return $articles->response()->setStatusCode(200);
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
            return response()->json(["message" => 'The article does not exist'], 404);
        }

        return $article->response()->setStatusCode(200);
    }

    public function searchArticle(Request $request)
    {
        $articles = $this->articleService->searchArticle($request->q);
        return $articles->response()->setStatusCode(200);

    }

    public function createArticles(ArticleRequest $request)
    {
        try {
            $article = $this->articleService->createArticle($request);

            if (!$article) {
                return response()->json(["message" => 'An unknown error has occurred. Unable to create new article'], 500);
            }
            return $article->response()->setStatusCode(201);

        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);

        }

    }

    public function updateArticle(ArticleRequest $request, $article_id)
    {


        try {
            $article = $this->articleService->updateArticle($request, $article_id);
            if (!$article) {
                return response()->json(["message" => 'The article does not exist'], 404);
            }
            return $article->response()->setStatusCode(202);

        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);

        }

    }

    public function deleteArticle($article_id)
    {

        try {
            $article = $this->articleService->deleteArticle($article_id);
            if ($article == null) {
                return response()->json(["message" => 'Article has been deleted'], 204);
            }
            return response()->json(['message' => "Unable to delete article"], 500);

        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);

        }


    }


    public function rateArticle(RateRequest $request, $article_id)
    {

        try {
            $rate = $this->articleService->rateArticle($request, $article_id);
            if (!$rate) {
                return response()->json(["message" => 'An unknown error has occurred. Unable to create rating'], 500);
            }
            return $rate->response()->setStatusCode(201);

        } catch (\Exception $exception) {
            return response()->json(["message" => $exception->getMessage()], 500);

        }


    }
}
