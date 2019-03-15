<?php
require_once('functions.php');
require_once('connection.php');
session_start();


    $username = $_POST['username'];
    $password = $_POST['password'];
    
	$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);

	
	if($count == 1){
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        
        $username = $row['username'];
        $jwt = generateToken($username, 0, $conn);
        $existingToken = generateToken($username, 1, $conn);
        
        $_SESSION['username'] = $username;
        $_SESSION['jwt'] = $jwt;
        
        echo $jwt;
        echo $existingToken;
    }
    else{
        echo "Login failed";
    }
?>