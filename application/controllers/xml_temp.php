<?php
$servername = '35.228.64.37';
$dbname = '5bit';
$username = '5bit-prod';
$password = 'y96wyijq7x3nuQi';

$xml = new SimpleXMLElement('<rates/>');

$reg_cur = [];
$crypto_cur = [];
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $conn->prepare("SELECT id,crypto,bestchange,kraken_com,reserv FROM valut");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach($data as $row) {
          if($row['crypto'] == '0'){$reg_cur[$row['id']]['bestchange'] = $row['bestchange'];}
		  else{
			  
			 //$crypto_cur[$n]['id'] = $row['id']; 
			 $crypto_cur[$row['id']]['crypto'] = $row['crypto']; 
			 $crypto_cur[$row['id']]['bestchange'] = $row['bestchange']; 
			 $crypto_cur[$row['id']]['kraken_com'] = $row['kraken_com']; 
			 $crypto_cur[$row['id']]['reserv'] = $row['reserv']; 
			 
			 //$n++;
		  }
		  
		  
		}			  
	
	

	}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }





//print_r($crypto_cur);










for($i=1;$i<=count($reg_cur);$i++){
	if($i == '1'){$currency = 'USD';}
	if($i == '2'){$currency = 'EUR';}
	
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $conn->prepare("SELECT value FROM options WHERE `key` = 'bestchange_from_com'");
    $stmt->execute();
    $from_com = $stmt->fetch(PDO::FETCH_ASSOC);

	$stmt = $conn->prepare("SELECT * FROM valut_rates WHERE valut1 = '$i' AND time > 0");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	  foreach($data as $row) {
            $crypto_name = $crypto_cur[$row['valut2']]['bestchange'];			
        	$stmt = $conn->prepare("SELECT com FROM valut WHERE bestchange = '$crypto_name'");
            $stmt->execute();
            $crypto_com = $stmt->fetch(PDO::FETCH_ASSOC);
			 
	$item = $xml->addChild('item');
    $from = $item->addChild('from',$reg_cur[$i]['bestchange']);
    $to = $item->addChild('to',$crypto_name);
    $in = $item->addChild('in','1');
    $out = $item->addChild('out',$row['rate']);
    $amount = $item->addChild('amount',$crypto_cur[$row['valut2']]['reserv']);
    $minamount = $item->addChild('minamount','50 '.$currency);
    $maxamount = $item->addChild('maxamount','10000 '.$currency);
	$fromfee = $item->addChild('fromfee',$from_com['value'].' %');
	$tofee = $item->addChild('tofee',$crypto_com['com'].' '.$crypto_cur[$row['valut2']]['bestchange']);
    $param = $item->addChild('param','verifying');
 
      }
	}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
}
$conn = null;

	
Header('Content-type: text/xml');
//print($xml->asXML());
//$xml->asXML("../../bestchange.xml");
?>