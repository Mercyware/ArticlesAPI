<?php

namespace Tests\Feature;

use App\Models\Article;
use App\User;
use Laravel\Passport\Passport;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_articles_is_listed_correctly()
    {
        factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);

        $response = $this->json('GET', '/api/articles', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'slug',
                    'title',
                    'article',
                    'rating',
                    'created_at',
                    'updated_at'],
                ]]);
    }

    public function test_that_article_a_listed_correctly()
    {

        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);

        $response = $this->json('GET', '/api/articles/' . $article->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                'id' => $article->id,
                'title' => $article->title,

            ])
            ->assertJsonStructure([

                'id',
                'slug',
                'title',
                'article',
                'rating',
                'created_at',
                'updated_at',
            ]);
    }

    public function test_that_authentication_is_required_to_create_new_article()
    {

        $payload = [
            'title' => 'Lorem',
            'article' => 'Ipsum',
        ];
        $headers = ['Accept' => 'application/json'];

        $this->json('POST', 'api/articles', $payload, $headers)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_that_title_and_article_are_required_to_create_new_article()
    {
        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );


        $headers = ['Accept' => 'application/json'];

        $this->json('POST', 'api/articles', $headers)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }

    public function test_that_create_new_article_creates_successfully()
    {
        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );
        $payload = [
            'title' => 'Lorem',
            'article' => 'Ipsum',
            'user_id' => 1
        ];

        $headers = ['Accept' => 'application/json'];

        $this->json('POST', 'api/articles', $payload, $headers)
            ->assertStatus(201)
            ->assertJsonStructure([

                    'id',
                    'slug',
                    'title',
                    'article',
                    'rating',
                    'created_at',
                    'updated_at']
            );
    }

    public function test_that_authentication_is_required_to_update_article()
    {
        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);
        $payload = [
            'title' => 'Lorem',
            'article' => 'Ipsum',
        ];

        $headers = ['Accept' => 'application/json'];

        $this->json('PATCH', 'api/articles/' . $article->id, $payload, $headers)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_that_title_and_article_are_required_to_update_new_article()
    {
        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );

        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);
        $payload = [
            'title' => 'Lorem',
            'article' => 'Ipsum',
        ];

        $headers = ['Accept' => 'application/json'];

        $this->json('PATCH', 'api/articles/' . $article->id, $headers)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }


    public function test_that_create_new_article_update_successfully()
    {

        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );

        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);
        $payload = [
            'title' => 'Lorem',
            'article' => 'Ipsum',
        ];

        $headers = ['Accept' => 'application/json'];

        $this->json('PATCH', 'api/articles/' . $article->id, $payload, $headers)
            ->assertStatus(202)
            ->assertJsonStructure([

                    'id',
                    'slug',
                    'title',
                    'article',
                    'rating',
                    'created_at',
                    'updated_at']
            );
    }


    public function test_that_authentication_is_required_to_delete_article()
    {
        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);


        $headers = ['Accept' => 'application/json'];

        $this->json('DELETE', 'api/articles/' . $article->id, $headers)
            ->assertStatus(401)
            ->assertJson([
                'message' => 'Unauthenticated.',
            ]);
    }


    public function test_that_create_new_article_delete_successfully()
    {

        Passport::actingAs(
            factory(User::class)->create(),
            ['create-servers']
        );

        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);


        $headers = ['Accept' => 'application/json'];

        $this->json('DELETE', 'api/articles/' . $article->id, $headers)
            ->assertStatus(204);


    }

    public function test_that_rating_required_and_must_be_valid_to_rate_an_article()
    {
        $payload = [
            'rating' => 20,

        ];

        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);

        $headers = ['Accept' => 'application/json'];

        $this->json('POST', 'api/articles/' . $article->id . '/rating', $payload, $headers)
            ->assertStatus(422)
            ->assertJson([
                'message' => 'The given data was invalid.',
            ]);
    }

    public function test_that_create_new_article_rating_successfully()
    {
        $payload = [
            'rating' => 2,

        ];

        $article = factory(Article::class)->create([
            'title' => 'Test Title',
            'article' => 'Teat Article'
        ]);

        $headers = ['Accept' => 'application/json'];



        $this->json('POST', 'api/articles/' . $article->id . '/rating', $payload, $headers)
            ->assertStatus(201);

    }


}
