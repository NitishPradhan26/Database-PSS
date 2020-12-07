<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/fundraisers.php';

$database = new Database();
$db = $database->getConnection();



$fundraiser = new Fundraiser($db);

$stmt = $fundraiser->read();
$num = $stmt->rowCount();

if($num>0){
    $fundraisers_arr=array();
    $fundraisers_arr["records"]=array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
  
        $fundraiser_single=array(
            "Name" => $Name,
            "Transaction_no" => $Transaction_no,
        );
  
        array_push($fundraisers_arr["records"], $fundraiser_single);
    }

	http_response_code(200);

	echo json_encode($fundraisers_arr);
}
else {
	http_response_code(404);

    echo json_encode(
        array("message" => "No fundraisers found.")
    );
}


?>