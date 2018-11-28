
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // collect input data
	
	// Get the title
     $event = $_POST['eventName']; 
	 
	// Get the author
	 
      
     if (!empty($event)){
		$event = prepareInput($event);		
     } 
	
	checkDB($event);
	
}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	return $inputData;
}
function checkDB($event){
	//connect to your database. Type in your username, password and the DB path
	echo($event);
	$conn=oci_connect('fpetrini','Uncrackable1', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";       
        exit;
	}		
    //NEED QUERY!
    //$query = oci_parse($conn, "SELECT * FROM Event WHERE eventName = '" . $event ."';");
    $stmt = oci_parse($conn, "SELECT * FROM Event WHERE eventName = :event");
                        
    oci_bind_by_name($stmt, ':event', $event);
    
	oci_execute($stmt);
	while (($row = oci_fetch_array($stmt, OCI_BOTH)) != false) {		
		// We can use either numeric indexed starting at 0 
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices		
		echo "<font size=6><strong>Event Report</strong></font>";
		echo "</br>----------------------------------------------";		
		echo "<font color='black' size=5> <pre> <strong>Event Name</strong>:\t$row[0] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Location</strong>:\t$row[1] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Attendance</strong>:\t$row[2] </pre> </font>";
	}
    oci_free_statement($stmt);
	
	OCILogoff($conn);	
}
?>

