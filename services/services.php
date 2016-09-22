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
            checkBooking($myPostData->bookingDetails);
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
    }else if(isset($myPostData->loginDetails)){
        loginUser($myPostData->loginDetails);
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
    }elseif(isset($_GET['getuserbyid'])){
        getUserById($_GET['getuserbyid']);
    }elseif(isset($_GET['startdate']) && isset($_GET['enddate'])){
        checkBikeAailability($_GET['startdate'],$_GET['enddate'],$_GET['starttime']);
    }elseif(isset($_GET['id']) && isset($_GET['email'])){
        forgetPassword($_GET['id'],$_GET['email']);
    }
}
mysql_close($connection);
?>
<?php
function loginUser($loginData){
    $query = "select * from user where (username = '$loginData->username' OR email ='$loginData->username') AND password = '$loginData->password';";
    $result = mysql_query($query);
    $userId = mysql_fetch_row($result)[0];
    if(!$userId == NULL){
        $response = array("msg" => "Success","userId" =>$userId );
    }else{
        $response = array("msg" => "Failed");
    }
    echo json_encode($response);
}
function addOwners($ownerData){
    $query = "INSERT INTO `main_database`.`bike_owner`  (`id`, `name`, `address`, `email`, `mob`, `offc_address`) VALUES (NULL, '$ownerData->name', '$ownerData->address','$ownerData->email','$ownerData->mob','$ownerData->offcadd');";
    $result = mysql_query($query);
    if(mysql_affected_rows() > 0){
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
function checkBooking($bookingData){
    $query = "select * from `main_database`.`booking` where bikeid = '$bookingData->bikeid';";
    $result = mysql_query($query);
    $flag = false;
    $arrayData = array();
    if(mysql_num_rows($result)>0){
        while($data = mysql_fetch_assoc($result)) {
            array_push($arrayData,$data);
        }
        foreach($arrayData as $queryData){
            if ((strtotime($bookingData->startdate) > strtotime($queryData['startdate'])) && (strtotime($bookingData->startdate) > strtotime($queryData['enddate']))) {
                $flag = true;
            } else {
                if (strtotime($bookingData->startdate) == strtotime($queryData['enddate'])) {
                    if ((strtotime($bookingData->starttime) > strtotime($queryData['endtime']))) {
                        $flag = true;
                    }
                }
            }
        }
    }else{
        $flag = true;
    }
    if($flag){
        addBooking($bookingData);
    }else{
        $response = array("status" => "0", "msg" => "Failed,Bike Is Already Booked");
        echo json_encode($response);
    }
}
function addBooking($bookingData){
    $query = "INSERT INTO `main_database`.`booking`  (`id`, `startdate`, `starttime`, `enddate`, `endtime`, `bikeid`,`userId`) VALUES (NULL, '$bookingData->startdate', '$bookingData->starttime','$bookingData->enddate','$bookingData->endtime','$bookingData->bikeid','$bookingData->userId');";
    $result = mysql_query($query);
    if(mysql_affected_rows()> 0){
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
        $query = "update `main_database`.`booking` set startdate='$bookingData->startdate',starttime ='$bookingData->starttime',enddate='$bookingData->enddate',endtime='$bookingData->endtime',bikeid='$bookingData->bikeid',userId='$bookingData->userId' where id='$bookingData->id'";
        $result = mysql_query($query);
        if(mysql_affected_rows() > 0){
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
    //AppUtility_dump($bikeData);
    $query = "INSERT INTO `main_database`.`bike` (`id`, `name`, `description`, `number_plate`, `image`, `chasisnumber`, `rate_per_hr`, `bike_owner_id`,`location`) VALUES (NULL, '$bikeData->name', '$bikeData->description','$bikeData->number_plate','$bikeData->image','$bikeData->chasisnumber','$bikeData->rate_per_hr',$bikeData->bike_owner_id,'$bikeData->location');";
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
        $query = "update `main_database`.`bike` set name='$bikeData->name',descrip0tion ='$bikeData->description',number_plate='$bikeData->number_plate',image='$bikeData->image',chasisnumber='$bikeData->chasisnumber',rate_per_hr='$bikeData->rate_per_hr',bike_owner_id='$bikeData->bike_owner_id',location = '$bikeData->location' where id='$bikeData->id'";
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
    $query = "INSERT INTO `main_database`.`order_details` (`id`, `bookingid`, `totalfare`, `date`,`userId`) VALUES (NULL, '$orderData->bookingid', '$orderData->totalfare','$orderData->date',$orderData->userId);";
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
        $query = "update `main_database`.`order_details` set bookingid='$orderData->bookingid',totalfare ='$orderData->totalfare',date='$orderData->date',userId = '$orderData->userId' where id='$orderData->id'";
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
    if(mysql_num_rows($result) > 0){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
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

    $query = "INSERT INTO `main_database`.`user` (`id`, `name`, `address`, `mobile`,`email`,`username`,`password`,`doc_submitted`) VALUES (NULL, '$userData->name', '$userData->address','$userData->mobile','$userData->email','$userData->username','$userData->password','$userData->doc_submitted');";
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
        $query = "update `main_database`.`user` set name='$userData->name',address ='$userData->address',mobile='$userData->mobile',email = '$userData->email',username='$userData->username',password = '$userData->password',doc_submitted = '$userData->doc_submitted' where id ='$userData->id';";
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
function getUserById($userId){

    $query = "select * from `main_database`.`user` where id='$userId'";
    $result = mysql_query($query);
    $arrayData = array();
    if(mysql_num_rows($result) >0 ){
        while($row = mysql_fetch_assoc($result)){
            array_push($arrayData,$row);
        }
        echo json_encode($arrayData);
    }else{
        echo json_encode("No Data Found");
    }
}
function checkBikeAailability($startDate,$endDate,$startTime){
    $query = "select * from `main_database`.`bike`";
    $result = mysql_query($query);
    $bikeData = array();
    $availableBikes = array();
    while($data = mysql_fetch_assoc($result)){

        array_push($bikeData,$data);
    }

    foreach($bikeData as $singleBike){
        $bikeId = $singleBike['id'];
        $q = "select * from booking where bikeid ='$bikeId'";
        $result = mysql_query($q);
        $bookingData = array();
        while($data = mysql_fetch_assoc($result)){

            array_push($bookingData,$data);
        }
        if(mysql_num_rows($result)>0){
            foreach($bookingData as $queryData){
                if ((strtotime($startDate) > strtotime($queryData['startdate'])) && (strtotime($startDate) > strtotime($queryData['enddate']))) {
                    array_push($availableBikes,$singleBike);

                } else {
                    if (strtotime($startDate) == strtotime($queryData['enddate'])) {
                        if ((strtotime($startTime) > strtotime($queryData['endtime']))) {
                            array_push($availableBikes,$singleBike);
                        }else{

                            $key = array_search($singleBike, $availableBikes);
                            unset($availableBikes[$key]);
                        }
                    }
                }
            }
        }else{
            array_push($availableBikes,$singleBike);
        }
    }
    if($availableBikes){
        echo json_encode($availableBikes);
    }else{
        $response = array("status" => "0", "msg" => "No Bike Available");
        echo json_encode($response);
    }
}
function forgetPassword($userId,$email){

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    /*$mail->SMTPDebug = 2;*/
    $mail->SMTPAuth = true;
    $mail->Username = 'rohankawade222@gmail.com';
    $mail->Password = 'sunshine222tw';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->From = 'rohankawade222@gmail.com';
    $mail->FromName = 'Bikes On Rent';
    $query = "select * from `main_database`.`user` where id='$userId' AND email = '$email' ";
    $result = mysql_query($query);
    $userData = array();
    while($data = mysql_fetch_assoc($result)){
        array_push($userData,$data);
    }
    if($userData[0]['email'] == $email){
        $password = randomTokenGenerater();
        $query ="update `main_database`.`user` set password = '$password' where id='$userId'";
        $result = mysql_query($query);
        if(mysql_affected_rows()>0){
            $userName = $userData[0]['name'];
            $mail->addAddress($userData[0]['email']);
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            $mail->isHTML(true);
            $mail->Subject = 'Change Account Password';
            $mail->Body = "Hi <b>$userName</b>";
            $mail->Body .= "<br /><br />Below is your one time password <br /> Password: ";
            $mail->Body .= $password;
            $mail->Body .= "<br /> Kindly note that this passowrd is valid for specific time limit,Use it to set a new password";
            $mail->Body .= "<br/><br /> <b>If you think this mail was sent incorrectly, please contact administrator immediately</b>";
            $mail->AltBody = 'You are using basic web browser ';
            if(!$mail->send()) {
                $response = array("status" => "0","msg" => "Cannot send Mail, Please try after some time.$mail->ErrorInfo");
            } else {
                $response = array("status" => "1","msg" => "Mail Sent");
            }
        }else{
            $response = array("status" => "0","msg" => "Cannot send Mail, Please try after some time.$mail->ErrorInfo");
        }
    }else{
        $response = array("status" => "0","msg" => "Wrong Email-id");

    }
    echo json_encode($response);
}
function randomTokenGenerater(){
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    $max = strlen($characters) - 1;
    for ($i = 0; $i < 8; $i++) {
        $string .= $characters[mt_rand(0, $max)];
    }
    return $string;
}


