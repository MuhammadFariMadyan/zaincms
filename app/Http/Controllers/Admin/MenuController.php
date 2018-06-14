<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use Validator;
use DB;

class MenuController extends Controller
{
    public function index()
    {
        $meta = [
            'title' => 'Menu',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];
        return view('admin.menu.index',
            [
                'meta' => $meta,
            ]);
    }


    function get_menu($items, $class = 'dd-list')
    {

        $html = "<ol class='" . $class . "' id='menu-id'>";

        foreach ($items as $key => $value) {
            $html .= '<li class="dd-item dd3-item" data-id="' . $value['id'] . '" >
                    <div class="dd-handle dd3-handle">Drag</div>
                    <div class="dd3-content"><span id="menu_show' . $value['id'] . '">' . $value['title'] . '</span> 
                        <span class="span-right"> &nbsp;&nbsp; 
                            <a class="edit-button" id="' . $value['id'] . '"><i class="fa fa-pencil"></i></a>
                            <a class="del-button" id="' . $value['id'] . '"><i class="fa fa-trash"></i></a></span> 
                    </div>';
            if (array_key_exists('child', $value)) {
                $html .= $this->get_menu($value['child'], 'child');
            }
            $html .= "</li>";
        }
        $html .= "</ol>";

        return $html;

    }

    public function view()
    {
        $data = DB::table('menu')
            ->orderby('sort')
            ->get();

        return $this->get_menu(Helper::tree_category($data));
    }

    public function show(Request $request)
    {
        $data = DB::table('menu')
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
                    $slug = Helper::slug($request->title, 'menu', null, $request->title);
                } else {
                    $slug = Helper::slug(null, 'menu', null, $request->slug);
                }

                DB::table('menu')
                    ->where('id', $request->id)
                    ->update(
                        [
                            'slug' => $slug,
                            'title' => $request->title,
                            'description' => $request->description,
                        ]
                    );

                $arr['type'] = 'edit';
                $arr['id'] = $_POST['id'];
                $arr['slug'] = $_POST['slug'];
                $arr['title'] = $_POST['title'];
                $arr['description'] = $_POST['description'];

            } else {

                if (empty($request->slug)) {
                    $slug = Helper::slug($request->title, 'menu', null, $request->title);
                } else {
                    $slug = Helper::slug(null, 'menu', null, $request->slug);
                }

                $lastId = DB::table('menu')
                    ->insertGetId(
                        [
                            'slug' => $slug,
                            'title' => $request->title,
                            'description' => $request->description,
                        ]
                    );

                $arr['menu'] = '<li class="dd-item dd3-item" data-id="' . $lastId . '" >
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
            DB::table('menu')
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
        $query = DB::table('menu')
            ->where('parent', $request->id)
            ->get();

        if (count($query) > 0) {
            foreach ($query as $q) {
                DB::table('menu')
                    ->where('id', $q->id)
                    ->delete();
            }
        }

        DB::table('menu')
            ->where('id', $request->id)
            ->delete();
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'menu' => 'required|max:100',
        ]);
        if ($validator->passes()) {
            $data['title'] = $request->menu;
            $data['slug'] = Helper::slug(null, 'menu', null, $request->menu);
            $data['parent'] = $request->parent;

            DB::table('menu')
                ->insert($data);

            $menu = DB::table('menu')
                ->get();

            return view('admin.menu.view',
                [
                    'menu' => Helper::tree_category($menu)
                ]
            );
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

}
