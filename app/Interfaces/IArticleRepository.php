<?php


namespace App\Interfaces;


use App\Models\Article;

interface IArticleRepository
{

    public function createArticle($attributes):Article;

    public function updateArticle($attributes, $article_id);

    public function deleteArticle($article_id);

    public function getArticles();

    public function getAnArticleByArticleID($article_id);

    public function searchArticles($search_string);

    public function rateArticle($attributes, $article_id);
}
