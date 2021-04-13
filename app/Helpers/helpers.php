<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Transaction;
use Config;
use Google\Cloud\Vision\VisionClient;

class Helper
{
    public static function applClasses()
    {
        // Demo
        // $fullURL = request()->fullurl();
        // if (App()->environment() === 'production') {
        //     for ($i = 1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, 'demo-' . $i);
        //         if ($contains === true) {
        //             $data = config('custom.' . 'demo-' . $i);
        //         }
        //     }
        // } else {
        //     $data = config('custom.custom');
        // }

        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'bodyClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage'=>'en',
            'direction' => env('MIX_CONTENT_DIRECTION', 'ltr'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, config('custom.custom'));

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => 'menu-static', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'fixed-footer', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage'=>array('en'=>'en','fr'=>'fr','de'=>'de','pt'=>'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => 'menu-expanded',
            'bodyClass' => $data['bodyClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage'=>$allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if(!session()->has('locale')){
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        // $fullURL = request()->fullurl();
        // if (App()->environment() === 'production') {
        //     for ($i = 1; $i < 7; $i++) {
        //         $contains = Str::contains($fullURL, 'demo-' . $i);
        //         if ($contains === true) {
        //             $demo = 'demo-' . $i;
        //         }
        //     }
        // }
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    Config::set('custom.' . $demo . '.' . $config, $val);
                }
            }
        }
    }

    public static function getTextFromGoogleVision($base64image)
    {
        $visionJson = file_get_contents(base_path('resources/json/stjBali.json'));

        $vision = new VisionClient(['keyFile' => json_decode($visionJson, true)]);
        $image = $vision->image($base64image,
            [
                'WEB_DETECTION',
                'TEXT_DETECTION'
            ]);

        $result = $vision->annotate($image);
        //print_r($result); exit;

        $texts = $result->text();
        $web = $result->web();

        foreach($texts as $key => $text)
        {
            $description[] = $text->description();
        }

        // fetch text from image //
        //print_r($description[0]);

        foreach ($web->entities() as $key => $entity)
        {
            $entity_per = number_format(@$entity->info()['score'] * 100 , 2);
            if(isset($entity->info()['description']))
            {
                $match_condition[$entity_per]=['Identity'=>ucfirst($entity->info()['description'])];
            }
            else
            {
                $match_condition[$entity_per]=['Identity'=>'N/A'];
            }
        }

        //print best match//
        $best_match = current($match_condition);
        return [
            'description' => $description,
            'match_condition' => $match_condition,
            'texts' => $texts,
            'web' => $web
        ];
    }

    public static function asset($path) {
        $base = base_path();
        $asset = asset($path);
        $time = filemtime($base . $path);

        $lastDot = strripos($asset, '.');
        $file = substr($asset, 0, $lastDot + 1) . $time . substr($asset, $lastDot);

        return $file;
    }

    public static function getLastTransaction($member, $type)
    {
        $transaction = Transaction::where('member_id', '=', $member->id)->orderByDesc('transaction_date')->first();
        if ($transaction !== null) {
            if ($type == 'all') {
                return $transaction->toArray();
            } if ($type == 'pin') {
                return [
                    //'pin_beginning_balance' => $transaction->pin_beginning_balance,
                    //'pin_amount' => $transaction->pin_amount,

                    'pin_beginning_balance' => $transaction->pin_ending_balance,
                    'pin_ending_balance' => $transaction->pin_ending_balance
                ];
            } else if ($type === 'point') {
                return [
                    //'left_point_beginning_balance' => $transaction->left_point_beginning_balance,
                    //'right_point_beginning_balance' => $transaction->right_point_beginning_balance,
                    //'left_point_amount' => $transaction->left_point_amount,
                    //'right_point_amount' => $transaction->right_point_amount,

                    'left_point_beginning_balance' => $transaction->left_point_ending_balance,
                    'right_point_beginning_balance' => $transaction->right_point_ending_balance,
                    'left_point_ending_balance' => $transaction->left_point_ending_balance,
                    'right_point_ending_balance' => $transaction->right_point_ending_balance,

                    //'bonus_beginning_balance' => $transaction->bonus_beginning_balance,
                    //'bonus_point_amount' => $transaction->bonus_point_amount,
                    //'bonus_sponsor_amount' => $transaction->bonus_sponsor_amount,
                    //'bonus_partner_amount' => $transaction->bonus_partner_amount,
                    //'bonus_paid_amount' => $transaction->bonus_paid_amount,

                    'bonus_beginning_balance' => $transaction->bonus_ending_balance,
                    'bonus_ending_balance' => $transaction->bonus_ending_balance,
                ];
            }
        }
        return null;
    }

}
