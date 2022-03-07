<?php
header("Content-type:text/json;charset=utf-8");
$conn=new mysqli("localhost","root","mysql","cxxm",3306);
if($conn->connect_error){
	echo FALSE;
	exit;
}
$flags=$_POST['flags'];
$rank=$_POST['rank'];
$warningtext=$_POST['text'];
foreach($flags as $flag){
	$id=$flag['id'];
	$sql="select * from warning where id =".$id;
	$result=$conn->query($sql);
	$row=$result->fetch_array();
	$mail=$row['mail'];
	$phone=$row['phone'];
	sendmail($mail, "污染预警:".$rank, $warningtext);
	sendMeaasge($phone, $warningtext);
}
echo TRUE;
function sendmail($to,$subject,$message){
	mail($to,$subject,$message);
}
function sendMeaasge($to,$message){
	$url='http://sms.webchinese.cn/web_api/?';
	$Uid='TJLcy';
	$Key='d41d8cd98f00b204e980';
	$smsMob=$to;
	$smsText=iconv('utf-8', 'gb2312', $message);
	$url.='Uid='.$Uid.'&'.'Key='.$Key.'&'.'smsMob='.$smsMob.'&'.'smsText='.$smsText;
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$file_contents = curl_exec($ch);
	curl_close($ch);
	return $file_contents;
}
?>