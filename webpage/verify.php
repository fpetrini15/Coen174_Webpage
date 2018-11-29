
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // collect input data
	
	// Get the title
     $First = $_POST['first'];
     $Last = $_POST['last'];
     $year = $_POST['year'];
     $major = $_POST['major'];

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
     if (!empty($major)){
		$major = prepareInput($major);		
     }  
	
	checkDB($First, $Last, $year, $major);
	
}
function prepareInput($inputData){
	$inputData = trim($inputData);
  	$inputData  = htmlspecialchars($inputData);
  	$inputData = strtoupper($inputData);
  	return $inputData;
}
function checkDB($First, $Last, $year, $major){
	//connect to your database. Type in your username, password and the DB path
	$conn=oci_connect('fpetrini','Uncrackable1', '//dbserver.engr.scu.edu/db11g');
	if(!$conn) {
	     print "<br> connection failed:";       
        exit;
	}		
    //NEED QUERY!
    $query = oci_parse($conn, "SELECT * FROM ALUMNI WHERE FIRST = '$First' and LAST = '$Last' and YEAR = '$year' and MAJOR = '$major'");


	oci_execute($query);
	if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {     
      // We can use either numeric indexed starting at 0 
      // or the column name as an associative array index to access the colum value
      // Use the uppercase column names for the associative array indices  
		echo "<font size=6><strong>Valid Alumni Found!</strong></font>";
        echo "<font color='black' size=5> <pre> <strong>First Name</strong>:\t$row[1] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Last Name</strong>:\t$row[2] </pre> </font>";
		echo "<font color='black' size=5> <pre> <strong>Grad Year</strong>:\t$row[3] </pre> </font>";
   }
   else{
   	echo "<font size=6><strong>No Valid Alumni Found</strong></font>";
   }

   OCILogoff($conn);
}
?>

