<?php

class tooter_validator_ResetPasswordValidator
	implements tooter_validator_Validator
{

	public function validate($obj)
	{
		$email = trim($obj);
		if(empty($email))
		{
			$status = new tooter_model_Status;
			$status->setStatus(Tooter_Service::FAILED);
			$status->setError(new tooter_model_Error("password.errors", "errorblock", "reset.password.required.email"));
			return $status;
		}
		return null;
	}
}