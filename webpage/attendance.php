
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // collect input data
	
	// Get the title
     $First = $_POST['first'];
     $Last = $_POST['last'];
     $year = $_POST['year'];
     $email = $_POST['email'];

     $field = isset($_POST['alumnus']) ? $_POST['alumnus'] : false;
	 $dbFlag = $field ? 'Yes' : 'No'; 
	 
	// Get the author
	 
      
     if (!empty($First)){
		$First = prepareInput($First);		
     }
     if (!empty($Last)){
		$Last = prepareInput($Last);		
     } 
     if (!empty($year)){
		$year = prepareInput($year);		
     } 
     if (!empty($email)){
		$email = prepareInput($email);		
     }  
     if (!empty($dbFlag)){
		$dbFlag = prepareInput($dbFlag);		
     } 
	
	insertIntoDB($First, $Last, $year, $email, $dbFlag);
	
}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}
function insertIntoDB($First, $Last, $year, $email, $dbFlag){
	//connect to your database. Type in your username, password and the DB path
	$conn=oci_connect('fpetrini','Uncrackable1', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";       
        exit;
	}		
    //NEED QUERY!
    $query = oci_parse($conn, "INSERT into Attendance VALUES(upper(:First), upper(:Last), :year, upper(:email), upper(:dbFlag))");
	
	oci_bind_by_name($query, ':First', $First);
	oci_bind_by_name($query, ':Last',  $Last);
	oci_bind_by_name($query, ':year', $year);
	oci_bind_by_name($query, ':email', $email);
	oci_bind_by_name($query, ':dbFlag', $dbFlag);

	oci_execute($query);
	echo ("Thank you for your submission!");
?>
	<html>
	<button onclick="goBack()">Go Back</button>
		<script>
		function goBack() {
		    window.history.back();
		}
		</script>
	</html>
<?php
	OCILogoff($conn);	
}
?>

