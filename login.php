<?php
    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true); 
        if(isset($json['request_type']) && $json['request_type'] == "login"){ 
           $email = $json['email']; 
           $password = $json['password'];   
           
           $check_user = $conn->query("SELECT fname,lname,email,phone,password FROM users WHERE email = '".$email."' ");
           if(mysqli_num_rows($check_user) > 0){ 
                $data = mysqli_fetch_assoc($check_user);
                $hashed_password = $data['password']; 
                if(password_verify($password, $hashed_password)) {
                    $result['msg'] = 'Login successfully.';
                    $result['status'] = '200';
                    $result['records'] = $data;
                }else{
                    $result['msg'] = 'Please enter valid password!';
                    $result['status'] = '404';
                }
           }else{ 
                $result['msg'] = 'You are not register with us!';
                $result['status'] = '500';  
           } 
           
        } else { 
            $result['msg'] = 'Please provide valid request type!';
            $result['status'] = '400'; 
        }
        echo json_encode($result);
    }
?>