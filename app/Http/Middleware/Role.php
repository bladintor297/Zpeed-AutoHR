<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Role as Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;

class Role {

  public function handle($request, Closure $next, String $role) {

    $user = Staff::where('staff_id',str_pad(Auth::id(), 3, '0', STR_PAD_LEFT))->first();
    if($user->role == $role)
      return $next($request);
    else {
      abort(404);
    }
  }
}