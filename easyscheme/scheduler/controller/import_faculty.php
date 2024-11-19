<?php 
require '../../conn/conn.php';
$db = new DatabaseHandler();

// Get the raw POST data (assumed to be JSON)
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (isset($data['data']) && is_array($data['data'])) {
 
    // var_dump($data);
    foreach ($data['data'] as $key => $value) {

        if($key==0)
        {
            continue;
        }
        else 
        {
            if (
                !isset($data['data'][$key][0]) || 
                !isset($data['data'][$key][1]) || 
                !isset($data['data'][$key][2]) || 
                !isset($data['data'][$key][3]) || 
                !isset($data['data'][$key][4]) || 
                !isset($data['data'][$key][5]) || 
                !isset($data['data'][$key][6]) || 
                !isset($data['data'][$key][7]) || 
                !isset($data['data'][$key][8]) || 
                !isset($data['data'][$key][9]) || 
                !isset($data['data'][$key][10])
                ) {
                continue; 
            }
            
            $salutation = trim($data['data'][$key][0]);  
            $faculty_name = trim($data['data'][$key][1]); 
            $status = trim($data['data'][$key][2]); 
            $institute_name = trim(str_replace('"', '', $data['data'][$key][3])); 
            $monday = trim($data['data'][$key][4]);
            $tuesday = trim($data['data'][$key][5]);
            $wednesday = trim($data['data'][$key][6]);
            $thursday = trim($data['data'][$key][7]);
            $friday = trim($data['data'][$key][8]);
            $saturday = trim($data['data'][$key][9]);
            $sunday = trim($data['data'][$key][10]);
            
            $institute_id = $db->getIdByColumnValueLike('institutes','name',$institute_name,'id');

            if(isset($institute_id)){
                $institute_id = $institute_id[0];
            }


            $user_id = "";
            if($salutation == "" || 
               $faculty_name == "" ||
               $status == "" ||
               $institute_id == "" ||
               $monday == "" || 
               $tuesday == "" || 
               $wednesday == "" || 
               $thursday == "" || 
               $friday == "" || 
               $saturday == "" || 
               $sunday == "" )
                {
                // echo $salutation.'<br>';
                // echo $faculty_name.'<br>';
                // echo $status.'<br>';
                // echo $institute_id.'<br>';
                // echo $monday.'<br>';
                // echo $tuesday.'<br>';
                // echo $wednesday.'<br>';
                // echo $thursday.'<br>';
                // echo $friday.'<br>';
                // echo $saturday.'<br>';
                // echo $sunday.'<br>';
                // echo $institute_name ;

                    continue;
                }
            else 
            {
                
                $password = str_replace(' ', '', $faculty_name);
                $username = str_replace(' ', '', $faculty_name);

                $user_id = $db->getIdByColumnValue('user','username',$username,'id');

                if( $user_id == "" )
                {

                    $data_user = array();
                    $data_user = array(
                        'name' => $faculty_name,
                        'username' => $username,            
                        'password' => password_hash($password, PASSWORD_DEFAULT),       
                        'position' => 'faculty',       
                    );
    
                    if($db->insertData2('user',$data_user))
                    {
                       $user_id =  $db->getLastInsertId();
    
                       $data_Details = array();
    
                       $data_Details = array(
                           'user_id' => $user_id,
                           'salutation' => $salutation,            
                           'status' => $status,       
                           'institute' => $institute_id       
                       );
    
                       $db->insertData2('user_details',$data_Details);
                    }
                }
                
                 
                {

                    $formatted_monday="";
                    $formatted_tuesday="";
                    $formatted_wednesday="";
                    $formatted_thursday="";
                    $formatted_friday="";
                    $formatted_saturday="";
                    $formatted_sunday="";

                    $formatted_monday = timeRange($monday);  
                    $formatted_tuesday = timeRange($tuesday);  
                    $formatted_wednesday = timeRange($wednesday);  
                    $formatted_thursday = timeRange($thursday);  
                    $formatted_friday = timeRange($friday);  
                    $formatted_saturday = timeRange($saturday);  
                    $formatted_sunday = timeRange($sunday);  
                    
                    if(

                        $formatted_monday == 'Invalid format' || 
                        $formatted_tuesday == 'Invalid format' || 
                        $formatted_wednesday == 'Invalid format' || 
                        $formatted_thursday == 'Invalid format' || 
                        $formatted_friday == 'Invalid format' || 
                        $formatted_saturday == 'Invalid format' ||
                        $formatted_sunday == 'Invalid format' 
                    )
                    {
                        echo 1;
                        continue;
                    }


                    
                    $prof_schedule_array = array();

                    $prof_schedule_array = array(
                        'user_id' => $user_id,
                        'monday' => $formatted_monday,
                        'tuesday' => $formatted_tuesday,
                        'wednesday' => $formatted_wednesday,
                        'thursday' => $formatted_thursday,
                        'friday' => $formatted_friday,
                        'saturday' => $formatted_saturday,
                        'sunday' => $formatted_sunday,
                    );
                    $checker="";
                    $checker = $db->getIdByColumnValue('prof_schedule','user_id',$user_id,'id');
                    if($checker=="")
                    {
                        $db->insertData2('prof_schedule',$prof_schedule_array);
                    }else{
                        $whereClause = array(
                            'user_id' => $user_id,
                        );
                        $db->updateData('prof_schedule',$prof_schedule_array,$whereClause);
                    }
                    
                }


            }
        }
    }
    // Send a JSON response
    echo json_encode(["message" => "Data saved successfully"]);
} else {
    echo json_encode(["message" => "Invalid data format"]);
}

function timeRange($time_range) {
    // Trim the input to remove any leading/trailing spaces
    $time_range = trim($time_range);

    // Check if the input is 'not available' (case-insensitive)
    if (strtolower($time_range) == 'not available') {
        return 'not available';
    }

    // Split the input string by the dash (-)
    $times = explode('-', $time_range);

    // Check if the split resulted in exactly two parts (start and end times)
    if (count($times) !== 2) {
        return "Invalid format";
    }

    // Trim spaces from both start and end times
    $start_time = trim($times[0]);
    $end_time = trim($times[1]);

    // Define a regular expression pattern for individual time in 12-hour format with AM/PM
    $time_pattern = '/^\s*(0?[1-9]|1[0-2]):[0-5][0-9]\s*(AM|PM|am|pm)?\s*$/i';

    // Validate the start time format
    if (!preg_match($time_pattern, $start_time)) {
        return "Invalid start time format";
    }

    // Validate the end time format
    if (!preg_match($time_pattern, $end_time)) {
        return "Invalid end time format";
    }

    // Ensure AM/PM is uppercase
    $start_time = strtoupper($start_time);
    $end_time = strtoupper($end_time);

    // Return the time range in the required format
    return $start_time . ' - ' . $end_time;
}


