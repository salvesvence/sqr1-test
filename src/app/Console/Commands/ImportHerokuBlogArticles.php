<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Src\Infrastructure\Api\BlogApiService;
use Src\Domain\Article\Actions\CreateMultipleArticlesAction;
use Src\Infrastructure\Api\BlogServices\HerokuBlogApiService;

class ImportHerokuBlogArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heroku:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to import Heroku articles';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $articles = (new BlogApiService(new HerokuBlogApiService))->articles();

        if(!empty($articles)) {

            $user = User::admins()->first();

            try {

                (new CreateMultipleArticlesAction($user, $articles))();

                $this->info('All articles from Admin Blog where saved successfully.');

            } catch(\Spatie\DataTransferObject\Exceptions\UnknownProperties $exception) {

                \Log::error($message = "There was a problem trying to save the Admin Blog articles");
                \Log::error($exception->getMessage());

                $this->error($message);

                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
