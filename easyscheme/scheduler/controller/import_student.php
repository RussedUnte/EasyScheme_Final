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
            if (!isset($data['data'][$key][0]) || !isset($data['data'][$key][1]) || !isset($data['data'][$key][2])) {
                
                continue; 
            }
            
            $student_name = trim($data['data'][$key][0]);  // Get student name
            $student_number = trim($data['data'][$key][1]); // Get student number
            $section_name = trim($data['data'][$key][2]);   // Get section name
            
            $section_id = $db->getIdByColumnValue('section','section',$section_name,'id');

            $section_program_id = $db->getIdByColumnValue('section','id',$section_id,'program_id');

            $institute_id = $db->getIdByColumnValue('program_details','id',$section_program_id,'institute');

            if($student_name == "" || $section_id == "" || $section_program_id == "" || $institute_id == "")
            {
                continue;
            }
            else 
            {
                $dataz = array();
                $dataz = array(
                    'name' => $student_name,
                    'student_number' => $student_number,            
                    'institute' => $institute_id,       
                    'section' => $section_id,       
                );

                $db->insertData2('student_details',$dataz);
          
            }

        }
    }
    // Send a JSON response
    echo json_encode(["message" => "Data saved successfully"]);
} else {
    echo json_encode(["message" => "Invalid data format"]);
}