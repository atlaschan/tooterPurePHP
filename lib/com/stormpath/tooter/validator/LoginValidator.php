<?php

class tooter_validator_LoginValidator
	implements tooter_validator_Validator
{
	
	public function validate($obj)
	{
		$userName = $obj->getUserName();
		$password = $obj->getPassword();
		$userName = trim($userName);
		$password = trim($password);
		return empty($userName) or empty($password);
	}
}