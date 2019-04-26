<!DOCTYPE html>
<html>

   <head>
        <title>Add Flight</title>
        <link rel="stylesheet" href="style.css">
    </head>
	<ul>
		<li><a href="Homepage.php">Home</a></li>
		<li><a href="BuyTicket.php">Buy Ticket</a></li>
		<li><a href="CancelTicket.php">Cancel Ticket</a></li>
		<li><a href="Adminpage.php">Admin Home</a></li>
		<li><a href="AddPlane.php">Add Plane</a></li>
		<li><a href="RemovePlane.php">Remove Plane</a></li>
		<li><a class="active" href="AddFlight.php">Add Flight</a></li>
		<li><a href="RemoveFlight.php">Remove Flight</a></li>
	</ul>

   <body>
   <div>
      <?php
	  
		require("tableshow.php");
		require("dbconnect.php");
		require("idGen.php");
		
		show_plane($conn);
	  
         if(isset($_POST['add'])) {
            $i_flightID = generateID();
			$i_DepartTime = $_POST['i_DepartTime'];
            $i_DepartAP = $_POST['i_DepartAP'];
            $i_DestAP = $_POST['i_DestAP'];
            $i_ETA = $_POST['i_ETA'];
			$i_planeID = $_POST['i_planeID'];
			
			echo " <br> Flight table before insertion <br>";
			show_flight($conn);
   
            $sql = "INSERT INTO flight ".
               "(flight_id,flight_depart_timestamp, ETA, destination_airport, departure_airport) "."VALUES ".
               "('$i_flightID','$i_DepartTime','$i_ETA', '$i_DestAP','$i_DepartAP')";
            
			
			$sql2 = "insert into plane_makes_flight(flight_id, plane_id) values('$i_flightID','$i_planeID')";
			
			$retval = mysqli_query($conn, $sql);
            if(! $retval) {
               die('Could not enter data: ' . mysqli_error($conn));
            }
			
			$retval = mysqli_query($conn, $sql2);
            if(! $retval) {
               die('Could not enter data: ' . mysqli_error($conn));
            }
         
            echo "Entered data successfully\n\n";
			/////////////////////////////////////////////////////////////
			//Create Empty First Class Tickets
			$amtFirstQ = "select first_class_seats from plane where plane_id = '$i_planeID'";
			$retval = mysqli_query($conn, $amtFirstQ);
			$row = $retval->fetch_assoc();
			$retval = intval($row['first_class_seats']);
			for($i = 0; $i < $retval; $i++){
				$idVal = generateID();
				$insertQ = "insert into ticket_holder(ticket_id, seating_type, price, ticket_depart_timestamp, username) values($idVal,'FirstClass','100','$i_DepartTime','NULL')";
				$retval2 = mysqli_query($conn, $insertQ);
				if(! $retval2) {
					die('Could not enter data: ' . mysqli_error($conn));
				}
			}
			/////////////////////////////////////////////////////////////
			//Create Empty Second Class Tickets
			
			$amtSecondQ = "select second_class_seats from plane where plane_id = '$i_planeID'";
			$retval = mysqli_query($conn, $amtSecondQ);
			$row = $retval->fetch_assoc();
			$retval = intval($row['second_class_seats']);
			for($i = 0; $i < $retval; $i++){
				$idVal = generateID();
				$insertQ = "insert into ticket_holder(ticket_id, seating_type, price, ticket_depart_timestamp, username) values($idVal,'SecondClass','50','$i_DepartTime','NULL')";
				$retval2 = mysqli_query($conn, $insertQ);
				if(! $retval2) {
					die('Could not enter data: ' . mysqli_error($conn));
				}
			}
			/////////////////////////////////////////////////////////////
            //Create Empty Economy Class Tickets
			
			$amtEconomyQ = "select economy_seats from plane where plane_id = '$i_planeID'";
			$retval = mysqli_query($conn, $amtEconomyQ);
			$row = $retval->fetch_assoc();
			$retval = intval($row['economy_seats']);
			for($i = 0; $i < $retval; $i++){
				$idVal = generateID();
				$insertQ = "insert into ticket_holder(ticket_id, seating_type, price, ticket_depart_timestamp, username) values($idVal,'EconomyClass','25','$i_DepartTime','NULL')";
				$retval2 = mysqli_query($conn, $insertQ);
				if(! $retval2) {
					die('Could not enter data: ' . mysqli_error($conn));
				}
			}
			/////////////////////////////////////////////////////////////
			echo " <br> Flight table after insertion <br>";
			show_flight($conn);
			
            mysqli_close($conn);
         } 
		 else if(isset($_POST['show'])){
			 
			 show_flight($conn);
		 }	 
		 
		 else {
      ?>
	  <br><br><br><br>
     <p>Enter flight info for insertion <br> </p>
      <form method = "post" action = "<?php $_PHP_SELF ?>">
         <table width = "600" border = "0" cellspacing = "1" cellpadding = "2">
            <tr>
               <td width = "250">Departure Time</td>
               <td>
                  <input name = "i_DepartTime" type = "text" id = "i_DepartTime">
               </td>
            </tr>
         
            <tr>
               <td width = "250">Departure Airport</td>
               <td>
                  <input name = "i_DepartAP" type = "text" id = "i_DepartAP">
               </td>
            </tr>
         
            <tr>
               <td width = "250">Destination  Airport</td>
               <td>
                  <input name = "i_DestAP" type = "text" id = "i_DestAP">
               </td>
            </tr>
      
            <tr>
               <td width = "250"> ETA</td>
               <td> <input name="i_ETA" type= "text" id = "i_ETA"> </td>
            </tr>
			
			<tr>
               <td width = "250"> Plane ID</td>
               <td> <input name="i_planeID" type= "text" id = "i_planeID"> </td>
            </tr>
			
            <tr>
               <td width = "250"></td>
               <td> </td>
            </tr>
         
            <tr>
               <td width = "250"> </td>
               <td>
                  <input name = "add" type = "submit" id = "add"  value = "insert">
               </td>
            </tr>
			
         </table>
		<?php
			show_plane_makes_flight($conn); //shows this table to help the user assign a plane to a flight, currently plane_makes_flight doesnt seem to be working as intended
		?>
		
	  
   <?php
      }
   ?>
   
   </div>
   
   </body>
</html>