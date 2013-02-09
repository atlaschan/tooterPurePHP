<?php

require 'stormpath-sdk-php/Services/Stormpath.php';
require 'com/stormpath/tooter/tooter_autoload.php';
session_start();


	function parse_property_file($file)
	{
		$content = file_get_contents($file);
		
		$target = array();
		preg_match_all("/([0-9a-zA-Z\\.]+\\s*)=(.+)/", $content, $match);
		
		if(empty($match))
			return $target;
		for($index = 0; $index < count($match[1]); $index++)
		{
			$target[trim($match[1][$index])] = trim($match[2][$index]);
		}
		return $target;
	}
	
	function redirect($page)
	{
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		header("Location: http://$host$uri/$page");
	}

$messages = parse_property_file("../config/message.properties");

$base_directory = "..";

$current_directory = ".";

$application_property = parse_property_file("../config/application.properties");

//used for initializing the stormpath service
$stormpath = Tooter_Service::getStormpath($application_property);



