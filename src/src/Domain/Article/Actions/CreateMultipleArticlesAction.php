<?php

namespace Src\Domain\Article\Actions;

use App\Models\User;
use Src\Domain\Article\DataTransferObjects\ArticleData;

class CreateMultipleArticlesAction
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $articles;

    /**
     * @param User $user
     * @param array $articles
     */
    public function __construct(User $user, array $articles)
    {
        $this->user = $user;
        $this->articles = $articles;
    }

    /**
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public function __invoke()
    {
        foreach ($this->articles as $article) {

            if(!isset($article['user_id'])) $article['user_id'] = $this->user->id;

            (new CreateArticleAction(ArticleData::data($article)))->execute();
        }
    }
}
