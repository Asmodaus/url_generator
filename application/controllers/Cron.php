<?php
use TransactPRO\Gate\GateClient;
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting( E_ALL );
class Cron extends CI_Controller {
	   
	
	public function cron_min1( )
	{
		
		$this->db->query("UPDATE user_log l, users u SET l.logout=u.last_access WHERE l.logout=0 AND u.last_access<'".(time()-15*60)."' ");
		
	}
			
		
	
	
}
