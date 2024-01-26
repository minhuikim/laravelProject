<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    // sail artisan test --filter=ArticleControllerTest
    use RefreshDatabase;
    /**
     * @test
     */
    public function view_create(): void
    {
        $response = $this->get(route('articles.create'));
        $response->assertStatus(200)
        ->assertSee('글쓰기');
    }

    /**
     * @test
     */
    public function can_write(): void
    {
        $testData = [
            'body' => 'test article'
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('articles.store'), $testData)
            ->assertRedirect(route('articles.index'));
        
        $this->assertDatabaseHas('articles', $testData);
    }

    /**
     * @test
     */
    public function check_the_list_of_articles(): void 
    {
        $now = Carbon::now();
        $afterOneSecond = (clone $now)->addSecond();

        $article1 = Article::factory()->create(
            ['created_at' => $now]
        );
        $article2 = Article::factory()->create(
            ['created_at' => $afterOneSecond]
        );

        $this->get(route('articles.index'))
        ->assertSeeInOrder([
            $article2->body,
            $article1->body
        ]);
    }

    /**
     * @test
     */
    public function view_individual_posts(): void 
    {
        $article = Article::factory()->create();

        $this->get(route('articles.show', ['article' => $article->id]))
        ->assertSuccessful()
        ->assertSee($article->body);
    }

    /**
     * @test
     */
    public function view_edit(): void
    {
        $article = Article::factory()->create();

        $response = $this->get(route('articles.edit', ['article' => $article->id]));
        $response->assertStatus(200)
        ->assertSee('글 수정하기');
    }

    /**
     * @test
     */
    public function can_edit(): void
    {
        $payload = ['body' => '수정된 글'];
        $article = Article::factory()->create();

        $this->patch(
            route('articles.update', ['article' => $article->id]),
            $payload
        )->assertRedirect(route('articles.index'));

        // 1번째 방법
        $this->assertDatabaseHas('articles', $payload);

        // 2번째 방법
        $this->assertEquals($payload['body'], $article->refresh()->body);
    }

    /**
     * @test
     */
    public function can_delete(): void
    {
        $article = Article::factory()->create();

        $this->delete(route('articles.delete', ['article' => $article->id]))
        ->assertRedirect(route('articles.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
