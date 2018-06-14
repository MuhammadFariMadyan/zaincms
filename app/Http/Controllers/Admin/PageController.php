<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Rpage;
use App\Model\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Helpers\Helper;
use Image;
use Auth;
use Illuminate\Support\Facades\Input;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $dataPages = DB::table('pages')
            ->select('pages.id', 'title', 'menu_id', 'name', 'plugin', 'status', 'pages.created_at')
            ->leftJoin('users', 'users.id', '=', 'pages.user_id');
        if ($request->search) {
            $dataPages->where('title', 'like', '%' . $request->search . '%');
        }
        $dataPages = $dataPages->get();

        $page = [];
        foreach ($dataPages as $d) {

            $menu = [];
            $idMenu = explode(',', $d->menu_id);
            for ($i = 0; $i <= count($idMenu) - 1; $i++) {
                $dataMenu = DB::table('menu')
                    ->where('id', $idMenu[$i])
                    ->get();
                foreach ($dataMenu as $m) {
                    $menu[] = $m->title;
                }
            }
            $page[] = [
                'id' => $d->id,
                'title' => $d->title,
                'menu_id' => $d->menu_id,
                'author' => $d->name,
                'menu' => $menu,
                'status' => $d->status,
                'created_at' => $d->created_at,
            ];
        }

        $data = Helper::paginate($page, 10);

        $meta = [
            'title' => 'Page',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];

        return view('admin.page.index',
            [
                'data' => $data,
                'meta' => $meta
            ]
        );
    }

    public function create()
    {
        $menu = DB::table('menu')
            ->get();

        $meta = [
            'title' => 'Create Page',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];

        return view('admin.page.create',
            [
                'menu' => Helper::tree_category($menu),
                'meta' => $meta
            ]
        );
    }

    public function store(Rpage $request)
    {
        $data = new page;
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

        $data->slug = Helper::slug(null, 'pages', null, $request->title);
        $data->title = $request->title;
        $data->user_id = Auth::user()->id;
        $data->menu_id = $request->dataMenu;
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

        return redirect(route('page.index'))->with('message', 'page ' . $status);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = Page::findOrFail($id);

        $idMenu = explode(',', $data->menu_id);

        $dataMenu = [];
        for ($i = 0; $i <= count($idMenu) - 1; $i++) {
            $dataMenu[$idMenu[$i]] = [
                'id' => $idMenu[$i]
            ];
        }

        $menu = DB::table('menu')
            ->get();

        $meta = [
            'title' => 'Edit Page',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];

        return view('admin.page.edit',
            [
                'data' => $data,
                'menu' => Helper::tree_category($menu),
                'dataMenu' => $dataMenu,
                'meta' => $meta
            ]
        );
    }

    public function update(Rpage $request, $id)
    {
        $data = page::findOrFail($id);

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

        $data->slug = Helper::slug(null, 'pages', null, $request->title);
        $data->title = $request->title;
        $data->user_id = Auth::user()->id;
        $data->menu_id = $request->dataMenu;
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

        return redirect(route('page.index'))->with('message', 'Success Update');
    }

    public function destroy($id)
    {
        $data = page::findOrFail($id);
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
