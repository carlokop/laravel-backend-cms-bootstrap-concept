<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Comment;

/*
* Middleware checks if logged-in user is admin
* Not valid users are redirected
*/

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::check()) {

            if( Auth::user()->isAdmin() ) {
                
                //add logged in user to all views
                $loggedinUser = auth()->user();
                \View::share('loggedinUser', $loggedinUser);

                //add nr of open cmments to all views
                $commentOpenCount = Comment::whereApproved(false)->count();
                \View::share('commentOpenCount', $commentOpenCount);

                return $next($request);
            }
        }

        return redirect('/');
    }

    




}
