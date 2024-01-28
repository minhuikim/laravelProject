<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    // sail artisan test --filter=ArticleControllerTest
    use RefreshDatabase;
    /**
     * @test
     */
    public function login_user_can_view_create(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.create'))
            ->assertStatus(200)
            ->assertSee('글쓰기');
    }

    /**
     * @test
     */
    public function logout_user_cant_view_create(): void
    {
        $this->get(route('articles.create'))
            ->assertStatus(302)
            ->assertRedirectToRoute('login');
    }

    /**
     * @test
     */
    public function login_user_can_write(): void
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
    public function logout_user_cant_write(): void
    {
        $testData = [
            'body' => 'test article'
        ];

        $this->post(route('articles.store'), $testData)
            ->assertRedirectToRoute('login');
        
        $this->assertDatabaseMissing('articles', $testData);
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
    public function login_user_view_edit(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('articles.edit', ['article' => $article->id]))
            ->assertStatus(200)
            ->assertSee('글 수정하기');
    }

    /**
     * @test
     */
    public function logout_user_cant_view_edit(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.edit', ['article' => $article->id]))
            ->assertRedirectToRoute('login');
    }

    /**
     * @test
     */
    public function login_user_can_edit(): void
    {
        $user = User::factory()->create();

        $payload = ['body' => '수정된 글'];
        
        $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->patch(
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
    public function logout_user_cant_edit(): void
    {
        $payload = ['body' => '수정된 글'];
        
        $article = Article::factory()->create();

        $this->patch(
                route('articles.update', ['article' => $article->id]),
                $payload
            )->assertRedirectToRoute('login');

        // 1번째 방법
        $this->assertDatabaseMissing('articles', $payload);

        // 2번째 방법
        $this->assertNotEquals($payload['body'], $article->refresh()->body);
    }

    /**
     * @test
     */
    public function login_user_can_delete(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create();

        $this->actingAs($user)
            ->delete(route('articles.destroy', ['article' => $article->id]))
            ->assertRedirect(route('articles.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }

    /**
     * @test
     */
    public function logout_user_cant_delete(): void
    {
        $article = Article::factory()->create();

        $this->delete(route('articles.destroy', ['article' => $article->id]))
            ->assertRedirectToRoute('login');

        $this->assertDatabaseHas('articles', ['id' => $article->id]);
    }
}
