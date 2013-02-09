<?php

class tooter_model_dao_DefaultTootDao
	extends tooter_model_dao_BasicDao
	implements tooter_model_dao_TootDao
{
	public function __construct($connector)
	{
		parent::__construct($connector);
	}

	public function getTootsByUserId($custId)
	{
		return $this->connector->get(parent::TTOOT, $custId);
	}
	
	public function saveToot($toot)
	{
		$this->connector->save($toot);
		return $toot;
	}
	
	public function removeTootById($tootId)
	{
		
	}
}