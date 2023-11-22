<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Country;
use Illuminate\Support\Facades\URL;

class CountryMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $countryShortcode = $request->route('country')?? 'uk';  //get country part from url
        $country = Country::where('country_code', '=', $countryShortcode)->where('isAdvert', '=', 1)->first();
        if ($country === null) {
            $request->session()->put('country', 'uk');
            $request->session()->save();
            return redirect('/');
        }
        $request->session()->put('country', $country);
        $request->session()->save();
        //URL::defaults(['locale' => $request->segment(1)]);
        return $next($request);
    }
}
