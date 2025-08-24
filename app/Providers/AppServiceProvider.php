<?php

namespace App\Providers;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function($view)
        {
            if(Auth::check()) {
                $currentUserId = Auth()->user()->id;
                $userProfile = Profile::where('user_id', $currentUserId)->first();
                $picture = $userProfile->picture;

                $view->with('currentPicture', $picture);
            } else {
                $view->with('currentPicture', 'no-pic.png');
            }

        });
        //dd(Auth::user());
        //if(!empty(Auth::user()->id)) 
        //{
           //$picture = Profile::where('user_id', '=', 1)->get();
           //dd($picture);
           $name = 'ronaldo banas';
            view()->share('name', $name); 
        //}
        
    }
}
