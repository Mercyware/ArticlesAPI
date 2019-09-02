<?php


namespace App\Interfaces;


interface IArticleService
{


    public function getArticles();

    public function getAnArticle($article_id);

    public function searchArticle($search_string);

    public function createArticle($attributes);

    public function updateArticle($attributes, $article_id);

    public function deleteArticle($article_id);

    public function rateArticle($attributes, $article_id);
}
