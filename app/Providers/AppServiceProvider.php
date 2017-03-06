<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\User;
use \Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
        User::creating(function ($user) {
        $imagedata = file_get_contents("https://placeimg.com/48/48/user");
        $base64 = base64_encode($imagedata);
        $img = sprintf("data:image/png;base64,%s", $base64);
        $user->image = $img;
        
        // return "<img src='$img'/>";
        //     $imagedata = file_get_contents("http://lorempixel.com/people/80/80");
        //     $base64 = base64_encode($imagedata);
        //     Log::info($base64);
            // return ;
            // dd($base64);
            // Log::debug('image');
            // Log::info($imagedata);
            // Log::info($base64);
            // return 'success';
            // return $base64;
            // $user->image = sprintf("data:image/jpg;base64,%s",$base64);
            // Log::info('user -> creating' . $user);
        });
        
        User::created(function ($user) {
            // if ( ! $user->isValid()) {
            //     return false;
            // }
            Log::info('user -> created' . $user);
        });
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
