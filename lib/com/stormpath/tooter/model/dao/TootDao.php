<?php

interface tooter_model_dao_TootDao
{
	public function getTootsByUserId($custId);
	
	public function saveToot($toot);
	
	public function removeTootById($tootId);
}