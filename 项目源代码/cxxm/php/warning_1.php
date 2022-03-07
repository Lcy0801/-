<?php
class Object{
	public $id;
	public $name;
	public $coord;
}
$res=array();
header("Content-type:text/json;charset=utf-8");
$conn=new mysqli("localhost","root","mysql","cxxm",3306);
if($conn->connect_error){
	$res=null;
	echo json_encode($res);
	exit;
}
$conn->query("set names utf8");
$sql="select * from warning";
$result=$conn->query($sql);
while($row=$result->fetch_array()){
	$object=new Object();
	$object->id=$row['id'];
	$object->name=urlencode($row['name']);
	//调用百度地图API获取坐标
	$object->coord=geocode($row['name']);
	array_push($res,$object);
}
echo urldecode(json_encode($res));
function geocode($name)
{
	$url='http://api.map.baidu.com/geocoding/v3/?';
	$ak='a98DrZiueYyl3Rggx5L2Y4HZ62QS3KuZ';
	$url.='ak='.$ak.'&'.'address='.$name.'&'.'output=json';
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$output = curl_exec($ch);
	curl_close($ch);
	$output=json_decode($output);
	$coord=array();
	array_push($coord,$output->result->location->lng);
	array_push($coord,$output->result->location->lat);
	return $coord;
}
?>