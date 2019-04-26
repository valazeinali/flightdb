<!DOCTYPE html>
<html>
	<head>
			<title>Remove Plane</title>
			<link rel="stylesheet" href="style.css">
		</head>
		<ul>
			<li><a href="Homepage.php">Home</a></li>
			<li><a href="BuyTicket.php">Buy Ticket</a></li>
			<li><a href="CancelTicket.php">Cancel Ticket</a></li>
			<li><a href="Adminpage.php">Admin Home</a></li>
			<li><a href="AddPlane.php">Add Plane</a></li>
			<li><a href="RemovePlane.php">Remove Plane</a></li>
			<li><a href="AddFlight.php">Add Flight</a></li>
			<li><a class="active" href="RemoveFlight.php">Remove Flight</a></li>
		</ul>
	<body>
	   <div>
		  <?php
		  
			require("tableshow.php");
			require("dbconnect.php");
			require("idGen.php");
		  
			show_flight($conn);
			 if(isset($_POST['add'])) {
				$i_flightID = $_POST['$i_flightID'];
				
				echo " <br> Plane table before deletion <br>";
				show_flight($conn);
	   
				$sql = "DELETE FROM flight WHERE flight_id = $i_flightID";
				
				//mysqli_select_db($conn,'university');
				$retval = mysqli_query($conn, $sql);
			 
				if(! $retval ) {
				   die('Could not enter data: ' . mysqli_error($conn));
				}
			 
				echo "Entered data successfully\n\n";
				
				echo " <br> Plane table after deletion <br>";
				show_flight($conn);
				
				mysqli_close($conn);
			 } 
			 else if(isset($_POST['show'])){
				 
				 show_flight($conn);
			 }	 
			 
			 else {
		  ?>
		  <br><br><br><br>
		 <p>Enter flight info for deletion <br> </p>
		  <form method = "post" action = "<?php $_PHP_SELF ?>">
			 <table width = "600" border = "0" cellspacing = "1" cellpadding = "2">
				<tr>
				   <td width = "250">Plane ID</td>
				   <td>
					  <input name = "$i_flightID" type = "text" id = "$i_flightID">
				   </td>
				</tr>
		  
				
				<tr>
				   <td width = "250"></td>
				   <td> </td>
				</tr>
			 
				<tr>
				   <td width = "250"> </td>
				   <td>
					  <input name = "add" type = "submit" id = "add"  value = "delete">
				   </td>
				</tr>
				
			 </table>
			
		  
		   <?php
			  }
		   ?>
	   
	   </div>
   
   </body>
</html>