<?php 


class Swaggerhub
{
	private $secret;
	private $ident;
	
	function __construct($secret,$ident) {
		$this->secret=$secret;
		$this->ident=$ident;
	}
	
	public function GenSign($query ) {
	  return hash_hmac ( "sha1" ,  $query , $this->secret );
	}
	
	public function query($url,$params)
	{
		$query = http_build_query($params); 
		$sign = $this->GenSign($query);
		
		return $res = file_get_contents('https://'.$url.'?'.$query.'&sign='.$sign);
	}
	
	public function history()
	{
		$params = array(
		  'begin' => time()-24*3600 ,
		  'ident' => $this->ident
		);

		return $res= $this->query('api.enfins.com:9300/v1/history',$params);
		
		
	}
	
	public function create_bill($sum,$valut,$order_id)
	{
		$params = array(
		  'amount' => $sum,
		  'currency' => $valut,
		  'description' => 'Order #'.$order_id,
		  'm_order' => $order_id,
		  'ident' => $this->ident,
		  'success_url'=>site_url().'offer?id='.$order_id
		  ,'fail_url'=>site_url().'offer?id='.$order_id
		);
		
		$res= $this->query('api.enfins.com:9300/v1/create_bill',$params);
		$res=json_decode($res);
		//addlog($res);
		return $res->data->url;
	}
}