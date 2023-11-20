<?php
use App\Models\Country;
if (!function_exists('getCountryListFromDatabase')) {
    function getCountryList()
    {
        return Country::where('isAdvert',1)->get();
    }
}
