<?php
class POI{
	public $name;
	public $lon;
	public $lat;
	public $address;
}
$url='http://api.map.baidu.com/place/v2/search?';
$ak='a98DrZiueYyl3Rggx5L2Y4HZ62QS3KuZ';
$output='json';
$keywod=$_GET["keyword"];
$pointLonLat=$_GET["pointLonLat"];
$radius=$_GET["radius"];
//$keywod="超市";
//$pointLonLat='39.90684,116.45016';
//$radius=1000;
$url.='ak='.$ak.'&'.'output='.$output;
$url.='&'.'query='.$keywod.'&'.'location='.$pointLonLat.'&'.'radius='.$radius;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
$output=json_decode($output);
$results=$output->results;
$pois=array();
foreach($results as $result){
	$poi=new POI();
	$poi->name=urlencode($result->name);
	$poi->lon=$result->location->lng;
	$poi->lat=$result->location->lat;
	$poi->address=urlencode($result->address);
	array_push($pois,$poi);
}
echo urldecode(json_encode($pois));
?>