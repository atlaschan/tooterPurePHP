<?php

class tooter_controller_ProfileController
{
	private $profileValidator;
	
	private $stormpath;
	
	private $permissionUtil;
	
	public function __construct($stormpath)
	{
		$this->stormpath = $stormpath;
		
		$this->profileValidator = new tooter_validator_ProfileValidator();
	}
	
	public function submit($user, $modifiedUser)
	{		
		$checked = $this->profileValidator->validate($modifiedUser);
		if(!empty($checked))
			return $checked;
		
		try
		{
			$account = $user->getAccount();
			if($user->getFirstName() != $modifiedUser->getFirstName())
				$account->setGivenName($modifiedUser->getFirstName());
			if($user->getLastName() != $modifiedUser->getLastName())
				$account->setSurname($modifiedUser->getLastName());
			if($user->getEmail() != $modifiedUser->getEmail())
				$account->setEmail($modifiedUser->getEmail());
			
			$groupUrl = $modifiedUser->getGroupUrl();
			
			// remove the user's group memberships first.
			$dataStore = $this->stormpath->getDataStore();
			$groupExist = false; // possibly the group has been there for the account, set up one flag
			$memberships = $account->getGroupMemberships();
			foreach($memberships as $membership)
			{
				if(!empty($groupUrl))
				{
					// remove all groups that are not the target group
					$currentGroupName = $membership->getGroup()->getName();
					$group = $dataStore->getResource($groupUrl, Services_Stormpath::GROUP);
					if($currentGroupName != $group->getName())
						$membership->delete();
					else
						$groupExist = true;
				} 
				else
					$membership->delete();
			}
			
			// if the Basic is selected, or the target group has been selected, the add action will not be added
			if(!empty($groupUrl) and $groupExist == false)
			{
				$group = $dataStore->getResource($groupUrl, Services_Stormpath::GROUP);
				$account->addGroup($group);
			}
			
			$account->save();

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