<?php 
	include 'connect.php';

	if ($_FILES['file']['name'] && $_POST['productId']) {
		$productId = $_POST['productId'];
		$folder="uploads/products/";
	    $file = $_FILES['file']['name'];
	    $file_loc = $_FILES['file']['tmp_name'];
	    $file_size = $_FILES['file']['size'];
	    $file_type = $_FILES['file']['type'];
	    $temp1= explode(".", $_FILES["file"]["name"]);
	    $newfn1= round(microtime(true)) .'cyizere.'. end($temp1);
	    $file_file_size = $file_size/1024;  
	    $new_file_name1 = strtolower($newfn1);
	    $new_file1 = strtolower($file);
	    $random_file = str_replace(' ','-',$new_file_name1);
	    if(move_uploaded_file($file_loc,$folder.$random_file)){
	    	$q = mysqli_query($conn, "insert into product_image(product_id,image) values('$productId','$random_file')");
	    	if($q){
	    		$obj = new StdClass();
				$obj->msg= "File uploaded success full";
		        $obj->type= "success";
		        $obj->fileName= $random_file;
		        echo json_encode($obj);	
	    	}else{
	    		if (file_exists($folder.$random_file)) {
	    			unlink($folder.$random_file);    			
	    		}
	    		$obj = new StdClass();
				$obj->msg= "Something went wrong. try again later.";
		        $obj->type= "error";
		        echo json_encode($obj);
	    	}	    	
	    }else{
	    	$obj = new StdClass();
			$obj->msg= "Failed to upload image, try again later after some time.";
	        $obj->type= "error";
	        echo json_encode($obj);
	    }
	}
?>