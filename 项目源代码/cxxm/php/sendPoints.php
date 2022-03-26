<?php
header("Content-type:text/json;charset=utf8");
class Result{
	public $result;
	public $detail;
	public $phPoints;
	public $gpsPoints;
}
class GPSPoint{
	public $date;
	public $X;
	public $Y;
	public $id;
}
class PHPoint{
	public $date;
	public $X;
	public $Y;
	public $ph;
	public $id;
}
$res=new Result();
$conn=new mysqli("localhost","root","mysql","cxxm",3306);
if($conn->connect_errno){
	$res->result=FALSE;
	$res->detail=urlencode("数据库连接失败！");
	$res->phPoints=NULL;
	$res->gpsPoints=NULL;
	exit;
}
$start=$_POST["start"];
$end=$_POST["end"];
$conn->query("set names utf8");
$sql="select * from coordinates where date > ".$start." and date <= ".$end;
$querygps=$conn->query($sql);
$gpsPoints=array();
while($row=$querygps->fetch_array()){
	$gpsPoint=new GPSPoint();
	$gpsPoint->date=(float)$row["date"];
	$gpsPoint->X=$row["X"];
	$gpsPoint->Y=$row["Y"];
	$gpsPoint->id=$row["id"];
	array_push($gpsPoints,$gpsPoint);
}
$sql="select * from phs where date > ".$start." and date <= ".$end;
$queryph=$conn->query($sql);
$phPoints=array();
while($row=$queryph->fetch_array()){
	$phPoint=new PHPoint();
	$phPoint->date=(float)$row["date"];
	$phPoint->X=$row["X"];
	$phPoint->Y=$row["Y"];
	$phPoint->ph=$row["ph_sim"];
	$phPoint->id=$row["id"];
	array_push($phPoints,$phPoint);
}
$res->result=TRUE;
$res->detail=urlencode("数据返回成功！");
$res->gpsPoints=$gpsPoints;
$res->phPoints=$phPoints;
echo urldecode(json_encode($res));
$conn->close();
?>