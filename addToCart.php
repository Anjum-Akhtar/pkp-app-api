<?php
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/addToCart.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true); 
        if(isset($json['request_type']) && $json['request_type'] == "addToCart"){   
            $cart_pro_id = $json['addtocart_pro_id'];
            $uemail = $json['uemail'];
            
        	$check_cart=$conn->query("SELECT pro_id,qty FROM cart WHERE pro_id='".$cart_pro_id."' AND uemail='".$uemail."'");
        	$qty = $json['qty'];
        	$date=date('Y-m-d h:i:s');
        	if(mysqli_num_rows($check_cart)>0){ 
        		$row=mysqli_fetch_assoc($check_cart);
        		$upd_qty=(int)$row['qty']+1;
        		$upd=$conn->query("UPDATE cart SET qty='".$upd_qty."' WHERE pro_id='".$cart_pro_id."' AND uemail='".$uemail."' ");
        		if($upd){ 
        			$result['msg'] = 'Product added to cart.';
                    $result['status'] = 200;
        		}else{  
        			$result['msg'] = 'Something wents wrong!';
                    $result['status'] = 400;
        		}
        
        	}else{ 
        		$ins=$conn->query("INSERT INTO cart (pro_id,qty,uemail) VALUES ('".$cart_pro_id."', '".$qty."', '".$uemail."')");
        		if($ins){ 
        			$result['msg'] = 'Product added to cart.';
                    $result['status'] = 200; 
        		}else{ 
        			$result['msg'] = 'Something wents wrong!';
                    $result['status'] = 400;
        		}
        	}
           
        }else if(isset($json['request_type']) && $json['request_type'] == "getCart"){
            $uemail = $json['uemail'];
            $get_cart=$conn->query("SELECT pro_id,qty FROM cart WHERE uemail='".$uemail."'");
            $data=array();
        	if(mysqli_num_rows($get_cart)>0){
        	    while($row=mysqli_fetch_assoc($get_cart)){
        	        $data[]=$row;
        	    }
        	    
        	    $result['msg'] = 'Your cart data';
                $result['status'] = 200;
                $result['data'] = $data;
        	}else{
        	    $result['msg'] = 'Your cart is empty';
                $result['status'] = 400;
        	}
        }else if(isset($json['request_type']) && $json['request_type'] == "getCartValues"){
            $uemail = $json['uemail'];
            $cart = $conn->query("SELECT pro_id,qty,uemail,product_name,regular_price,sale_price,product_img1 FROM cart c INNER JOIN products p ON c.pro_id=p.product_id WHERE c.uemail= '".$uemail."'");
            $data=array();
        	if(mysqli_num_rows($cart)>0){
				$price = 0;
        	    while($row=mysqli_fetch_assoc($cart)){
					if($row['sale_price'] != ''){
						$price = $price+($row['sale_price']*$row['qty']);
					} else {
						$price = $price+($row['regular_price']*$row['qty']);
					}
        	        $data[]=$row;
        	    }
        	    
        	    $result['msg'] = 'Your cart all data';
                $result['status'] = 200;
				$result['total_price'] = $price;
                $result['data'] = $data;
        	}else{
        	    $result['msg'] = 'Your cart is empty';
                $result['status'] = 400;
        	}
        }else if(isset($json['request_type']) && $json['request_type'] == "deleteCart"){
            $uemail = $json['uemail'];
            $cart_pro_id = $json['addtocart_pro_id'];
            $cart = $conn->query("DELETE FROM cart WHERE uemail= '".$uemail."' AND pro_id='".$cart_pro_id."' ");  
        	if($cart){ 
        	    $result['msg'] = 'Product removed.';
                $result['status'] = 200; 
        	}else{
        	    $result['msg'] = 'Something wents wrong!';
                $result['status'] = 400;
        	}
        } else { 
            $result['msg'] = 'Please provide valid request type!';
            $result['status'] = 400; 
        }
        echo json_encode($result);
    }
?>