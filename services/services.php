<?php
include_once('configure.php');
$databaseName = 'main_database';

if($_SERVER['REQUEST_METHOD'] == "POST") {
    $myPostData = json_decode($HTTP_RAW_POST_DATA);
    if(isset($myPostData->ownerDetails)){
        if(isset($myPostData->ownerDetails->id)){
            updateOwner($myPostData->ownerDetails);
        }else{
            addOwners($myPostData->ownerDetails);
        }
    }else if(isset($myPostData->bookingDetails)){
        if(isset($myPostData->bookingDetails->id)){
            updateBooking($myPostData->bookingDetails);
        }else{
            addBooking($myPostData->bookingDetails);
        }
    }else if(isset($myPostData->bikeDetails)){
        if(isset($myPostData->bikeDetails->id)){
            updateBike($myPostData->bikeDetails);
        }else{
            addBike($myPostData->bikeDetails);
        }
    }else if(isset($myPostData->orderDetails)){
        if(isset($myPostData->orderDetails->id)){
            updateOrder($myPostData->orderDetails);
        }else{
            addOrder($myPostData->orderDetails);
        }
    }
}else if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['ownerId'])){
        deleteOwner($_GET['ownerId']);
    }else if(isset($_GET['bookingid'])){
        removeBooking($_GET['bookingid']);
    }else if(isset($_GET['bikeId'])){
        deleteBike($_GET['bikeId']);
    }else if(isset($_GET['orderId'])){
        deleteOrder($_GET['orderId']);
    }
}
mysql_close($connection);
?>
<?php

function addOwners($ownerData){
    $query = "INSERT INTO `main_database`.`bike_owner`  (`id`, `name`, `address`, `email`, `mob`, `offc_address`) VALUES (NULL, '$ownerData->name', '$ownerData->address','$ownerData->email','$ownerData->mob','$ownerData->offcadd');";
    $result = mysql_query($query);
    if($result){
        echo  "Done! Owner added Sucessfully";
    }else{
        echo  "ERROR! Cannot add  Owner";
    }
}

function updateOwner($ownerData){
    $query = "select * from `main_database`.`bike_owner` where id='$ownerData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`bike_owner` set name='$ownerData->name',address ='$ownerData->address',email='$ownerData->address',mob='$ownerData->mob',offc_address='$ownerData->offcadd' where id='$ownerData->id'";
        $result = mysql_query($query);
        if($result){
            echo  "Done! Owner Updated Sucessfully";
        }else{
            echo  "ERROR! Cannot Update Owner";
        }
    }else{
        echo  "ERROR! No Such Bike Owner Exists";
    }
}
function deleteOwner($id){

    $query = "select * from `main_database`.`bike_owner` where id='$id'";
    $result = mysql_query($query);
    if(mysql_fetch_object($result)){
        $query = "DELETE FROM `main_database`.`bike_owner` WHERE id='$id'";
        $result = mysql_query($query)or die("Query failed : " . mysql_error());
        print_r($id);
        if($result){
            echo  "Done! Owner Deleted";
        }else{
            echo  "ERROR! No Such Owner Exist";
        }
    }else{
        echo  "ERROR! No Such Bike Owner Exists";
    }

}

function addBooking($bookingData){
    $query = "INSERT INTO `main_database`.`booking`  (`id`, `startdate`, `starttime`, `enddate`, `endtime`, `bikeid`) VALUES (NULL, '$bookingData->startdate', '$bookingData->starttime','$bookingData->enddate','$bookingData->endtime','$bookingData->bikeid');";
    $result = mysql_query($query);
    if($result){
        echo  "Done! Booking done Sucessfully";
    }else{
        echo  "ERROR! something went wrong!!!";
    }
}

function updateBooking($bookingData){

    $query = "select * from `main_database`.`booking` where id='$bookingData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`booking` set startdate='$bookingData->startdate',starttime ='$bookingData->starttime',enddate='$bookingData->enddate',endtime='$bookingData->endtime',bikeid='$bookingData->bikeid' where id='$bookingData->id'";
        $result = mysql_query($query);
        if($result){
            echo  "Done! Owner Updated Sucessfully";
        }else{
            echo  "ERROR! Cannot Update Owner";
        }
    }else{
        echo  "ERROR! No Such Booking Exists";
    }
}
function removeBooking($id)
{
    $query = "select * from `main_database`.`booking` where id='$id'";
    $result = mysql_query($query);
    if (mysql_fetch_object($result)) {
        $query = "DELETE FROM `main_database`.`booking` WHERE id='$id'";
        $result = mysql_query($query) or die("Query failed : " . mysql_error());
        if ($result) {
            echo "Done! Booking Removed";
        } else {
            echo "ERROR! No Such Booking Exist";
        }
    } else {
        echo "ERROR! No Such Booking  Exists";

    }
}
function addBike($bikeData){
    $query = "INSERT INTO `main_database`.`bike` (`id`, `name`, `description`, `number_plate`, `image`, `chasisnumber`, `rate_per_hr`, `bike_owner_id`) VALUES (NULL, '$bikeData->name', '$bikeData->description','$bikeData->number_plate','$bikeData->image','$bikeData->chasisnumber','$bikeData->rate_per_hr',NULL );";
    $result = mysql_query($query);
    if($result){
        echo  "Done! Bike added Sucessfully";
    }else{
        echo  "ERROR! Cannot add  Bike";
    }
}
function updateBike($bikeData){
    $query = "select * from `main_database`.`bike` where id='$bikeData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`bike` set name='$bikeData->name',description ='$bikeData->description',number_plate='$bikeData->number_plate',image='$bikeData->image',chasisnumber='$bikeData->chasisnumber',rate_per_hr='$bikeData->rate_per_hr',bike_owner_id='$bikeData->bike_owner_id' where id='$bikeData->id'";
        $result = mysql_query($query);
        if($result){
            echo  "Done! Owner Updated Sucessfully";
        }else{
            echo  "ERROR! Cannot Update Owner";
        }
    }
}
function deleteBike($id){

    $query = "DELETE FROM `main_database`.`bike` WHERE id='$id'";
    $result = mysql_query($query);print_r($result);
    if($result){
        echo  "Done! Owner Deleted";
    }else{
        echo  "ERROR! No Such Owner Exist";
    }
}

function addOrder($orderData){
    $query = "INSERT INTO `main_database`.`order_details` (`id`, `bookingid`, `totalfare`, `date`) VALUES (NULL, '$orderData->bookingid', '$orderData->totalfare','$orderData->date');";
    $result = mysql_query($query);
    if($result){
        echo  "Done! Bike added Sucessfully";
    }else{
        echo  "ERROR! Cannot add  Bike";
    }
}

function updateOrder($orderData){
    $query = "select * from `main_database`.`order_details` where id='$orderData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`order_details` set bookingid='$orderData->bookingid',totalfare ='$orderData->totalfare',date='$orderData->date' where id='$orderData->id'";
        $result = mysql_query($query);
        if($result){
            echo  "Done! Owner Updated Sucessfully";
        }else{
            echo  "ERROR! Cannot Update Owner";
        }
    }
}

function deleteOrder($id){

    $query = "DELETE FROM `main_database`.`order_details` WHERE id='$id'";
    $result = mysql_query($query);
    if($result){
        echo  "Done! Owner Deleted";
    }else{
        echo  "ERROR! No Such Owner Exist";
    }
}