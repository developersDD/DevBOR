<?php
include_once('configure.php');
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
    }else if(isset($myPostData->userDetails)){
        if(isset($myPostData->userDetails->id)){
            updateUser($myPostData->userDetails);
        }else{
            addUser($myPostData->userDetails);
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
    }elseif(isset($_GET['getallbike'])){
        getAllBike();
    }elseif(isset($_GET['getbikebyid'])){
        getBikeById($_GET['getbikebyid']);
    }elseif(isset($_GET['getallowner'])){
        getAllOwner();
    }elseif(isset($_GET['getownerbyid'])){
        getOwnerById($_GET['getownerbyid']);
    }elseif(isset($_GET['getbyrph'])){
        getBikeByRatePerHr($_GET['getbyrph']);
    }elseif(isset($_GET['bikename'])){
        getByBikeName($_GET['bikename']);
    }elseif(isset($_GET['userid'])){
        deleteUser($_GET['userid']);
    }elseif(isset($_GET['autosearch'])){
        autoComplete();
    }
}
mysql_close($connection);
?>
<?php
function addOwners($ownerData){
    $query = "INSERT INTO `main_database`.`bike_owner`  (`id`, `name`, `address`, `email`, `mob`, `offc_address`) VALUES (NULL, '$ownerData->name', '$ownerData->address','$ownerData->email','$ownerData->mob','$ownerData->offcadd');";
    $result = mysql_query($query);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}
function updateOwner($ownerData){
    $query = "select * from `main_database`.`bike_owner` where id='$ownerData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`bike_owner` set name='$ownerData->name',address ='$ownerData->address',email='$ownerData->address',mob='$ownerData->mob',offc_address='$ownerData->offcadd' where id='$ownerData->id'";
        $result = mysql_query($query);
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    }else{
        echo  json_encode("ERROR! No Such Bike Owner Exists");
    }
}
function deleteOwner($id){

    $query = "select * from `main_database`.`bike_owner` where id='$id'";
    $result = mysql_query($query);
    if(mysql_fetch_object($result)){
        $query = "DELETE FROM `main_database`.`bike_owner` WHERE id='$id'";
        $result = mysql_query($query)or die("Query failed : " . mysql_error());
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    }else{
        echo  json_encode("ERROR! No Such Bike Owner Exists");
    }

}
function addBooking($bookingData){
    $query = "INSERT INTO `main_database`.`booking`  (`id`, `startdate`, `starttime`, `enddate`, `endtime`, `bikeid`) VALUES (NULL, '$bookingData->startdate', '$bookingData->starttime','$bookingData->enddate','$bookingData->endtime','$bookingData->bikeid');";
    $result = mysql_query($query);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}
function updateBooking($bookingData){

    $query = "select * from `main_database`.`booking` where id='$bookingData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`booking` set startdate='$bookingData->startdate',starttime ='$bookingData->starttime',enddate='$bookingData->enddate',endtime='$bookingData->endtime',bikeid='$bookingData->bikeid' where id='$bookingData->id'";
        $result = mysql_query($query);
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    }else{
        echo  json_encode("ERROR! No Such Booking Exists");
    }
}
function removeBooking($id){
    $query = "select * from `main_database`.`booking` where id='$id'";
    $result = mysql_query($query);
    if (mysql_fetch_object($result)) {
        $query = "DELETE FROM `main_database`.`booking` WHERE id='$id'";
        $result = mysql_query($query) or die("Query failed : " . mysql_error());
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    } else {
        echo  json_encode("ERROR! No Such Booking Exists");

    }
}
function addBike($bikeData){
    $query = "INSERT INTO `main_database`.`bike` (`id`, `name`, `description`, `number_plate`, `image`, `chasisnumber`, `rate_per_hr`, `bike_owner_id`) VALUES (NULL, '$bikeData->name', '$bikeData->description','$bikeData->number_plate','$bikeData->image','$bikeData->chasisnumber','$bikeData->rate_per_hr',NULL );";
    $result = mysql_query($query);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}
function updateBike($bikeData){
    $query = "select * from `main_database`.`bike` where id='$bikeData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`bike` set name='$bikeData->name',description ='$bikeData->description',number_plate='$bikeData->number_plate',image='$bikeData->image',chasisnumber='$bikeData->chasisnumber',rate_per_hr='$bikeData->rate_per_hr',bike_owner_id='$bikeData->bike_owner_id' where id='$bikeData->id'";
        $result = mysql_query($query);
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    }
}
function deleteBike($id){

    $query = "DELETE FROM `main_database`.`bike` WHERE id='$id'";
    $result = mysql_query($query);print_r($result);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}

