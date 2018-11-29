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
  	$inputData = strtoupper($inputData);
  	return $inputData;
}
function checkDB($event){
	//connect to your database. Type in your username, password and the DB path
	$conn=oci_connect('fpetrini','Uncrackable1', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";       
        exit;
	}		
    //NEED QUERY!
    //$query = oci_parse($conn, "SELECT * FROM Event WHERE eventName = '" . $event ."';");

    
	$query = oci_parse($conn, "SELECT * FROM Participants WHERE E_name = '$event'");
	
	// Execute the query
	oci_execute($query);
	if (($row = oci_fetch_array($query, OCI_BOTH)) == true){
		echo "<font size=6><strong>Event Report For: </strong></font>";
		echo "<font size=6>$event</font>";
		echo "</br>----------------------------------------------";		
		echo "<font color='black' size=5> <pre> <strong>First Name</strong>:\t$row[1] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Last Name</strong>:\t$row[2] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Grad Year</strong>:\t$row[3] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Major</strong>:\t\t$row[4] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Email</strong>:\t\t$row[5] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Alumni Status</strong>:\t$row[6] </pre> </font>";
	}
	else{
		echo "<font size=6><strong>No Valid Report Found</strong></font>";
	}
	while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {		
		// We can use either numeric indexed starting at 0 
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices		
		echo "</br>----------------------------------------------";		
		echo "<font color='black' size=5> <pre> <strong>First Name</strong>:\t$row[1] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Last Name</strong>:\t$row[2] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Grad Year</strong>:\t$row[3] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Major</strong>:\t\t$row[4] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Email</strong>:\t\t$row[5] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Alumni Status</strong>:\t$row[6] </pre> </font>";
	}

	$query = oci_parse($conn, "SELECT count(*) FROM Participants WHERE E_name = '$event'");
	oci_execute($query);
	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		echo "<font color='black' size=5> <pre> <strong>=========================================================</strong> </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Attendance</strong>:\t$row[0] </pre> </font>";
	}
	$query = oci_parse($conn, "SELECT count(*) FROM Participants WHERE E_name = '$event' and dbFlag = 'YES'");
	oci_execute($query);
	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		echo "<font color='black' size=5> <pre> <strong>Total Alumni</strong>:\t$row[0] </pre> </font>";
	}
	$query = oci_parse($conn, "SELECT count(*) FROM Participants WHERE E_name = '$event' and dbFlag = 'NO'");
	oci_execute($query);
	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		echo "<font color='black' size=5> <pre> <strong>Total Guest</strong>:\t$row[0] </pre> </font>";
	}
	
	OCILogoff($conn);	
}
?>

