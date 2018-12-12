<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 
$vname ="";
$purpose ="";
$person_to_visit ="";
$apart_no ="";
$mob_no ="";
$vehicle_no ="";
$vtype ="";
$resident ="";
$time = "";
$apartno ="";
$usertype="";
$rname="";
$rtype="";
$mobno="";
$flatno="";
$date_time = "";
$services= "";
$dname = "";
$company = "";
$phone_no = "";


// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $usertype = mysqli_real_escape_string($db, $_POST['usertype']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password, usertype) 
  			  VALUES('$username', '$email', '$password','$usertype')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

if (isset($_POST['visit'])) {

  $db = mysqli_connect('localhost', 'root', '', 'registration');

  // receive all input values from the form
  $vname = $_POST['vname'];
  $purpose= $_POST['purpose'];
  $person_to_visit = $_POST['person_to_visit'];
  $apart_no = $_POST['apart_no'];
  $mob_no = $_POST['mob_no'];
  $vehicle_no = $_POST['vehicle_no'];

  
  $query = ("INSERT INTO visitors ( vname , purpose, person_to_visit, apart_no, mob_no, vehicle_no) 
        VALUES('$vname', '$purpose', '$person_to_visit', '$apart_no','$mob_no','$vehicle_no')");
  mysqli_query($db, $query);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($vname)) { array_push($errors, "Username is required"); }
  if (empty($purpose)) { array_push($errors, "purpose is required"); }
  if (empty($person_to_visit)) { array_push($errors, "person to visit is required"); }
  if (empty($apart_no)) { array_push($errors, "apartement number is required"); }
  if (empty($mob_no)) { array_push($errors, "mobile number is required"); }
  if (empty($vehicle_no)) { array_push($errors, "vehicle is required"); }
  
  }

  //notify gate
  if (isset($_POST['notify'])) {

    $db = mysqli_connect('localhost', 'root', '', 'registration');
  
    // receive all input values from the form
    
    $resident = $_POST['resident'];
    $apartno = $_POST['apartno'];
    $vtype = $_POST['vtype'];
    $vtime = $_POST['vtime'];
    
    $query = ("INSERT INTO notifygate (resident , apartno, vtype, vtime) 
          VALUES('$resident', '$apartno', '$vtype', '$vtime')");
    mysqli_query($db, $query);
  
    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($resident)) { array_push($errors, "Resident Name is required"); }
    if (empty($apartno)) { array_push($errors, "Apartement No is required"); }
    if (empty($vtype)) { array_push($errors, "Visitor type is required"); }
    if (empty($vtime)) { array_push($errors, "Time is required"); }
    }


    //new resident
    if (isset($_POST['addresident'])) {

      $db = mysqli_connect('localhost', 'root', '', 'registration');
    
      // receive all input values from the form
      $rname = $_POST['rname'];
      $email= $_POST['email'];
      $mobno = $_POST['mobno'];
      $flatno = $_POST['flatno'];
      $rtype = $_POST['rtype'];
          
      
      $query = ("INSERT INTO residentt ( rname , email, mobno, flatno, rtype) 
            VALUES('$rname', '$email', '$mobno', '$flatno','$rtype')");
      mysqli_query($db, $query);
    
      // form validation: ensure that the form is correctly filled ...
      // by adding (array_push()) corresponding error unto $errors array
      if (empty($rname)) { array_push($errors, "resident is required"); }
      if (empty($email)) { array_push($errors, "email is required"); }
      if (empty($mobno)) { array_push($errors, "mobile no is required"); }
      if (empty($flatno)) { array_push($errors, "flat No is required"); }
      if (empty($rtype)) { array_push($errors, " resident type is required"); }
        header('location: newresident.php');
      
      
      }
    
      //cab checkin
      if (isset($_POST['validatecab'])) {

        $db = mysqli_connect('localhost', 'root', '', 'registration');

        $vname = mysqli_real_escape_string($db, $_POST['dname']);
        $person_to_visit = mysqli_real_escape_string($db, $_POST['cltname']);
        $mob_no = mysqli_real_escape_string($db, $_POST['phone_no']);
        $vehicle_no = mysqli_real_escape_string($db, $_POST['v_no']);
        $date_time = mysqli_real_escape_string($db, $_POST['date_time']);
        // receive all input values from the form
        /*$vname = $_POST['vname'];
        $person_to_visit = $_POST['person_to_visit'];
        $mob_no = $_POST['mob_no'];
        $vehicle_no = $_POST['vehicle_no'];
        $date_time = $_POST['date_time'];*/
      
        
        $query = ("INSERT INTO cab ( dname , cltname, phone_no, v_no, date_time) 
              VALUES('$vname', '$person_to_visit', '$mob_no', '$vehicle_no','$date_time')");
        mysqli_query($db, $query);
      
        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($vname)) { array_push($errors, "Username is required"); }
        if (empty($person_to_visit)) { array_push($errors, "person to visit is required"); }
        if (empty($mob_no)) { array_push($errors, "mobile number is required"); }
        if (empty($vehicle_no)) { array_push($errors, "vehicle is required"); }
        
        }

      //delivery

      if (isset($_POST['deliver'])) {

        $db = mysqli_connect('localhost', 'root', '', 'registration');
      
        // receive all input values from the form
        $dname = $_POST['dname'];
        $company = $_POST['company'];
        $rname = $_POST['rname'];
        $apart_no = $_POST['apart_no'];
        $phone_no = $_POST['phone_no'];
        $date_time = $_POST['date_time'];
      
        
        $query = ("INSERT INTO delivery ( dname , company, rname, apart_no, phone_no, date_time) 
              VALUES('$dname', '$company', '$rname', '$apart_no','$phone_no','$date_time')");
        mysqli_query($db, $query);
      
        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($dname)) { array_push($errors, "name is required"); }
        if (empty($company)) { array_push($errors, "company is required"); }
        if (empty($rname)) { array_push($errors, "Resident name is required"); }
        if (empty($apart_no)) { array_push($errors, "apartement number is required"); }
        if (empty($phone_no)) { array_push($errors, "mobile number is required"); }
        
        }
      


        //visitors checkin 
      if (isset($_POST['checkin'])) {

        $db = mysqli_connect('localhost', 'root', '', 'registration');
      
        $vname = mysqli_real_escape_string($db, $_POST['vname']);
        $purpose = mysqli_real_escape_string($db, $_POST['purpose']);
        $person_to_visit = mysqli_real_escape_string($db, $_POST['person_to_visit']);
        $mob_no = mysqli_real_escape_string($db, $_POST['mob_no']);
        $apart_no = mysqli_real_escape_string($db, $_POST['apart_no']);
        $vehicle_no = mysqli_real_escape_string($db, $_POST['vehicle_no']);
        $date_time = mysqli_real_escape_string($db, $_POST['date_time']);
        // receive all input values from the form
        /*$vname = $_POST['vname'];
        $purpose= $_POST['purpose'];
        $person_to_visit = $_POST['person_to_visit'];
        $apart_no = $_POST['apart_no'];
        $mob_no = $_POST['mob_no'];
        $vehicle_no = $_POST['vehicle_no'];
        $date_time = $_POST['date_time'];*/
      
        
        $query = ("INSERT INTO visitorcheckin ( vname , purpose, person_to_visit, apart_no, mob_no, vehicle_no, date_time) 
              VALUES('$vname', '$purpose', '$person_to_visit', '$apart_no','$mob_no','$vehicle_no','$date_time')");
        mysqli_query($db, $query);
      
        // form validation: ensure that the form is correctly filled ...
        // by adding (array_push()) corresponding error unto $errors array
        if (empty($vname)) { array_push($errors, "Username is required"); }
        if (empty($purpose)) { array_push($errors, "purpose is required"); }
        if (empty($person_to_visit)) { array_push($errors, "person to visit is required"); }
        if (empty($apart_no)) { array_push($errors, "apartement number is required"); }
        if (empty($mob_no)) { array_push($errors, "mobile number is required"); }
        if (empty($vehicle_no)) { array_push($errors, "vehicle is required"); }
        
        }

//staff checkin
        if (isset($_POST['staffcheckin'])) {

          $db = mysqli_connect('localhost', 'root', '', 'registration');
          
        $sname = mysqli_real_escape_string($db, $_POST['sname']);
        $services = mysqli_real_escape_string($db, $_POST['services']);
        $mob_no = mysqli_real_escape_string($db, $_POST['mob_no']);
        $apart_no = mysqli_real_escape_string($db, $_POST['apart_no']);
        $date_time = mysqli_real_escape_string($db, $_POST['date_time']);

          // receive all input values from the form
          /*$sname = $_POST['sname'];
          $services= $_POST['services'];
          $apart_no = $_POST['apart_no'];
          $mob_no = $_POST['mob_no'];
          $date_time = $_POST['date_time'];*/
        
          
          $query = ("INSERT INTO staffcheckin ( sname , services, apart_no, mob_no, date_time) 
                VALUES('$sname', '$services', '$apart_no','$mob_no','$date_time')");
          mysqli_query($db, $query);
        
          // form validation: ensure that the form is correctly filled ...
          // by adding (array_push()) corresponding error unto $errors array
          if (empty($sname)) { array_push($errors, "Staff name is required"); }
          if (empty($services)) { array_push($errors, "Services is required"); }
          if (empty($apart_no)) { array_push($errors, "apartement number is required"); }
          if (empty($mob_no)) { array_push($errors, "mobile number is required"); }
          
          }
      


if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
   
  
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
  
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        $row=mysqli_fetch_array($results);
        $_SESSION['id']=$row['id'];
        $_SESSION['usertype']=$row['usertype'];
        $count=mysqli_num_rows($results);
        
        if ($count == 1) {
          if($row['usertype'] == "admin"){
          header('location: admin.html');
          }
          elseif($row['usertype'] == "gatekeeper"){
            
            $_SESSION['usertype'] = $row['usertype'];
            $_SESSION['success'] = "You are now logged in";
            header('location: Gate.html');
          }
          elseif($row['usertype'] == "resident"){
            $_SESSION['usertype'] = $row['usertype'];
            $_SESSION['success'] = "You are now logged in";
            header('location: Notifygate.php');
          }
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
  }
  
  ?>