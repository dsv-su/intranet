<?php

namespace App\Http\Middleware;

use App\Models\Dashboard;
use Closure;
use Illuminate\Http\Request;
use Statamic\Auth\User;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserForReview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /****
         * Ensure the right reviewer reviews the request
         */

        $id = basename($request->path());
        $user = User::current();
        if(!$dashboard = Dashboard::find($id)) {
            $dashboard = Dashboard::where('request_id',$id)->first();
        }

        switch($dashboard->state) {
            case('submitted'):
                switch($dashboard->type) {
                    case('travelrequest'):
                        if($user->id == $dashboard->manager_id) {
                            return $next($request);
                        }
                        break;
                    case('projectproposal'):
                        if($user->id == $dashboard->head_id) {
                            return $next($request);
                        }
                        break;
                }
                break;
            case('manager_approved'):
                if($user->id == $dashboard->head_id) {
                    return $next($request);
                }
                break;
            case('head_approved'):
                switch($dashboard->type) {
                    case('travelrequest'):
                        if($user->id == $dashboard->fo_id) {
                            return $next($request);
                        }
                        break;
                    case('projectpropsal'):
                        if($user->id == $dashboard->vice_id) {
                            return $next($request);
                        }
                        break;
                }
                break;
            case('vice_approved'):
                if($user->id == $dashboard->fo_id) {
                    return $next($request);
                }
                break;
        }
        abort(401);
        return redirect('/');
    }
}
