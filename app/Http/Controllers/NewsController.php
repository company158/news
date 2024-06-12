<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;


class NewsController extends Controller
{
    public function __construct()
    {
        Artisan::call('view:clear');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activeNews = News::where('show', '1')->get();
        return view('news.news', ['news' => $activeNews]);
    }

    public function getHideNews()
    {
        $activeNews = News::where('show', '0')->get();
        return view('news.news', ['news' => $activeNews]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validateWithBag('news',
            [
                'title' => 'required|between:4,50',
                'url' => 'required|regex:/[a-z0-9]*/i|unique:news,url',
                'short_desc' => 'required|between:10,50',
                'full_desc' => 'required',
            ]
        );

        $show = '0';
        if ($request->filled('show') && $request->input('show') == 'on') {
            $show = '1';
        }

        $news = new News();
        $news->setCreate([
            'title' => $request->input('title'),
            'url' => (strtolower($request->input('url'))),
            'short_description' => $request->input('short_desc'),
            'description' => $request->input('full_desc'),
            'show' => $show,
        ]);

        return redirect()->route('news.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $url)
    {
        $news = News::where('url', $url)->first();
        if (!empty($news)) {
            return view('news.show', ['news' => $news]);
        } else {
            abort('404');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $url)
    {
        $news = News::where('url', $url)->first();
        if (!empty($news)) {
            return view('news.edit', ['news' => $news]);
        } else {
            abort('404');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::find($id);

        if (!empty($news)) {

            $show = '0';
            if ($request->filled('show') && $request->input('show') == 'on') {
                $show = '1';
            }
            $news->show = $show;
            $news->save();
        }

        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
