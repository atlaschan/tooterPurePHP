<?php

function tooter_autoload($className)
{
	if (substr($className, 0, 6) != 'tooter') {
        return false;
    }
    $file = str_replace('_', '/', $className);
    $file = str_replace('tooter/', '', $file);
    return include dirname(__FILE__) . "/$file.php";
}

function tooter_loadall()
{
	
}

spl_autoload_register('tooter_autoload');

class Tooter_Service
{
	
	const SUCCESS = "Succeeded";
	const FAILED = "Failed";
	
	public static function getStormpath($application_property)
	{
		
		return tooter_model_sdk_DefaultStormpathService::make($application_property);
	}
}