<?php 
    $servername = 'localhost';
    $username = 'root';
    $password ='';
    $dbname = 'hotel';

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $conn->set_charset("utf8");
    if(!$conn){
        die("Cannot connect to database" . mysqli_connect_error());
    }

    function filteration($data){
        foreach($data as $key => $value){
            $value = trim($value);
            $value = stripslashes($value);          
            $value = strip_tags($value);
            $value = htmlspecialchars($value);

            $data[$key] = $value; 
        }
        return $data;
    }

    function select($sql, $values, $datatypes){
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }else{
                mysqli_stmt_close($stmt);
                die('Cannot excecute query - Select');
            }
        }
        else{
            die('Cannot excecute query - Select');
        }
    }

    function update($sql, $values, $datatypes){
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                return '1';
            }else{
                mysqli_stmt_close($stmt);
                die('Cannot excecute query - UPDATE');
            }
        }
        else{
            die('Cannot excecute query - UPDATE');
        }
    }

    function insert($sql, $values, $datatypes){
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                return '1';
            }else{
                mysqli_stmt_close($stmt);
                die('Cannot excecute query - UPDATE');
            }
        }
        else{
            die('Cannot excecute query - UPDATE');
        }
    }

    function delete($sql, $values, $datatypes){
        $conn = $GLOBALS['conn'];
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_close($stmt);
                return '1';
            }else{
                mysqli_stmt_close($stmt);
                die('Cannot excecute query - UPDATE');
            }
        }
        else{
            die('Cannot excecute query - UPDATE');
        }
    }

    function selectAll($tableName){
        $conn = $GLOBALS['conn'];
        $sql = "SELECT * FROM $tableName";
        $rows = mysqli_query($conn, $sql);
        return $rows;
    }
?>