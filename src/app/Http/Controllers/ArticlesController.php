<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $articles = Article::query();

        if($request->has('sortBy')) {
            $articles = $articles->orderBy(
                $request->get('sortBy'),
                $request->get('direction')
            );
        }

        $articles = $articles->paginate(3);

        return view('welcome', compact('articles'));
    }
}
