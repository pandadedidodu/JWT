<?php

require_once('connection.php');
require_once('functions.php');

    function generateToken($username, $new, $conn){
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256',
            'dev' => 'Jackie Lee Escalante'
        ];
        $header = json_encode($header);
        $header = str_replace(['+','/','='],['-','_',''],base64_encode($header));

        $sql = "SELECT * FROM users WHERE username = '$username'";
		$result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);

        $payload = [
            'id' => $row['id'],
            'username' => $row['username']
        ];
        $payload = json_encode($payload);
        $payload = str_replace(['+','/','='],['-','_',''],base64_encode($payload));

        $signature = hash_hmac('sha256', $header.".".$payload, base64_encode('secretkey'), true);
        $signature = str_replace(['+','/','='],['-','_',''],base64_encode($signature));

        $jwt = "$header.$payload.$signature";
        return $jwt;
    }

    function validate($userToken){

        $jwt = $_SESSION['jwt'];    
        $username = $_SESSION['username'];

        function validateToken($username, $userToken, $conn){
            
            $existingToken = generateToken($username, 1, $conn);

            if($userToken===$existingToken){
                return 1;
            }else{
                return 0;
            }
        }
    }
?>