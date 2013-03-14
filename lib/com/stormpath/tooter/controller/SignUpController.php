<?php

class tooter_controller_SignUpController
{
	private $customerDao;
	
	private $stormpath;
	
	private $administratorGroupURL;
	
	private $premiumGroupURL;
	
	private $signUpValidator;
	
	public function __construct($stormpath)
	{
		$this->stormpath = $stormpath;
		
		//initilizing persistence layer to connect to database;
		$this->customerDao = new tooter_model_dao_DefaultCustomerDao($stormpath->getConnector());
		
		$this->signUpValidator = new tooter_validator_SignUpValidator();
	}
	
	public function processSubmit($user)
	{
		$checked = $this->signUpValidator->validate($user);
		if(!empty($checked))
			return $checked;
		
		$status = new tooter_model_Status();
		
		//$returnStatus = array();
		try{
			$userName = strtolower($user->getFirstName()).strtolower($user->getLastName());
			
			// Create the account in the Directory where the Tooter application belongs.
			$directory = $this->stormpath->getDataStore()->getResource($this->stormpath->getDirectoryURL(), Services_Stormpath::DIRECTORY);
			
			$account = $this->stormpath->getDataStore()->instantiate(Services_Stormpath::ACCOUNT);
			$account->setEmail($user->getEmail());
			$account->setGivenName($user->getFirstName());
			$account->setPassword($user->getPassword());
			$account->setSurname($user->getLastName());
			$account->setUsername($userName);
			
			$directory->createAccount($account); //$account = The method return one NULL VALUE !!!
			
			//adding group after the account has been created
			$groupUrl = $user->getGroupUrl();
			if(!empty($groupUrl))
			{
				$dataStore = $this->stormpath->getDataStore();
				$group = $dataStore->getResource($groupUrl, Services_Stormpath::GROUP);
				$account->addGroup($group);
			}
			
			$user->setUserName($userName);
			$user->setAccount($account);
			$this->customerDao->save($user);
			
			$status->setStatus(Tooter_Service::SUCCESS);
			$status->setObj(array("user"=>$user));
		}
		catch (Exception $e)
		{
			$status->setStatus(Tooter_Service::FAILED);
			$status->setError(new tooter_model_Error("signup.errors", "errorblock", $e->getMessage()));
		}
		
		return $status;
	}
	
}