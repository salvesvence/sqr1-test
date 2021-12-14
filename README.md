# Project Deployment

I've deployed the testing project with Docker with Laravel inside the **src** folder, so we need to have installed in our OS Docker and Docker Compose. Once we have the repository cloned in our computer we'll have to go to the project root path. Having docker initialized we'll have to execute the following command:

```
docker-compose up --build -d
```

Once this we'll need to copy the .env.example and paste it like .env and changing the value of the next variables:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=secret
```

Then we need to follow the next steps:

- In the project root path, execute `docker-compose run --rm artisan install`. With this command line we'll install all the project php dependencies.
- Next, we'll need to execute `docker-compose run --rm npm install` and `docker-compose run --rm npm run production`. Normally we'd use the command `docker-compose run --rm npm install && npm run production` but some OS have problems with this syntax so better use the first options.
- Once this, we'll have to execute `docker-compose run --rm artisan migrate` to create all database tables.
- Finally we need to execute `docker-compose run --rm artisan db:seed` to create the different user roles.

# Notes

## Login and Register
As the test's notes don't specify anything special about the register and login flow I decided to use the Breeze starter kit, which I think is the fastest and most tested way to build all the necessary routes, views and controllers for that workflow as well as it loads Tailwind CSS. In addition, I've changed a few things in the `RegisteredUserController@store` function. Basically, to make the testing correction easier, I've changed it in the way that any new user account is activated when he registers in (obviously is not a good practice and in a production project I would let it like it was at the beginning, with the email verification flow to activate the user account).

## Schedule

I've created a scheduled cron to execute the command `heroku:articles` that it's the command in charge of downloading the new Admin articles. It's configured to be executed each hour to minimise the strain we put on the feed server. But to see how it works in a faster way you can comment the uncommented code and uncommenting the following code line like so...
```
from:

         $schedule->command('heroku:articles')->hourly();
//         $schedule->command('heroku:articles')->everyMinute();

to:
//         $schedule->command('heroku:articles')->hourly();
         $schedule->command('heroku:articles')->everyMinute();
```
and executing the command `docker-compose run --rm artisan schedule:run` or in a more directly way you can execute `docker-compose run --rm artisan heroku:articles`. 

## Testing

I didn't make all the necessary tests for this application, but I did one to show how would do it. The test created by me is the ` Tests\Unit\src\Domain\Article\Actions\CreateArticleActionTest`.