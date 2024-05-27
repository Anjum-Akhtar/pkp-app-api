<?php
    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/checkout.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true); 
        if(isset($json['request_type']) && $json['request_type'] == "checkout"){  

            function getUserIP() {
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    // IP from shared internet
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    // IP passed from proxy
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                    // IP address from remote address
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                return $ip;
            } 
            $ip_address = getUserIP();
            $added_on = date('M, j Y');
            $fname = $json['fname']; 
            $lname = $json['lname'];
            $company_name = $json['company_name'];
            $street_address = $json['street_address'];
            $country = $json['country'];
            $state = $json['state'];
            $city = $json['city'];
            $pincode = $json['pincode']; 
            $phone = $json['phone'];
            $email = $json['email'];
            $total_price = $json['total_price'];
            $final_price = $json['final_price'];
            $payment_type = $json['payment_type'];
            $payment_status = $json['payment_status'];
            $order_status = $json['order_status']; 

            $sql = $conn->query("INSERT INTO orders(fname,lname,company_name,street_address,country,state,city,pin,phone,email,ip_add,total_price,final_price,payment_type,payment_status,order_status) VALUES('".$fname."','".$lname."','".$company_name."','".$street_address."','".$country."','".$state."','".$city."','".$pincode."','".$phone."','".$email."','".$ip_address."','".$total_price."','".$final_price."','".$payment_type."','".$payment_status."','".$order_status."')"); 
            
            if($sql){
                $result['msg'] = 'Order Created successfully.';
                $result['status'] = '200'; 
            }else{
                $result['msg'] = 'Error';
                $result['status'] = '400'; 
            }
           
        } else { 
            $result['msg'] = 'Please provide valid request type!';
            $result['status'] = '400'; 
        }
        echo json_encode($result);
    }
?>