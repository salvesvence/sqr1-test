<?php

namespace Tests\Unit\src\Domain\Article\Actions;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use Spatie\Permission\Models\Role;
use Src\Domain\Role\Types\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Domain\Article\Actions\CreateArticleAction;
use Src\Domain\Article\DataTransferObjects\ArticleData;

class CreateArticleActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_article_can_be_created_correctly()
    {
        $user = User::factory()->create();

        $bloggerRole = Role::create(['name' => RoleEnum::blogger()]);

        $user->assignRole($bloggerRole);

        $data = [
            'user_id' => $user->id,
            'title' => 'Article Title',
            'description' => 'Article Description',
            'publication_date' => Carbon::now()->toDateTimeString()
        ];

        (new CreateArticleAction(ArticleData::data($data)))->execute();

        $dbArticles = Article::all();
        $dbArticle = $dbArticles->first();

        $this->assertEquals(1, $dbArticles->count());
        $this->assertEquals($user->id, $dbArticle->user_id);
        $this->assertEquals('Article Title', $dbArticle->title);
        $this->assertEquals('Article Description', $dbArticle->description);
        $this->assertEquals($data['publication_date'], $dbArticle->publication_date->toDateTimeString());
    }
}
