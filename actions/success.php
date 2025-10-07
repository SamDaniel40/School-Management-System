<?php

include ('../includes/config.php');
include ('../includes/functions.php');

session_start();
//require('config.php');
// extract($_REQUEST);
$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"];
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$month=$_POST["udf1"];
$salt="";


$user_id = isset($_SESSION['user_id'])?$_SESSION['user_id']:"";
$title = '';
$date = date('Y-m-d');

$query = sqlsrv_query($db_conn, "INSERT INTO tbl_Posts (Title, Type, PublishDate, Status, Author) VALUES (?,'Payment',?,?,?)",array($title,$date,$status,$user_id));

if($query){
    //$item_id = sqlsrv_insert_id($db_conn);
    $item_id=sqlsrv_get_field($query,0);
}

$payment_data = array(
    'txnId' => $txnid,
    'Amount' => $amount,
    'firstName' => $firstname,
    'productInfo' => $productinfo,
    'Status' => $status
);

foreach($payment_data as $key => $value){
    sqlsrv_query($db_conn, "UPDATE tbl_MetaData (ItemId, MetaKey, MetaValue) VALUE (?,?,?)",array($item_id,$key,$value));
}

$old_months = get_usermeta();
if($old_months){
    $old_months[] = 
    sqlsrv_query($db_conn, "UPDATE tbl_MetaData (ItemId, MetaKey, MetaValue) VALUE (?, 'months',)",array($item_id));
}else{
    $months = serialize(array($months));
    sqlsrv_query($db_conn, "INSERT INTO tbl_MetaData (ItemId, MetaKey, MetaValue) VALUE (?,'Months',?)",array($item_id,$months));
}


if (isset($_POST["additionalCharges"])) 
{
       $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
  } else {
        $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
         }
		 $hash = hash("sha512", $retHashSeq);
       
	  
	  // echo $status." ".$txnid;
		if ($status == "success" && $txnid!="") 
		{
		$msg = "Transaction completed successfully";	
		}
	     else 
		   {
           $msg = "Invalid Transaction. Please Try Again";
		   }
?>	