function addOrder($orderData){
    $query = "INSERT INTO `main_database`.`order_details` (`id`, `bookingid`, `totalfare`, `date`) VALUES (NULL, '$orderData->bookingid', '$orderData->totalfare','$orderData->date');";
    $result = mysql_query($query);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}

function updateOrder($orderData){
    $query = "select * from `main_database`.`order_details` where id='$orderData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`order_details` set bookingid='$orderData->bookingid',totalfare ='$orderData->totalfare',date='$orderData->date' where id='$orderData->id'";
        $result = mysql_query($query);
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    }
}

function deleteOrder($id){

    $query = "DELETE FROM `main_database`.`order_details` WHERE id='$id'";
    $result = mysql_query($query);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}

function getAllBike(){

    $query = "select * from `main_database`.`bike`";
    $result = mysql_query($query);
    $arrayData = array();
    if($result){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
    }else{
        echo json_encode("No Data Found");
    }
}

function getBikeById($bikeId){

    $query = "select * from `main_database`.`bike` where id='$bikeId'";
    $result = mysql_query($query);
    $arrayData = array();
    if($result){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
    }else{
        echo json_encode("No Data Found");
    }

}
function getByBikeName($bikeName){
    $query = "select * from `main_database`.`bike` where name LIKE '%$bikeName%' ORDER BY name ASC";
    $result = mysql_query($query);

    $arrayData = array();
    if(mysql_fetch_assoc($result)){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
       // echo '<ul><li style="display:none"></li><li title="bike" class="">Apache</li><li title="bike" class=""> Apache</li><li title="bike">Apache</li></ul>';
    }else{
        echo json_encode("No Data Found");
    }
}

function autoComplete(){

    $query = "select id,name from `main_database`.`bike`;";
    $result = mysql_query($query);
    $data = "";
    $data .='<ul>';
    if(mysql_fetch_array($result)){
        while($row = mysql_fetch_assoc($result)){
            $id = $row['id'];
            $name = $row['name'];
            $data .= '<li style="display:none"></li><li title="bike" id="'.$id.'">"'.$name.'"</li>';
        }
        $data .='</ul>';
        echo(trim($data));
    }else{
        echo json_encode("No Data Found");
    }
}
function getBikeByRatePerHr($rph){
    $query = "select * from `main_database`.`bike` where rate_per_hr BETWEEN 0 and $rph ORDER BY rate_per_hr ASC";
    $result = mysql_query($query);
    $arrayData = array();
    if($result){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
    }else{
        echo json_encode("No Data Found");
    }

}
function getAllOwner(){
    $query = "select * from `main_database`.`bike_owner`";
    $result = mysql_query($query);
    $arrayData = array();
    if($result){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
    }else{
        echo json_encode("No Data Found");
    }

}
function getOwnerById($ownerId){

    $query = "select * from `main_database`.`bike_owner` where id='$ownerId'";
    $result = mysql_query($query);
    $arrayData = array();
    if($result){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
    }else{
        echo json_encode("No Data Found");
    }
}

function addUser($userData){

    $query = "INSERT INTO `main_database`.`user` (`id`, `name`, `address`, `mobile`,`email`,`username`,`password`,`doc_submitted`,`bookingId`,`orderId`) VALUES (NULL, '$userData->name', '$userData->address','$userData->mobile','$userData->email','$userData->username','$userData->password','$userData->doc_submitted','$userData->bookingId',NULL);";
    $result = mysql_query($query);
    if($result){
        $response = array("status" => "1","msg" => "Success");
    }else{
        $response = array("status" => "0","msg" => "Failed");
    }
    echo json_encode($response);
}

function updateUser($userData){
    $query = "select * from `main_database`.`user` where id='$userData->id'";
    $result = mysql_query($query);
    $queryData = mysql_fetch_object($result);
    if($queryData){
        $query = "update `main_database`.`user` set name='$userData->name',address ='$userData->address',mobile='$userData->mobile',email = '$userData->email',username='$userData->username',password = '$userData->password',doc_submitted = '$userData->doc_submitted',bookingId ='$userData->bookingId' where id ='$userData->id';";
        //print_r($query);die;
        $result = mysql_query($query);
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    }else{
        echo json_encode("No Such User Exist");
    }
}

function deleteUser($userId){
    $query = "select * from `main_database`.`user` where id='$userId'";
    $result = mysql_query($query);
    if (mysql_fetch_object($result)) {
        $query = "DELETE FROM `main_database`.`user` WHERE id='$userId'";
        $result = mysql_query($query) or die("Query failed : " . mysql_error());
        if($result){
            $response = array("status" => "1","msg" => "Success");
        }else{
            $response = array("status" => "0","msg" => "Failed");
        }
        echo json_encode($response);
    } else {
        echo  json_encode("ERROR! No Such User Exists");

    }
}