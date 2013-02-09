<?php

class tooter_controller_LoginController
{
	private $loginValidator;
	
	private $customerDao;
	
	private $stormpath;
	
	private $permissionUtil;
	
	/*
	public function LoginController($loginValidator)
	{
		$this->loginValidator = $loginValidator;
	}*/
	
	public function __construct($stormpath)
	{
		$this->stormpath = $stormpath;
		
		$this->customerDao = new tooter_model_dao_DefaultCustomerDao($stormpath->getConnector());
		
		$this->loginValidator = new tooter_validator_LoginValidator();
		
		//var_dump($this->customerDao);
	}
	
	public function submit($customer)
	{
		$status = new tooter_model_Status();
		$checkEmpty = $this->loginValidator->validate($customer);
		if($checkEmpty == true)
		{
			$status->setStatus(Tooter_Service::FAILED);
			$status->setError(new tooter_model_Error("customer.errors", "help-block", "Field name and password is required"));
			
			return $status;
		}
		
		$returnStatus = array();
		
		try
		{
			$request = new Services_Stormpath_Authc_UsernamePasswordRequest($customer->getUserName(), $customer->getPassword());
			
			$authcResult = $this->stormpath->getApplication()->authenticateAccount($request);
			
			//var_dump($authcResult);
			
			$account = $authcResult->getAccount();
			
			//echo $account->getGivenName()." ".$account->getSurname()."\r\n".$account->getEmail();
			
			$user = tooter_model_User::constructWithAccount($account);
			
			$dbCustomer = $this->customerDao->getCustomerByUserName($customer->getUserName());
			if(empty($dbCustomer))
				$this->customerDao->saveCustomer($user);
			if($dbCustomer != null)
				$user->setId($dbCustomer->getId());
			
			if(!empty($user))
			{
				$status = new tooter_model_Status();
				$status->setStatus(Tooter_Service::SUCCESS);
				$status->setObj(array("user"=>$user));
			} 
		} 
		catch(Exception $e)
		{
			$status = new tooter_model_Status();
			$status->setStatus(Tooter_Service::FAILED);
			$status->setError(new tooter_model_Error("customer.errors", "help-block", $e->getMessage()));
		}
		
		return $status;
	}
}