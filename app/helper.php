<?php
use App\Models\Country;
if (!function_exists('getCountryListFromDatabase')) {
    function getCountryList()
    {
        return Country::pluck('name','id')->toArray();
    }
}
