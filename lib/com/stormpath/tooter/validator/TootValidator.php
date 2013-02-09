<?php

class tooter_validator_TootValidator
	implements tooter_validator_Validator
{
	/**
	* Only return a status when one error is detected.
	*/
	public function validate($obj)
	{
		$message = $obj->getTootMessage();
		$message = trim($message);
		if(empty($message))
		{
			$status = new tooter_model_Status;
			$status->setStatus(Tooter_Service::FAILED);
			//the last parameter being the error message key and its linked value is stored in message.properties file
			$status->setError(new tooter_model_Error("toot.errors", "errorblock", "tooter.required")); 

			return $status;
		}
		
		if(strlen($message) > 200)
		{
			$status = new tooter_model_Status;
			$status->setStatus(Tooter_Service::FAILED);
			$status->setError(new tooter_model_Error("toot.errors", "errorblock", "tooter.too.many.chars"));
			return $status;
		}
		
		return null;
	}
}