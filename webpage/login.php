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
    $query = oci_parse($conn, "SELECT * FROM Credentials WHERE username = :uname and password = :psw");
   
   oci_bind_by_name($query, ':uname', $uname);
   oci_bind_by_name($query, ':psw',  $psw);

   oci_execute($query);
   if (($row = oci_fetch_array($query, OCI_BOTH)) != false) {     
      // We can use either numeric indexed starting at 0 
      // or the column name as an associative array index to access the colum value
      // Use the uppercase column names for the associative array indices     
      header("Location: http://francescogpetrini.com");
      exit;
   
   }
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
   echo("Login unsuccessful");
   OCILogoff($conn); 
}
?>


<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <label>UserName  :</label><input type = "text" name = "username" class = "box"/><br /><br />
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br/><br />
                  <input type = "submit" value = " Submit "/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>