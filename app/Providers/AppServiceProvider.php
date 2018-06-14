<?php

namespace App\Providers;

use App\Helpers\Helper;
use Illuminate\Support\ServiceProvider;
use DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $config = DB::table('configs')
            ->select('name as author', 'email', 'site_title', 'telp', 'address', 'fb', 'twitter', 'instagram', 'gplus', 'pinterest',
                'lng', 'lat', 'seo', 'keyword', 'image')
            ->leftJoin('users', 'users.id', '=', 'configs.user_id')
            ->first();

        $menu = DB::table('menu')
            ->get();

        View::share('config', $config);
        View::share('dataMenu', Helper::tree_category($menu));

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
