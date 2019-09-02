<?php


namespace App\Repository;


use App\Interfaces\IArticleRepository;
use App\Models\Article;
use App\Models\Rate;

class ArticleRepository implements IArticleRepository
{

    /**
     * @var Article
     */
    private $article;
    /**
     * @var Rate
     */
    private $rate;

    /**
     * ArticleRepository constructor.
     * @param Article $article
     * @param Rate $rate
     */
    public function __construct(Article $article, Rate $rate)
    {

        $this->article = $article;
        $this->rate = $rate;
    }

    public function createArticle($attributes): Article
    {

        return $this->article->create([
            'title' => $attributes->title,
            'user_id' => $attributes->user_id,
            'article' => $attributes->article
        ]);

    }

    public function updateArticle($attributes, $article_id)
    {
        return $this->article->where('id', $article_id)->update([
            'title' => $attributes->title,
            'article' => $attributes->article
        ]);

    }

    public function deleteArticle($article_id)
    {
        return $this->article->where('id', $article_id)->delete();
    }

    public function getArticles()
    {
        return $this->article->paginate();
    }

    public function getAnArticleByArticleID($article_id)
    {


        return $this->article->where('id', $article_id)->first();

    }


    public function searchArticles($search_string)
    {
        return $this->article->Where('title', 'like', '%' . $search_string . '%')
            ->orWhere('article', 'like', '%' . $search_string . '%')->get();
    }

    public function rateArticle($attributes, $article_id)
    {
        return $this->rate->create([
            'article_id' => $article_id,
            'rating' => $attributes->rating,

        ]);
    }

}
