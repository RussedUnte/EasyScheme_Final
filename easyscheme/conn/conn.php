<?php
session_start();
date_default_timezone_set('Asia/Manila'); 
include 'env.php';
class DatabaseHandler {

    private $pdo;

    public function __construct() {
        // Set your database connection parameters here
        $dbHost = 'localhost';
        $dbPort = '3306';
        $dbName = DBNAME;
        $dbUser = DBUSER;
        $dbPassword = DBPASSWORD;


        try {
            $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
            $this->pdo = new PDO($dsn, $dbUser, $dbPassword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Handle connection errors
            echo "Connection failed: " . $e->getMessage();
        }
    }
    

    public function getAllRowsFromTable($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE status = 0");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function deleteData($table, $where_conditions) {
        // Build the DELETE SQL query
        $sql = "DELETE FROM " . $table . " WHERE ";
        $conditions = [];
        $params = [];

        // Prepare conditions
        foreach ($where_conditions as $column => $value) {
            $conditions[] = $column . " = :$column"; // Use named placeholders
            $params[":$column"] = $value; // Bind the value
        }

        // Combine conditions
        $sql .= implode(" AND ", $conditions);

        // Prepare and execute the statement
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params); // Return true or false based on success
    }



    public function getAllFaculty($institute) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT b.*, a.name,a.id as user_id
                FROM `user` as a 
                JOIN user_details as b
                ON a.id = b.user_id
                WHERE a.position = 'faculty' 
                  AND a.status = 0 
                  AND b.institute = :institute
            ");
            $stmt->bindParam(':institute', $institute, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllStudents($institute) {
        try {
            $stmt = $this->pdo->prepare("
             SELECT a.*,b.section as section_title,b.year_level,b.program_id
                FROM `student_details` as a 
                JOIN section as b ON a.section = b.id
                #JOIN course as c ON b.program_id = c.program
                #JOIN institutes as d ON a.institute = d.id
                #JOIN program_details as e ON c.program = e.id
                WHERE a.status = 0 
                AND a.institute = :institute 
                GROUP BY a.student_number
            ");
            $stmt->bindParam(':institute', $institute, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllRoom() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM room
                WHERE status = 0 
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllProgram() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.*,b.name FROM `program_details` as a 
                JOIN institutes as b 
                ON a.institute = b.id
                WHERE a.status = 0 AND b.status = 0
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllCourse() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.*,b.institute,b.program_name FROM course as a 
                JOIN program_details as b 
                ON a.program = b.id
                WHERE a.status = 0 AND b.status = 0
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllSections($course) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.*,b.id as section_course_id FROM section as a 
                JOIN section_course as b 
                ON a.id = b.section_id
                WHERE a.status = 0 AND b.status = 0 AND b.course_id = '$course'
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getSchedules() {
        try {
            $stmt = $this->pdo->prepare("
                SELECT a.*,b.program_name,b.id as program_id FROM `schedule` as a 
                JOIN program_details as b 
                ON a.program = b.id AND a.institute = b.institute
                WHERE a.status = 0 AND b.status = 0 
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    public function getScheduleFaculty($proctor_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM `schedule` as a 
                JOIN schedule_details as b 
                ON a.id = b.schedule_id
                WHERE a.status = 0 AND b.status = 0 AND b.proctor_id = :proctor_id
            ");
            $stmt->bindParam(':proctor_id', $proctor_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    

    public function getSectionCourse($section_id) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT b.* FROM section_course as a 
                JOIN course as b 
                ON a.course_id = b.id
                WHERE a.section_id = $section_id AND a.status = 0 AND b.status = 0
            ");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    
    
    

    public function getAllRowsFromTableWhere($tableName, array $additionalConditions = []) {
        try {
            // Construct the WHERE clause with status = 0 and additional conditions
            $whereClause = "status = 0";
    
            if (!empty($additionalConditions)) {
                $whereClause .= " AND " . implode(' AND ', $additionalConditions);
            }
    
            // Prepare the SQL statement with the dynamic WHERE clause
            $sql = "SELECT * FROM $tableName WHERE $whereClause";
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }

    public function getAllRowsFromTableWhereOrderBy($tableName, array $additionalConditions = [], $orderBy = null): array {
        try {
            // Start building the WHERE clause, default is status = 0
            $whereClause = "status = 0";
    
            // Prepare an array for the values to bind for the additional conditions
            $values = [];
    
            // Add additional conditions if provided
            if (!empty($additionalConditions)) {
                foreach ($additionalConditions as $column => $value) {
                    $whereClause .= " AND $column = :$column";
                    $values[$column] = $value;  // Bind each value
                }
            }
    
            // Prepare the base SQL query
            $sql = "SELECT * FROM $tableName WHERE $whereClause";
    
            // Append ORDER BY clause if specified
            if ($orderBy) {
                $sql .= " ORDER BY $orderBy";
            }
    
            // Prepare the SQL statement
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the statement with bound values
            $stmt->execute($values);
    
            // Fetch all results as an associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Handle any errors
            echo "Query failed: " . $e->getMessage();
            return [];
        }
    }
    public function getAllRowsFromTableWhereGroup($tableName, array $additionalConditions = [], $groupBy = null) {
        try {
            // Construct the WHERE clause with status = 0 and additional conditions
            $whereClause = "status = 0";
    
            if (!empty($additionalConditions)) {
                $whereClause .= " AND " . implode(' AND ', $additionalConditions);
            }
    
            // Construct the GROUP BY clause if $groupBy is provided
            $groupByClause = "";
            if (!empty($groupBy)) {
                $groupByClause = " GROUP BY " . $groupBy;
            }
    
            // Prepare the SQL statement with the dynamic WHERE and GROUP BY clauses
            $sql = "SELECT * FROM $tableName WHERE $whereClause $groupByClause";
            $stmt = $this->pdo->prepare($sql);
    
            // Execute the query
            $stmt->execute();
    
            // Fetch the results as an associative array
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Handle query errors
            echo "Query failed: " . $e->getMessage();
        }
    }
    
    
    public function loginUser($username, $password) {
        try {
            // Sanitize and validate input
            $username = trim($username); // Trim whitespace
            // htmlentities is not needed here because parameter binding takes care of SQL injection risks
    
            // Prepare the SQL statement
            $stmt = $this->pdo->prepare("SELECT * FROM user WHERE username = :username AND status = 0");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
    
            // Fetch the user
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user) {
                // Use password_verify to check the hashed password
                if (password_verify($password, $user['password'])) {
                    // Set session variables securely
                    $_SESSION['position'] = $user['position'];
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
    
                    // Regenerate session ID to prevent session fixation
                    session_regenerate_id(true);
    
                    return true; // Login successful
                }
            }
    
            return false; // Login failed
    
        } catch (PDOException $e) {
            // Log the error message internally
            error_log("Login query failed: " . $e->getMessage());
    
            // Return a generic error message
            return false;
        }
    }
    
    public function hardDelete($schedule_id, $section_id) {
        try {
            // Prepare the SQL statement with placeholders
            $sql = "DELETE FROM schedule_details WHERE `schedule_id` = :schedule_id AND `section_id` = :section_id";
            $stmt = $this->pdo->prepare($sql);
    
            // Bind parameters to the placeholders
            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
            $stmt->bindParam(':section_id', $section_id, PDO::PARAM_INT);
    
            // Execute the statement
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log it or display an error message)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function hardDeleteExamLink($exam_id) {
        try {
            // Prepare the SQL statement with placeholders
            $sql = "DELETE FROM exam_links WHERE `id` = :exam_id ";
            $stmt = $this->pdo->prepare($sql);
    
            // Bind parameters to the placeholders
            $stmt->bindParam(':exam_id', $exam_id, PDO::PARAM_INT);
            // Execute the statement
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log it or display an error message)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function hardDeleteScheduleDetails($schedule_id) {
        try {
            // Prepare the SQL statement with placeholders
            $sql = "DELETE FROM schedule_details WHERE `schedule_id` = :schedule_id ";
            $stmt = $this->pdo->prepare($sql);
    
            // Bind parameters to the placeholders
            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
            // Execute the statement
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log it or display an error message)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function hardDeleteSchedule($id) {
        try {
            // Prepare the SQL statement with placeholders
            $sql = "DELETE FROM schedule WHERE `id` = :id ";
            $stmt = $this->pdo->prepare($sql);
    
            // Bind parameters to the placeholders
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // Execute the statement
            $stmt->execute();
    
            return true;
        } catch (PDOException $e) {
            // Handle the exception (e.g., log it or display an error message)
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    
    public function insertData($tableName, $data) {
        try {
            foreach ($data as $key => $value) {
                $data[$key] = trim(htmlentities($value));
            }

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo $e;
        }
    }

    public function insertData2($tableName, $data) {
        try {
            foreach ($data as $key => $value) {
                $data[$key] = trim(htmlentities($value));
            }

            $columns = implode(', ', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);
            
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function getLastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function updateData($tableName, $data, $whereConditions) {
        try {
            $setClause = '';
            foreach ($data as $key => $value) {
                $setClause .= "$key = :$key, ";
            }
            // Remove the trailing comma and space from the setClause
            $setClause = rtrim($setClause, ', ');
    
            $whereClause = '';
            foreach ($whereConditions as $whereKey => $whereValue) {
                $whereClause .= "$whereKey = :where_$whereKey AND ";
            }
            // Remove the trailing "AND" from the whereClause
            $whereClause = rtrim($whereClause, ' AND ');
    
            $sql = "UPDATE $tableName SET $setClause WHERE $whereClause";
            $stmt = $this->pdo->prepare($sql);
    
            foreach ($data as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
    
            foreach ($whereConditions as $whereKey => $whereValue) {
                $stmt->bindValue(':where_' . $whereKey, $whereValue);
            }
    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
            // You can log or handle the error here.
        }
    }
    
    
    
    public function getIdByColumnValue($tableName, $columnName, $columnValue, $idColumnName) {
    // Example usage 
    // $image =($db->getIdByColumnValue('tableName', 'id',$_GET['post'],'image')
        try {
            $stmt = $this->pdo->prepare("SELECT $idColumnName FROM $tableName WHERE $columnName = :column_value");
            $stmt->bindParam(':column_value', $columnValue);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result[$idColumnName];
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // echo "Error retrieving ID: " . $e->getMessage();
            return null;
        }
    }

    public function getIdByColumnValueLike($tableName, $columnName, $columnValue, $idColumnName) {
        try {
            // Validate and sanitize table/column names to prevent SQL injection
            $validTables = ['institutes', 'users', 'posts']; // Example list of allowed tables
            $validColumns = ['id', 'name', 'description'];  // Example list of allowed columns
            
            if (!in_array($tableName, $validTables) || !in_array($columnName, $validColumns) || !in_array($idColumnName, $validColumns)) {
                throw new InvalidArgumentException("Invalid table or column name");
            }
    
            // Prepare the query using LIKE
            $stmt = $this->pdo->prepare("SELECT $idColumnName FROM $tableName WHERE $columnName LIKE :column_value");
    
            // Add wildcard characters for the LIKE operator
            $likeValue = "%" . $columnValue . "%";
            $stmt->bindParam(':column_value', $likeValue);
    
            // Echo the raw SQL query with placeholder
            // echo "SQL Query: SELECT $idColumnName FROM $tableName WHERE $columnName LIKE '%" . $columnValue . "%'<br>";
    
            // Execute the query
            $stmt->execute();
    
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if ($result) {
                $ids = array_column($result, $idColumnName);
                return $ids;
            } else {
                return null; // No entry found
            }
        } catch (PDOException $e) {
            return null;
        } catch (InvalidArgumentException $e) {
            return null;
        }
    }
    
    

    public function getschedule_detail_column($requested_column, $section_id, $course_id, $schedule_id) {
        try {
            // Validate column name to avoid SQL injection
            $allowed_columns = ['schedule_id','section_id','date', 'time_start', 'time_end', 'room_id', 'proctor_id']; // Define allowed column names
            if (!in_array($requested_column, $allowed_columns)) {
                throw new InvalidArgumentException('Invalid column name');
            }
    
            // Prepare the SQL statement with placeholders for parameters
            $stmt = $this->pdo->prepare("SELECT $requested_column FROM schedule_details 
                WHERE section_id = :section_id AND course_id = :course_id AND schedule_id = :schedule_id AND status = 0");
     
            // Bind parameters
            $stmt->bindParam(':section_id', $section_id, PDO::PARAM_INT);
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
            $stmt->bindParam(':schedule_id', $schedule_id, PDO::PARAM_INT);
    
            // Execute the statement
            $stmt->execute();
            
            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Return the requested column value
            if ($result) {
                return $result[$requested_column] ?? null; // Return null if column not exists
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Log or handle the exception as needed
            error_log("Error retrieving column: " . $e->getMessage());
            return null;
        } catch (InvalidArgumentException $e) {
            // Handle invalid column name exception
            error_log($e->getMessage());
            return null;
        }
    }
    

    public function getCountByConditions($tableName, $conditions) {
        try {
            $sql = "SELECT COUNT(*) as count FROM $tableName";
    
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereConditions = [];
    
                foreach ($conditions as $column => $value) {
                    $whereConditions[] = "$column = :$column";
                }
    
                $sql .= implode(" AND ", $whereConditions);
            }
    
            $stmt = $this->pdo->prepare($sql);
    
            foreach ($conditions as $column => $value) {
                $stmt->bindParam(":$column", $value);
            }
    
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            return $count;
        } catch (PDOException $e) {
            // Handle the exception as needed
            return null;
        }
    }
    
    public function getAllColumnsByColumnValue($tableName, $columnName, $columnValue) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE $columnName = :column_value");
            $stmt->bindParam(':column_value', $columnValue);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Handle the exception here
            return null;
        }
    }
    public function getAllColumns($tableName) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM $tableName WHERE status = 0");
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($result) {
                return $result;
            } else {
                return null; // Entry not found
            }
        } catch (PDOException $e) {
            // Handle the exception here
            return null;
        }
    }

    
}
?>
