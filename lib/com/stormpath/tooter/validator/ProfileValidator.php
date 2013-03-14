<?php

class tooter_validator_ProfileValidator
	implements tooter_validator_Validator
{
	public function validate($obj)
	{
		$email = $obj->getEmail();
		$email = trim($email);
		if(empty($email))
			return $this->report("profile.errors", "errorblock", "profile.required.email");
			
		$firstName = $obj->getFirstName();
		$firstName = trim($firstName);
		if(empty($firstName))
			return $this->report("profile.errors", "errorblock", "profile.required.firstName");
		
		$lastName = $obj->getLastName();
		$lastName = trim($lastName);
		if(empty($lastName))
			return $this->report("profile.errors", "errorblock", "profile.required.lastName");
		
		return null;
	}
	
	private function report($id, $styleClass, $message)
	{
		$status = new tooter_model_Status;
		$status->setStatus(Tooter_Service::FAILED);
		$status->setError(new tooter_model_Error($id, $styleClass, $message));
		return $status;
	}
}