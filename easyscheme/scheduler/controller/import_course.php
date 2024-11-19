<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Get the raw POST data (assumed to be JSON)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['data']) && is_array($data['data'])) {
 
    // var_dump($data);
    foreach ($data['data'] as $value) {
        
    }

    foreach ($data['data'] as $key => $value) {

        if($key==0)
        {
            continue;
        }
        else 
        {
            if (!isset($data['data'][$key][0]) || 
                !isset($data['data'][$key][1]) || 
                !isset($data['data'][$key][2]) || 
                !isset($data['data'][$key][3])
                ) {
                
                continue; 
            }
            
            $code = trim($data['data'][$key][0]);  // Get student name
            $program_name = trim($data['data'][$key][1]); // Get student number
            $title = trim($data['data'][$key][2]);   // Get section name
            $designation = trim($data['data'][$key][3]);   // Get section name
            
            $program_id = $db->getIdByColumnValue('program_details','program_name',$program_name,'id');

            if($code == "" || 
               $program_name == "" ||
               $title == "" || 
               $designation == "" || 
               $program_id == "" )
                {
                    continue;
                }
            else 
            {
                $dataz = array();
                $dataz = array(
                    'title' => $title,
                    'program' => $program_id,            
                    'code' => $code,       
                    'designation' => $designation,       
                );
                $db->insertData2('course',$dataz);
            }

        }
    }
    // Send a JSON response
    echo json_encode(["message" => "Data saved successfully"]);
} else {
    echo json_encode(["message" => "Invalid data format"]);
}