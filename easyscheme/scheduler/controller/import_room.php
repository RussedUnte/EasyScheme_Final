<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();


// Get the raw POST data (assumed to be JSON)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['data']) && is_array($data['data'])) {
 
    foreach ($data['data'] as $key => $value) {

        if($key==0)
        {
            continue;
        }

        if (!empty($value)) {
            $dataz = array();
            $dataz = array(
                'room_number'=>$value,
                'status' => 0,       
            );
            $room_id = $db->getIdByColumnValue('room','room_number',$value,'id');

            if($room_id!="")
            {
                // if already in the database
                $whereClause = [
                    'id' => $room_id
                ];
                $db->updateData('room',$dataz,$whereClause);

            }else{
                $db->insertData('room',$dataz);

            }


        }
    }


    // Send a JSON response
    echo json_encode(["message" => "Data saved successfully"]);
} else {
    echo json_encode(["message" => "Invalid data format"]);
}