<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Admin
{

  protected $auth;
    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle($request, Closure $next)
     {
             if ($this->auth->guest() || $this->auth->user()->statut!='Administrateur')
         {
                 if ($request->ajax())
                 {
                         return response('Unauthorized.', 401);
                 }
                 else
                 {
                         $request->session()->flash('error', "Votre compte n'a pas le bon statut !");
                         return redirect()->route('front');
                 }
         }
         return $next($request);
     }
}
