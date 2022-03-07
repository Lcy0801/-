<?php
header("Content-type:text/json;charset=utf-8");
$url='http://api.map.baidu.com/geoconv/v1/?';
$ak='a98DrZiueYyl3Rggx5L2Y4HZ62QS3KuZ';
$output='json';
$coords=$_GET['coords'];
$from=$_GET['source'];
$to=$_GET['destination'];
//$coords='116.40466,39.90684';
//$from=1;
//$to=5;
//构建查询API
$url.='output='.$output.'&'.'coords='.$coords.'&'.'from='.$from.'&'.'to='.$to;
$url.='&'.'ak='.$ak;
//发起HTTP请求
$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
?>