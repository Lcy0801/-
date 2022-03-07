<?php
header("Content-type:text/json;charset=utf-8");
class Result{
	public $result;
	public $detail;
}
$res=new Result();
$conn=new mysqli("localhost","root","mysql","cxxm",3306);
if($conn->connect_error){
	$res->result=FALSE;
	$res->detail=urlencode("服务器数据库连接失败！");
	echo urldecode(json_encode($res));
	exit;
}
$conn->query("set names utf8");
$qCllection=$conn->query("select * from coordinates where id =1");
$row=$qCllection->fetch_array();
$res->result=TRUE;
$res->detail=floatval($row["date"]);
echo json_encode($res);
?>