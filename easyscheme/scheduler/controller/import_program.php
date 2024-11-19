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
        else 
        {
            if (!isset($data['data'][$key][0]) || !isset($data['data'][$key][1]) ) {
                
                continue; 
            }
            
            $program_name = trim($data['data'][$key][0]);  // Get student name
            $institute_name = trim($data['data'][$key][1]); // Get student number
            

            $institute_id = $db->getIdByColumnValueLike('institutes','name',$institute_name,'id')[0] ?? "";

            if($program_name == "" || $institute_name == "" || $institute_id == "" )
            {
                continue;
            }
            else 
            {
                $dataz = array();
                $dataz = array(
                    'program_name' => $program_name,
                    'institute' => $institute_id,       
                    'status' => 0,       
                );
                $program_id = $db->getIdByColumnValue('program_details','program_name',$program_name,'id');

                if($program_id!="")
                {
                    // if already in the database
                    $whereClause = [
                        'id' => $program_id
                    ];
                    $db->updateData('program_details',$dataz,$whereClause);

                }else{
                    $db->insertData2('program_details',$dataz);
                }
          
            }

        }
    }
    // Send a JSON response
    echo json_encode(["message" => "Data saved successfully"]);
} else {
    echo json_encode(["message" => "Invalid data format"]);
}