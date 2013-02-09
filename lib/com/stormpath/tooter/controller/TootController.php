<?php

class tooter_controller_TootController
{
	private $tootValidator;
	
	private $tootDao;
	
	private $customerDao;
	
	private $stormpath;
	
	public function __construct($stormpath)
	{
		$this->stormpath = $stormpath;
		
		//init the persistence layer
		$this->tootDao = new tooter_model_dao_DefaultTootDao($stormpath->getConnector());
		
		$this->tootValidator = new tooter_validator_TootValidator();
	}
	
	public function submit($toot)
	{
		$status = new tooter_model_Status();
	
		$checked = $this->tootValidator->validate($toot);
		if(!empty($checked))
			return $checked;
		
		//act on the user stored in the session directly and so no reutrn value is needed for representing user
		$user = $_SESSION["user"];
		$persistCustomer = tooter_model_User::constructWithUser($user);
		
		$tootList;
		$persistToot = new tooter_model_Toot;
		$persistToot->setTootMessage($toot->getTootMessage());
        $persistToot->setCustomer($persistCustomer);
		
		try
		{
			$this->tootDao->saveToot($persistToot);
			$toot->setTootId($persistToot->getTootId());
			
			
			$tootList = $this->tootDao->getTootsByUserId($persistCustomer->getId());

			foreach ($tootList as $key=>$itemToot) {
				$itemToot->setCustomer($user);
			}

			krsort($tootList, SORT_NUMERIC);
			$user->setTootList($tootList);
			
			$status->setStatus(Tooter_Service::SUCCESS);
			
		}
		catch(Exception $e)
		{
			$status->setStatus(Tooter_Service::FAILED);
		}
		
		return $status;
	}
	
	
}