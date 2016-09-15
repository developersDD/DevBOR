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
    }

    if(isset($myPostData->bikeDetails)){
        if(isset($myPostData->bikeDetails->id)){
            updateBike($myPostData->bikeDetails);
        }else{
            addBike($myPostData->bikeDetails);
        }
    }
}else if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['ownerId'])){
        deleteOwner($_GET['ownerId']);
    }
    if(isset($_GET['bikeId'])){
        deleteBike($_GET['bikeId']);
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
    }
}

function deleteOwner($id){

    $query = "DELETE FROM `main_database`.`bike_owner` WHERE id='$id'";
    $result = mysql_query($query);
    if($result){
        echo  "Done! Owner Deleted";
    }else{
        echo  "ERROR! No Such Owner Exist";
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