<?php

function dateTime($timeStamp)
{
return date("Y-m-d H:i:s",$timeStamp);
}

function jc($data){
echo json_encode($data);
}

function preFormat($data="test"){

	$Data=array();
	$Data['Success']=true;
	$Data['Protocol']=200;
	$Data['VerboseMessage']="OK, The request has succeeded!";
	$Data['Results']=$data;
	return $Data;
}

function debug($data){
echo "<pre>";
print_r($data);
echo "</pre>";
}

function customFormat($success, $protocol, $vm,$result)
{
	$Data=array();
	$Data['Success']=$success;
	$Data['Protocol']=$protocol;
	$Data['VerboseMessage']=$vm;
	$Data['Results']=$result;
	return $Data;
}


?>