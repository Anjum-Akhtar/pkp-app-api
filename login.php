<?php
    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true); 
        if(isset($json['request_type']) && $json['request_type'] == "login"){ 
           $email = $json['email']; 
           $password = $json['password'];   
           
           $check_user = "SELECT fname,lname,email,phone,password FROM users WHERE email = '".$email."' ";
           $user_run = $conn->query($check_user);
           if($user_run->num_rows > 0){ 
                while( $data = mysqli_fetch_all($user_run, MYSQLI_ASSOC)){ 
                    foreach($data as $user_details){ 
                        $hashed_password = $user_details['password']; 
                      
                        if(password_verify($password, $hashed_password)) {
                            $result['msg'] = 'Login successfully.';
                            $result['status'] = '200';
                            $result['records'] = $data;
                        } else {
                            $result['msg'] = 'Please enter valid password!';
                            $result['status'] = '404';
                        }
                    }   
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