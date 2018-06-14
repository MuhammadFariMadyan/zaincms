<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Validator;
use DB;

class CategoryController extends Controller
{
    public function index()
    {
        $meta = [
            'title' => 'Category',
            'keyword' => 'dasboard',
            'description' => 'Admin',
        ];
        return view('admin.category.index',
            [
                'meta' => $meta,
            ]);
    }


    function get_category($items, $class = 'dd-list')
    {

        $html = "<ol class='" . $class . "' id='category-id'>";

        foreach ($items as $key => $value) {
            $html .= '<li class="dd-item dd3-item" data-id="' . $value['id'] . '" >
                    <div class="dd-handle dd3-handle">Drag</div>
                    <div class="dd3-content"><span id="category_show' . $value['id'] . '">' . $value['title'] . '</span> 
                        <span class="span-right"> &nbsp;&nbsp; 
                            <a class="edit-button" id="' . $value['id'] . '"><i class="fa fa-pencil"></i></a>
                            <a class="del-button" id="' . $value['id'] . '"><i class="fa fa-trash"></i></a></span> 
                    </div>';
            if (array_key_exists('child', $value)) {
                $html .= $this->get_category($value['child'], 'child');
            }
            $html .= "</li>";
        }
        $html .= "</ol>";

        return $html;

    }

    public function view($modul)
    {
        $data = DB::table('category')
            ->orderby('sort')
            ->where('modul', $modul)
            ->get();

        return $this->get_category(Helper::tree_category($data));
    }

    public function show(Request $request)
    {
        $data = DB::table('category')
            ->where('id', $request->id)
            ->first();

        return response()->json($data);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'slug' => 'max:100',
        ]);
        if ($validator->passes()) {

            if ($request->id != '') {

//            slug($slug, $table, $select, $alt)

                if (empty($request->slug)) {
                    $slug = Helper::slug($request->title, 'category', $request->modul, $request->title);
                } else {
                    $slug = Helper::slug(null, 'category', $request->modul, $request->slug);
                }

                DB::table('category')
                    ->where('id', $request->id)
                    ->update(
                        [
                            'slug' => $slug,
                            'title' => $request->title,
                            'description' => $request->description,
                            'modul' => $request->modul,
                        ]
                    );

                $arr['type'] = 'edit';
                $arr['id'] = $_POST['id'];
                $arr['slug'] = $_POST['slug'];
                $arr['title'] = $_POST['title'];
                $arr['description'] = $_POST['description'];
                $arr['modul'] = $_POST['modul'];

            } else {

                if (empty($request->slug)) {
                    $slug = Helper::slug($request->title, 'category', $request->modul, $request->title);
                } else {
                    $slug = Helper::slug(null, 'category', $request->modul, $request->slug);
                }

                $lastId = DB::table('category')
                    ->insertGetId(
                        [
                            'slug' => $slug,
                            'title' => $request->title,
                            'description' => $request->description,
                            'modul' => $request->modul,
                        ]
                    );

                $arr['category'] = '<li class="dd-item dd3-item" data-id="' . $lastId . '" >
	                    <div class="dd-handle dd3-handle">Drag</div>
	                    <div class="dd3-content"><span id="title_show' . $lastId . '">' . $request->title . '</span>
	                        <span class="span-right"> &nbsp;&nbsp; 
	                        	<a class="edit-button" id="' . $lastId . '" ><i class="fa fa-pencil"></i></a>
                           		<a class="del-button" id="' . $lastId . '"><i class="fa fa-trash"></i></a>
	                        </span> 
	                    </div>';

                $arr['type'] = 'add';

            }
            return json_encode($arr);

        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function update(Request $request)
    {
        $data = json_decode($request->data);

        $readbleArray = Helper::parseJsonArray($data);

        foreach ($readbleArray as $key => $row) {
            DB::table('category')
                ->where('id', $row['id'])
                ->update(
                    [
                        'parent' => $row['parentID'],
                        'sort' => $key,
                    ]
                );

        }
    }

    public function destroy(Request $request)
    {
        $query = DB::table('category')
            ->where('parent', $request->id)
            ->get();

        if (count($query) > 0) {
            foreach ($query as $q) {
                DB::table('category')
                    ->where('id', $q->id)
                    ->delete();
            }
        }

        DB::table('category')
            ->where('id', $request->id)
            ->delete();
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required|max:100',
        ]);
        if ($validator->passes()) {
            $data['modul'] = $request->modul;
            $data['title'] = $request->category;
            $data['slug'] = Helper::slug(null, 'category', $request->modul, $request->category);
            $data['parent'] = $request->parent;

            DB::table('category')
                ->insert($data);

            $category = DB::table('category')
                ->where('modul', $request->modul)
                ->get();

            return view('admin.category.view',
                [
                    'category' => Helper::tree_category($category)
                ]
            );
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

}
