<?php
    header("Access-Control-Allow-Origin: *");

    $server_name = "localhost";
    $username = "testuser";
    $password = "123456";
    $db_name = "test";

    $conn = mysqli_connect($server_name,$username,$password,$db_name);

    if(!$conn){
        die("連線失敗:".mysqli_connect_error());
    }else{
        // echo "資料庫連線成功";
    }

    $data_array = array();
    if($_POST){
        if($_POST["type"]){
            if($_POST["type"]=="List"){
                $sql = "SELECT * FROM test202305";
            }elseif($_POST["type"]=="Search"){
                $sql = "SELECT * FROM test202305 WHERE p_name LIKE '%".$_POST["Search_keyword"]."%' OR p_note LIKE '%".$_POST["Search_keyword"]."%'";
            }elseif($_POST["type"]=="New"){
                $sql = "INSERT INTO test202305 (p_name,p_price,p_number,p_note,img_src) VALUES ('".$_POST["n_p_name"]."','".$_POST["n_p_price"]."','".$_POST["n_p_number"]."','".$_POST["n_p_note"]."','0302.jpg')";
            }
        }
        $sql_result = $conn->query($sql);
        if($_POST["type"]=="New"){
            $msg = array("type"=>"new_finish","msg"=>"新增完成");
            array_push($data_array,$msg);
        }else{
            if (mysqli_num_rows($sql_result) != 0) {
                while ($row = $sql_result->fetch_assoc()) {
                    // echo "<tr><td>".$row["sn"]."</td><td>".$row["p_name"]."</td><td>".$row["p_price"]."</td><td>".$row["p_number"]."</td><td>".$row["p_note"]."</td><td>".$row["Create_time"]."</td></tr>";
                    array_push($data_array,$row);
                }
            }
        }
    }else{
        $error_msg = array("type"=>"error","msg"=>"缺乏參數");
        array_push($data_array,$error_msg);
    }
    
    $data_array=json_encode($data_array);
    print_r($data_array);

    $conn->close();
?>