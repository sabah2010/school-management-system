
<?php 
//ini_set('display_errors','on'); version_compare(PHP_VERSION, '5.5.0') <= 0 ? error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);   // DEBUGGING 

$username = $_REQUEST['studentName']; 
$birth = $_REQUEST['bod']; 
$gender = $_REQUEST['gender']; 
$city = $_REQUEST['city']; 
 
 
if($username!='' && strlen($username)>2 ){ 
	$con = new mysqli('localhost', 'root', '', 'school_db'); 
	if ($con->connect_error) { 
		die('Connection failed: ' . $con->connect_error); 
	} else { 
		
		$stmt = $con->prepare("INSERT INTO studentdata(id, name, date_of_birth, gender, city) VALUES (NULL, '$username', '$birth', '$gender', '$city')"); 
		 
		 
		$stmt->bind_param(); 
		 
		 
		$stmt->execute(); 
	  
		
		echo "Registration successful"; 
		 
		
		$stmt->close(); 
		$con->close(); 
		header('Location: studentInf.php'); 
		exit();
	} 
}

?> 