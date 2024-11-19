<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Get the raw POST data (assumed to be JSON)
$json = file_get_contents('php://input');
$data = json_decode($json, true);
// CHECK PROGRAM NAME

// var_dump($data);
if (isset($data['data']) && is_array($data['data'])) {
 
    foreach ($data['data'] as $key => $value) {

        if($key==0)
        {
            continue;
        }
        else 
        {
            if (!isset($data['data'][$key][0]) || !isset($data['data'][$key][1] )|| !isset($data['data'][$key][2] )) {
                continue; 
            }
            
            $program_name = trim($data['data'][$key][0]);  // Get student name
            $section_name = trim($data['data'][$key][1]); // Get student number
            $year_level = trim($data['data'][$key][2]); // Get student number
            

            $program_id = $db->getIdByColumnValue('program_details','program_name',$program_name,'id');

            if($program_name == "" || $section_name == "" || $year_level == "" || $program_id == "" )
            {
                continue;
            }
            else 
            {
                // echo 'program_id : ' .$program_id;
                // echo $program_name;
                // echo $section_name;
                // echo $year_level;

                $section_id = $db->getIdByColumnValue('section','section',$section_name,'id');
                // checking if section is in table
                $section_data = [
                    'year_level' => $year_level,
                    'program_id' => $program_id,
                    'section' => $section_name,
                    'status' => 0,
                ];


                if($section_id!="")
                {
                    // if already in the database
                    $whereClause = [
                        'section' => $section_name,
                        'id' => $section_id
                    ];
                    $db->updateData('section',$section_data,$whereClause);

                }else 
                {
                    // if not in the database
                    $db->insertData2('section',$section_data);
                }

            }

        }
    }
    // Send a JSON response
    echo json_encode(["message" => "Data saved successfully"]);
} else {
    echo json_encode(["message" => "Invalid data format"]);
}