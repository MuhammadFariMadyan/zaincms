<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
    public function index()
    {

        $data = [
            'count_post' => DB::table('posts')->count(),
            'count_page' => DB::table('pages')->count(),
        ];

        $meta = [
            'title' => 'Dashboard',
            'keyword' => 'dasboard',
            'description' => 'dasboard',
        ];
        return view('admin.home',
            [
                'data' => $data,
                'meta' => $meta
            ]
        );
    }
}
