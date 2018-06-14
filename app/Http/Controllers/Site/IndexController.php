<?php

namespace App\Http\Controllers\Site;

use App\Helpers\Helper;
use App\Model\Post;
use App\Model\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class IndexController extends Controller
{

    public function index()
    {
        $slide = Slide::all();

        return view('site.index',
            [
                'slide' => $slide,
                'post' => Helper::get_post(null, null),
            ]
        );
    }

    public function page($slug)
    {
        $data = DB::table('pages')
            ->where('slug', $slug)
            ->first();

        if (empty($data)) {
            return redirect('/');
        }

        $meta = [
            'title' => $data->title,
            'seo' => $data->seo,
            'keyword' => $data->keyword,
        ];

        return view('site.page',
            [
                'data' => $data,
                'meta' => $meta
            ]
        );
    }

    public function search(Request $request)
    {
        $meta = [
            'title' => $request->search
        ];

        return view('site.search',
            [
                'meta' => $meta,
                'post' => Helper::get_post(null, $request->search),
            ]
        );
    }

    public function show($category, $slug)
    {
        $idCat = DB::table('category')
            ->select('id')
            ->where('slug', $category)
            ->first();

        $post = DB::table('posts')
            ->select('posts.id', 'name as author', 'title', 'content', 'image', 'seo', 'keyword', 'view', 'posts.created_at')
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where('slug', $slug);
        if (!empty($idCat->id)) {
            $post->where('category_id', $idCat->id);
        }
        $post = $post->first();

        if (empty($post)) {
            return redirect('/');
        }

        DB::table('posts')
            ->where('id', $post->id)
            ->update(['view' => $post->view + 1]);

        $dataCategory = DB::table('category')
            ->where('modul', 'post')
            ->get();

        $meta = [
            'title' => $post->title,
            'seo' => $post->seo,
            'keyword' => $post->keyword,
        ];

        return view('site.show',
            [
                'post' => $post,
                'meta' => $meta,
                'category' => Helper::tree_category($dataCategory)
            ]
        );
    }

    public function category($category)
    {
        $idCat = DB::table('category')
            ->select('id')
            ->where('slug', $category)
            ->first();

        if (empty($idCat->id)) {
            return redirect('/');
        }

        $dataCategory = DB::table('category')
            ->where('modul', 'post')
            ->get();

        $meta = [
            'title' => $category,
        ];

        return view('site.category',
            [
                'post' => Helper::get_post($idCat->id, null),
                'meta' => $meta,
                'category' => Helper::tree_category($dataCategory)
            ]
        );
    }
}
