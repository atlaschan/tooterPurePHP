<?php

class tooter_controller_PasswordController
{
	private $resetPasswordValidator;
	
	private $stormpath;

	public function __construct($stormpath)
	{
		$this->stormpath = $stormpath;
		
		$this->resetPasswordValidator = new tooter_validator_ResetPasswordValidator();
	}
	
	public function processResetPassword($customer, $email)
	{
		$checked = $this->resetPasswordValidator->validate($email);
		if(!empty($checked))
			return $checked;
		
		$status = new tooter_model_Status();
		
		try
		{
			$this->stormpath->getApplication()->sendPasswordResetEmail($email);
			$status->setStatus(Tooter_Service::SUCCESS);
		}
		catch(Exception $e)
		{
			$status->setStatus(Tooter_Service::FAILED);
			$status->setError(new tooter_model_Error("password.errors", "errorblock", $e->getMessage()));
		}
		
		return $status;
	}
}