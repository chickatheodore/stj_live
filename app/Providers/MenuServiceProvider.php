<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // get all data from menu.json file
        $verticalMenuJson = file_get_contents(base_path('resources/json/verticalMenu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

        $guard = $this->menuName();
        $horMenu = 'homeMenu.json';   //'horizontalMenu.json';
        if ($guard == 'admin')
            $horMenu = 'adminMenu.json';
        if ($guard == 'member')
            $horMenu = 'memberMenu.json';

        $horizontalMenuJson = file_get_contents(base_path('resources/json/' . $horMenu));
        $horizontalMenuData = json_decode($horizontalMenuJson);

        // Share all menuData to all the views
        \View::share('menuData',[$verticalMenuData, $horizontalMenuData]);
    }

    private function menuName() {
        if (isset($_SERVER['REQUEST_URI'])) {
            $route = $_SERVER['REQUEST_URI'];
            $hostname = ''; //getenv('HTTP_HOST');
            $pos = strpos($route, $hostname . '/member/');
            if ($pos === false) {
                $pos = strpos($route, $hostname . '/admin/');
                if ($pos === false)
                    return '';
                elseif ($pos == 0)
                    return 'admin';
            } else {
                if ($pos == 0)
                    return 'member';
                if ($pos > 0) {
                    $pos = strpos($route, $hostname . '/admin/');
                    if ($pos === false)
                        return '';
                    elseif ($pos == 0)
                        return 'admin';
                }
            }

            return '';
        }
        return '';
    }

    private function getGuard()
    {
        if(Auth::guard('admin')->check())
        {
            return "admin";
        }
        elseif(Auth::guard('member')->check())
        {
            return "member";
        }
        elseif(Auth::guard('web')->check())
        {
            return "web";
        }
        return "";
    }
}
