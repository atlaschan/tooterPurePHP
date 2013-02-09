<?php

interface tooter_model_dao_CustomerDao 
{
	public function getCustomerByUserName($userName);
	
	public function saveCustomer($customer);
	
	public function updateCustomer($customer);
}