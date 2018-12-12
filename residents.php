<?php 
//load database connection
    $host = "localhost";
    $user = "root";
    $password = "";
    $database_name = "registration";
    $pdo = new PDO("mysql:host=$host;dbname=$database_name", $user, $password, array(
   PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
   ));
// Search from MySQL database table
$search=$_POST['search'];
$query = $pdo->prepare("select * from residentt where apartno LIKE '%$search%' OR resident LIKE '%$search%'  LIMIT 0 , 10");
$query->bindValue(1, "%$search%", PDO::PARAM_STR);
$query->execute();
// Display search result

         if (!$query->rowCount() == 0) {
		 		echo "Search found :<br/>";
				echo "<table style=\"font-family:arial;color:#333333;\">";	
                echo "<tr><td style=\"border-style:solid;
                border-width:1px;
                border-color: grey;
                background:#98bf21;\">
                Resident</td>
                <td style=\"border-style:solid;
                border-width:1px;
                border-color:#98bf21;
                background:#98bf21;\">
                Apartno</td><td style=\"border-style:solid;
                border-width:1px;border-color:#98bf21;
                background:#98bf21;\">
                Type</td>
                
                <td style=\"border-style:solid;
                border-width:1px;
                border-color:#98bf21;
                background:#98bf21;\">
                Time</td>
                
                
                </tr>";
              


            while ($results = $query->fetch()) {
                echo "<tr><td style=\"border-style:solid;
                border-width:1px;
                border-color:#98bf21;
                transition: all .5s;\">";			
                echo $results['resident'];
                echo "</td><td style=\"border-style:solid;
                border-width:1px;
                border-color:#98bf21;\">";
                echo $results['apartno'];
                echo "</td><td style=\"border-style:solid;
                border-width:1px;
                border-color:#98bf21;\">";
                echo $results['vtype'];
                echo "</td><td style=\"border-style:solid;
                border-width:1px;
                border-color:#98bf21;\">";
                echo $results['vtime'];
				echo "</td></tr>";				
            }
				echo "</table>";		
        } else {
            echo "<table style=\"font-family:arial;color:#333333;\">";	
            echo "<tr><td style=\"border-style:solid;
            border-width:1px;
            border-color: grey;
            background:#98bf21;\">
            Resident</td>
            <td style=\"border-style:solid;
            border-width:1px;
            border-color:#98bf21;
            background:#98bf21;\">
            Apartno</td><td style=\"border-style:solid;
            border-width:1px;border-color:#98bf21;
            background:#98bf21;\">
            Type</td>
            
            <td style=\"border-style:solid;
            border-width:1px;
            border-color:#98bf21;
            background:#98bf21;\">
            Time</td>
            
            
            </tr>";
        }

?>

