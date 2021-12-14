<?php

namespace Src\Domain\Article\DataTransferObjects;

use Carbon\Carbon;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class ArticleData extends DataTransferObject
{
    public ?string $title;

    public User $user;

    public ?string $description;

    public Carbon $publication_date;

    /**
     * @param array $data
     * @return ArticleData
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function data(array $data): ArticleData
    {
        return new self([
            'title' => $data['title'],
            'user' => User::findOrFail($data['user_id']),
            'description' => $data['description'],
            'publication_date' => Carbon::createFromFormat('Y-m-d H:i:s', $data['publication_date'])
        ]);
    }
}
