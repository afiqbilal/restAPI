<?php
// headers
header("Access-Control-Allow-Origin: http://localhost/restAPI/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// connect to database
include_once 'config/database.php';
include_once 'objects/user.php';
 
// database connection
$database = new Database();
$db = $database->getConnection();
 
// instantiate object
$user = new User($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set values
$user->name = $data->name;
$user->password = $data->password;
$user->email = $data->email;
$data = array(
           "name" => $user->name,
           "email" => $user->email
       );
// create the user
if($user->create()){
 
    // set response code
    http_response_code(200);
 
    // display message: user was created
    echo json_encode(array("status"=>"true","message" => "Registration completed successfully","data"=>$data));
}
 
// message if unable to create user
else{
 
    // set response code
    http_response_code(400);
 
    // display message: unable to create user
    echo json_encode(array("message" => "Unable to create user."));
}
?>
