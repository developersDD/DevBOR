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
}else if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['ownerId'])){
        deleteOwner($_GET['ownerId']);
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
