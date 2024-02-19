<?php
    include 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/productDetail.php') {
        $data = file_get_contents('php://input');
        $json = json_decode($data, true);
     
        if(isset($json['request_type']) && $json['request_type'] == "productDetail"){
            $pro_id = $json['product_id'];
            
            $sql = "select product_id,product_name,long_desc,regular_price,sale_price,categories,product_img1,product_gallery FROM products WHERE product_id='$pro_id'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) { 
                $data = mysqli_fetch_assoc($result); 
                if(!empty($data['product_gallery'])){
                    
                    $gal_images = explode(',',$data['product_gallery']); 
                    array_unshift($gal_images,$data['product_img1']);
                    $data['product_gal'] = $gal_images;
                    unset($data['product_img1'],$data['product_gallery']);
                    
                } 
                echo json_encode(['msg' => 'Product found!', 'status' => '200', 'data' => $data]);
            } else {
                echo json_encode(['msg' => 'No product found!', 'status' => '404']);
            }
        } else {
            echo json_encode(['msg' => 'Please provide valid request type!', 'status' => '400']);
        }
    }
?>