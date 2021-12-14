<?php

namespace Src\Domain\Article\Actions;

use App\Models\Article;
use Src\Domain\Article\DataTransferObjects\ArticleData;

class CreateArticleAction
{
    /**
     * @var ArticleData
     */
    private $articleData;

    /**
     * @param ArticleData $articleData
     */
    public function __construct(ArticleData $articleData)
    {
        $this->articleData = $articleData;
    }

    /**
     * @return Article
     */
    public function execute(): Article
    {
        return Article::create([
            'title' => $this->articleData->title,
            'user_id' => $this->articleData->user->id,
            'description' => $this->articleData->description,
            'publication_date' => $this->articleData->publication_date->toDateTimeString()
        ]);
    }
}
