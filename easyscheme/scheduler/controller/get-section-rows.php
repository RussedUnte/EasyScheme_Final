<?php 
    require '../../conn/conn.php';
    $db = new DatabaseHandler();

    $rows = $db->getAllSections($_POST['id']);

    if(count($rows)>0)
    {
        foreach ($rows as $row) {
            $id = ucwords($row['id']);
            $section = ucwords($row['section']);
            $year_level = ucwords($row['year_level']);
            $section_course_id = ucwords($row['section_course_id']);
            
             //for datas
             $data_section = "
             data-id = '$id' 
             data-section_course_id = '$section_course_id' 
             data-section = '$section' 
             data-year_level = '$year_level' 
             ";

            echo '<tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$year_level.'</td>
                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700">'.$section.'</td>
                    <td class="py-3 px-6 border-b border-gray-300 text-gray-700 ">
                        <i '.$data_section.' class="btnSectionEdit material-icons cursor-pointer hover:opacity-75 rounded-lg bg-green-600 text-white text-sm px-1 py-0">edit</i>
                        <i '.$data_section.' class="btnSectionDelete material-icons cursor-pointer hover:opacity-75 rounded-lg bg-red-600 text-white text-sm px-1 py-0">delete</i>
                    </td>
                </tr>';
        }
    }else{
        echo '<tr class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
        <td colspan = 4 class="py-3 px-6 border-b border-gray-300 text-gray-700">No data found.</td>
    </tr>';
    }
?>

