<?php
use TransactPRO\Gate\GateClient;
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting( E_ALL );
class Cron extends CI_Controller {
	
	public function test()
	{
		(new Exchange($this,4852))->renew_status();
		 die();
		$client = new GeoIp2\WebService\Client(129112, 'nT8RgJh7eYLR');

		// Replace "city" with the method corresponding to the web service that
		// you are using, e.g., "country", "insights".
		$record = $client->city('128.101.101.101');

		 
		print($record->country->name . "\n"); // 'United States'
		 
		print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota'
		 
		print($record->city->name . "\n"); // 'Minneapolis'
		$record = $client->isp('128.101.101.101');
		print($record->organization . "\n");
		$record = $client->connectionType('128.101.101.101');
		print($record->connectionType . "\n"); 
		$record = $client->anonymousIp('128.101.101.101');
		if ($record->isAnonymous) { print "anon\n"; }

		 
	}
	
	
	public function renew_balance()
	{
		foreach ((new Bitcoin($this))->get_all(999,0,'id','asc' ) as $row)
		{
			$res2 = json_decode(file_get_contents('https://blockexplorer.com/api/addr/'.$row['public_key'] ));
			if ($res2->balance!=$row['balance']) $this->db->update('bitcoin',array('balance'=>$res2->balance)); 
		}
		 
	}
	
	public function valut_rates($history=1)
	{
    	$bs = new Bitstamp("cfg1uz9albFibwys5Zg4TvpNLAZhUeph","DSU3efeGATbglYzMs8znKS0VQ8doCTQW","404331");
		if ($history==1)
		{
		//$this->db->query("DELETE FROM valut_rates ");
		//валюта 1 то что отдает, валюта 2 то что получает
		 foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>1)) as $crypto)
		 {
			 foreach ((new Valut($this))->get_all(999,0,'id','asc',array('crypto'=>0)) as $vlt)
			 {
				
				if (vars('kraken_bitsamp')=='2')
				{
					//echo '=='.$crypto['name'].$vlt['name'];
					if ($vlt['name']!='RUR') $res = $bs->ticker(strtolower($crypto['name'].$vlt['name'] ) );
					$val=$val2=$res['last'];
					
					 echo '<br>'.strtolower($crypto['name'].$vlt['name'] ).'='.$val;
					 
				}
				else {
					$res = $kraken->QueryPublic('Ticker', array('pair' => $crypto['kraken'].$vlt['kraken']));  
					$val2=$res['result'][$crypto['kraken'].$vlt['kraken']]['c'][0];
					$val=$res['result'][$crypto['kraken'].$vlt['kraken']]['c'][0];
				}
		
		
				
				
				//if (strlen($crypto['cex'])>0)
				//{
				//	$res2 = json_decode(file_get_contents('https://cex.io/api/ticker/'.$crypto['cex'].'/'.$vlt['cex']));
				//	$val=$res2->last;
				//} 
				//else 
				
				
				if ($val2<$val) {
					$val3=$val;
					$val=$val2;
					$val2=$val3;
					//меняем местами курсы если курс кракена ниже чем курс целл
				}
				if ($val2>0)
				{
					$this->db->where('valut1',$vlt['id']);
					$this->db->where('valut2',$crypto['id']);
					$this->db->update('valut_rates',array( 'rate'=>1/$val2,'time'=>time()));
					
				}
				if ($val>0)
				{
					$this->db->where('valut1',$crypto['id']);
					$this->db->where('valut2',$vlt['id']);				
					$this->db->update('valut_rates',array( 'rate'=>number_format($val,5,'.',''),'time'=>time()));
					
				} 
			 }
		 }
		}	
		 
		
		
	
}	
}
