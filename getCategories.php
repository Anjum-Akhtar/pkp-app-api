<?php
    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/getCategories.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);
    
        if(isset($json['request_type']) && $json['request_type'] == "getCategories"){
            $sql = "select * from categories";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) { 
                $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            
                echo json_encode(['msg' => 'Record found!', 'status' => '200', 'data' => $data]);
            } else {
                echo json_encode(['msg' => 'No Data!', 'status' => '400']);
            }
        } else {
            echo json_encode(['msg' => 'Please provide valid request type!', 'status' => '400']);
        }
    }
?>