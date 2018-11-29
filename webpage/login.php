<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // collect input data
   
   // Get the title
     $uname = $_POST['uname'];
     $psw = $_POST['psw'];
    
   // Get the author
    
      
     if (!empty($uname)){
      $uname = prepareInput($uname);      
     }
     if (!empty($psw)){
      $psw = prepareInput($psw);     
     } 
   
   verifyCredentials($uname, $psw);
   
}
function prepareInput($inputData){
   $inputData = trim($inputData);
   $inputData  = htmlspecialchars($inputData);
   return $inputData;
}
function verifyCredentials($uname, $psw){
   //connect to your database. Type in your username, password and the DB path
   $conn=oci_connect('fpetrini','Uncrackable1', '//dbserver.engr.scu.edu/db11g');
   if(!$conn) {
        print "<br> connection failed:";       
        exit;
   }     
    //NEED QUERY!
   $uname = hash('sha256', (get_magic_quotes_gpc() ? stripslashes($uname) : $uname));
   $psw = hash('sha256', (get_magic_quotes_gpc() ? stripslashes($psw) : $psw));
 
   $query = oci_parse($conn, "SELECT * FROM AUTHENTICATION WHERE USERNAME = '$uname' and PASSWORD = '$psw'");

   oci_execute($query);
   if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {     
      // We can use either numeric indexed starting at 0 
      // or the column name as an associative array index to access the colum value
      // Use the uppercase column names for the associative array indices  
      echo("Successful");
      header("Location: http://linux.students.engr.scu.edu/~fpetrini/webpage/D25399744FBDF017C51C134BA09003AC2F24598889C78249C074F0D0787EF6C1/auth_selection.html");
      exit;
   
   }
   header("Location: http://linux.students.engr.scu.edu/~fpetrini/webpage/D25399744FBDF017C51C134BA09003AC2F24598889C78249C074F0D0787EF6C1/unsuccessful.html");
}
?>


