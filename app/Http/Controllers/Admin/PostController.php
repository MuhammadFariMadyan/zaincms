<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Rpost;
use App\Model\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Helpers\Helper;
use Image;
use Auth;
use Illuminate\Support\Facades\Input;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $dataPosts = DB::table('posts')
            ->select('posts.id', 'title', 'category_id', 'name', 'plugin', 'status', 'posts.created_at')
            ->leftJoin('users', 'users.id', '=', 'posts.user_id');
        if ($request->search) {
            $dataPosts->where('title', 'like', '%' . $request->search . '%');
        }
        $dataPosts = $dataPosts->get();

        $post = [];
        foreach ($dataPosts as $d) {

            $category = [];
            $idCat = explode(',', $d->category_id);
            for ($i = 0; $i <= count($idCat) - 1; $i++) {
                $dataCat = DB::table('category')
                    ->where('id', $idCat[$i])
                    ->get();
                foreach ($dataCat as $c) {
                    $category[] = $c->title;
                }
            }
            $post[] = [
                'id' => $d->id,
                'title' => $d->title,
                'category_id' => $d->category_id,
                'author' => $d->name,
                'category' => $category,
                'status' => $d->status,
                'created_at' => $d->created_at,
            ];
        }

        $data = Helper::paginate($post, 10);

        $meta = [
            'title' => 'Post',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];

        return view('admin.post.index',
            [
                'data' => $data,
                'meta' => $meta
            ]
        );
    }

    public function create(Request $request)
    {
        $category = DB::table('category')
            ->where('modul', $request->segment('2'))
            ->get();

        $meta = [
            'title' => 'Create Post',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];

        return view('admin.post.create',
            [
                'category' => Helper::tree_category($category),
                'meta' => $meta
            ]
        );
    }

    public function store(Rpost $request)
    {
        $data = new Post;
        if ($image = Input::file('image')) {
            $filename = $image->hashName();
            $path_thumb = public_path('thumb/' . $filename);
            Image::make($image->getRealPath())->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(350, 177)->save($path_thumb);

            $path = public_path('images/' . $filename);
            Image::make($image->getRealPath())->save($path);
            $data->image = $filename;
        }

        $data->slug = Helper::slug(null, 'posts', null, $request->title);
        $data->title = $request->title;
        $data->user_id = Auth::user()->id;
        $data->category_id = $request->dataCategory;
        $data->content = $request->description;
        $data->status = $request->publish;
        $data->plugin = $request->dataPlugin;
        if (empty($request->seo)) {
            $data->seo = strip_tags(str_limit($request->description, 150));
        } else {
            $data->seo = $request->seo;
        }
        if (empty($request->keyword)) {
            $data->keyword = $request->title;
        } else {
            $data->keyword = $request->keyword;
        }
        $data->save();

        if ($request->publish == 1) {
            $status = 'Publish';
        } elseif ($request->publish == 0) {
            $status = 'Draft';
        }

        return redirect(route('post.index'))->with('message', 'Post ' . $status);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Post::findOrFail($id);

        $idCat = explode(',', $data->category_id);

        $dataCat = [];
        for ($i = 0; $i <= count($idCat) - 1; $i++) {
            $dataCat[$idCat[$i]] = [
                'id' => $idCat[$i]
            ];
        }

        $category = DB::table('category')
            ->where('modul', 'post')
            ->get();

        $meta = [
            'title' => 'Edit Post',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];

        return view('admin.post.edit',
            [
                'data' => $data,
                'category' => Helper::tree_category($category),
                'dataCat' => $dataCat,
                'meta' => $meta
            ]
        );
    }

    public function update(Rpost $request, $id)
    {
        $data = Post::findOrFail($id);

        if ($image = Input::file('image')) {
            $filename = $image->hashName();
            $path_thumb = public_path('thumb/' . $filename);
            Image::make($image->getRealPath())->resize(350, null, function ($constraint) {
                $constraint->aspectRatio();
            })->crop(350, 177)->save($path_thumb);

            $path = public_path('images/' . $filename);
            Image::make($image->getRealPath())->save($path);

            $oldImage = $data->image;
            if ($oldImage) {
                if (file_exists(public_path('images/' . $oldImage))) {
                    unlink('images/' . $oldImage);
                } elseif (file_exists(public_path('thumb/' . $oldImage))) {
                    unlink('thumb/' . $oldImage);
                }
            }
            $data->image = $filename;
        } elseif ($request->updateImg1 == '0') {
            $oldImage = $data->image;
            if ($oldImage) {
                if (file_exists(public_path('images/' . $oldImage))) {
                    unlink('images/' . $oldImage);
                } elseif (file_exists(public_path('thumb/' . $oldImage))) {
                    unlink('thumb/' . $oldImage);
                }
            }
            $data->image = null;
        }

        $data->slug = Helper::slug(null, 'posts', null, $request->title);
        $data->title = $request->title;
        $data->user_id = Auth::user()->id;
        $data->category_id = $request->dataCategory;
        $data->content = $request->description;
        $data->status = $request->publish;
        $data->plugin = $request->dataPlugin;
        if (empty($request->seo)) {
            $data->seo = strip_tags(str_limit($request->description, 150));
        } else {
            $data->seo = $request->seo;
        }
        if (empty($request->keyword)) {
            $data->keyword = $request->title;
        } else {
            $data->keyword = $request->keyword;
        }
        $data->save();

        return redirect(route('post.index'))->with('message', 'Success Update');
    }

    public function destroy($id)
    {
        $data = Post::findOrFail($id);
        $oldImage = $data->image;
        if ($oldImage) {
            if (file_exists(public_path('images/' . $oldImage))) {
                unlink('images/' . $oldImage);
            } elseif (file_exists(public_path('thumb/' . $oldImage))) {
                unlink('thumb/' . $oldImage);
            }
        }
        $data->delete();

        return back()->with('message', 'Success Delete');
    }
}
