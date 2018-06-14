<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 10/06/18
 * Time: 14:26
 */

namespace App\Helpers;

use DB;

class Helper
{
    public static function tree_category($datas)
    {
        $ref = [];
        $items = [];

        foreach ($datas as $data) {

            $thisRef = &$ref[$data->id];

            $thisRef['id'] = $data->id;
            $thisRef['slug'] = $data->slug;
            $thisRef['title'] = $data->title;
            $thisRef['parent'] = $data->parent;
            $thisRef['description'] = $data->description;

            if ($data->parent == 0) {
                $items[$data->id] = &$thisRef;
            } else {
                $ref[$data->parent]['child'][$data->id] = &$thisRef;
            }
        }

        return $items;
    }

    public static function parseJsonArray($jsonArray, $parentID = 0)
    {
        $data = [];
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = [];
            if (isset($subArray->children)) {
                $returnSubSubArray = self::parseJsonArray($subArray->children, $subArray->id);
            }

            $data[] = ['id' => $subArray->id, 'parentID' => $parentID];
            $data = array_merge($data, $returnSubSubArray);
        }
        return $data;
    }

    public static function slug($slug, $table, $select, $alt)
    {
        $dataSlug = DB::table($table)
            ->select('slug')
            ->where('slug', str_slug($alt, '-'));
        if ($select) {
            $dataSlug->where('modul', $select);
        }
        $dataSlug = $dataSlug->count();

        if (empty($slug)) {
            if ($dataSlug >= 1) {
                $data = str_slug($alt, '-') . '-' . rand(0, 10);
            } else {
                $data = str_slug($alt, '-');
            }
        } else {
            if ($dataSlug >= 1) {
                $data = str_slug($slug, '-') . '-' . rand(0, 10);
            } else {
                $data = str_slug($slug, '-');
            }
        }

        return $data;
    }

    public static function paginate($items, $perPage, $page = null)
    {
        $page = $page ?: (\Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : \Illuminate\Support\Collection::make($items);
        return new \Illuminate\Pagination\LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]);
    }

    public static function get_post($category, $search)
    {
        $dataPosts = DB::table('posts')
            ->select('slug', 'title', 'category_id', 'name as name', 'plugin', 'image', 'posts.created_at')
            ->leftJoin('users', 'users.id', '=', 'posts.user_id')
            ->where('status', 1);
        if ($search) {
            $dataPosts->where('title', 'like', '%' . $search . '%');
        }
        if($category){
            $dataPosts->where('category_id', $category);
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
                    $category[] = [
                       'slug' => $c->slug,
                       'title' => $c->title
                    ];
                }
                if(empty($category)){
                    $slug_cat = 'uncatagorized';
                    $title_cat = 'uncatagorized';
                } else {
                    $slug_cat = $category[0]['slug'];
                    $title_cat = $category[0]['title'];
                }
            }
            $post[] = [
                'slug' => $d->slug,
                'title' => $d->title,
                'author' => $d->name,
                'slug_cat' => $slug_cat,
                'title_cat' => $title_cat,
                'image' => $d->image,
                'created_at' => $d->created_at,
            ];
        }

        return $post;

    }
}