<?php

namespace App\Helpers;
use App\Models\LogActivity as LogActivityModel;
use Illuminate\Support\Facades\Request;

class LogActivity
{
    public static function addToLog($subject, $module, $module_ref_id)
    {
    	$log = [];
    	$log['subject'] = $subject;
    	$log['url'] = Request::fullUrl();
    	$log['method'] = Request::method();
    	$log['ip'] = Request::ip();
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        $log['module'] = $module;
        $log['module_ref_id'] =$module_ref_id;
    	LogActivityModel::create($log);
    }

    public static function logActivityLists()
    {
    	return LogActivityModel::latest()->get();
    }
}
