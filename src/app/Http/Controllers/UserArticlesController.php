<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Src\Domain\Article\Actions\CreateArticleAction;
use Src\Domain\Article\DataTransferObjects\ArticleData;

class UserArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $articles = auth()->user()->articles();

        if($request->has('sortBy')) {
            $articles = $articles->orderBy(
                $request->get('sortBy'),
                $request->get('direction')
            );
        }

        $articles = $articles->paginate(3);

        return response()->json(compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->merge([
            'user_id' => auth()->user()->id,
            'publication_date' => Carbon::now()->toDateTimeString()
        ])->all();

        try {

            $article = (new CreateArticleAction(ArticleData::data($data)))->execute();

            return response()->json([
                'message' => 'The article was saved successfully.',
                'article' => $article,
            ]);

        } catch (\Exception $exception) {

            return response()->json([
                'message' => 'There was a problem saving your article. Try again, please!'
            ]);
        }
    }
}
