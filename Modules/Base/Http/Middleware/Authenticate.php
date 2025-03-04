<?php

namespace Modules\Base\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;
use Illuminate\Support\Arr;
use Auth;

class Authenticate extends BaseAuthenticate
{
  public function handle($request, Closure $next, ...$guards)
  {
    //    echo '<pre>';
    //    print_r(auth()->user()->hasAccess(['inventory.customer.index']));
    //    echo '</pre>'; die();
    //
    // echo '<pre>';
    // print_r( \Modules\Acl\Entities\UserGroup::with('roles')->where('id','=',3)->get());
    // echo '</pre>'; die();


    $this->authenticate($request, $guards);

    if (!$guards) {
      $route = $request->route()->getAction();

      $flag = Arr::get($route, "permission", Arr::get($route, "as"));


      $flag = preg_replace('/.create.store$/', ".create", $flag);
      $flag = preg_replace('/.edit.update$/', ".edit", $flag);

      if (
        $flag &&
        !auth()
          ->user()
          ->can((array) str_replace(["backend."], "", $flag))
      ) {
        if ($request->expectsJson()) {
          return response()->json(["message" => "Unauthenticated."], 401);
        }
        return response()->view('base::errors.401');
        // return response()->json(["message" => "Unauthenticated."], 401);
      }
    }

    return $next($request);
  }

  /**
   * Get the path the user should be redirected to when they are not authenticated.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return string
   */
  protected function redirectTo($request)
  {
    if (!$request->expectsJson()) {
      return route("backend.login");
      // dd($url);
      //return redirect()->route('getLogin');
      // redirect($url);
    }
  }
}
