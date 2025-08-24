<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        //$profile = Profile::find(Auth::user()->id);
        //dd($profile);
        if(empty($profile->esignature)) 
        {
            return redirect()->route('profiles.index');     
        } else {
            if(Auth::user()->is_active == 0) 
            {
                return redirect()->route('profiles.adminApproval');
            }  
        }

        return $next($request); 

        
        
    }
}
