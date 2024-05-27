<?php
    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/register.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true); 
        if(isset($json['request_type']) && $json['request_type'] == "register"){ 
           $fname = $json['fname']; 
           $lname = $json['lname'];
           $email = $json['email'];
           $phone = $json['phone'];
           $password = $json['password'];
        //   $gender = $json['gender'];
           $user_create_date = date('M d,Y');
           
           $hashed_password = password_hash($password, PASSWORD_DEFAULT);
           
           $check_user = "SELECT email FROM users WHERE email = '".$email."' ";
           $user_run = $conn->query($check_user);
           if($user_run->num_rows > 0){
                $result['msg'] = 'Already Exist. Please try with another email!';
                $result['status'] = '403';
           }else{
                $sql = "INSERT INTO users(fname,lname,email,phone,password,user_create_date) VALUES('$fname','$lname','$email','$phone','$hashed_password','$user_create_date')";
                $run = $conn->query($sql);
               
                if($run){
                    $result['msg'] = 'Record inserted successfully.';
                    $result['status'] = '200'; 
                }else{
                    $result['msg'] = 'Error';
                    $result['status'] = '400'; 
                }
           } 
           
        } else { 
            $result['msg'] = 'Please provide valid request type!';
            $result['status'] = '400'; 
        }
        echo json_encode($result);
    }
?>