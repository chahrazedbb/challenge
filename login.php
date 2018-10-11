<?php

session_start();
 
require 'password.php';
 
require 'conn.php';
 
 
if(isset($_POST['login'])){
    

    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $passwordAttempt = !empty($_POST['password']) ? trim($_POST['password']) : null;
    
 
    $sql = "SELECT id, email, password FROM member WHERE email = :email";

    $stmt = $conn->prepare($sql);
    
   
    $stmt->bindValue(':email', $email);
    

    $stmt->execute();
    

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user === false){
      
      die('Incorrect email / password combination!');
    } else{
         
         $validPassword = password_verify($passwordAttempt, $user['password']);
        
        if($validPassword){
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();
         
             header('Location: challenge.php');
            exit;
            
        } else{
        
            die('Incorrect email / password combination!');
        }
    }  
}
elseif  (isset($_POST['register'])){
    

    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;

    $sql = "SELECT COUNT(email) AS num FROM member WHERE email = :email";
    $stmt = $conn->prepare($sql);
    
     $stmt->bindValue(':email', $email);
    
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
   if($row['num'] > 0){
        die('That email already exists!');
    }
   $passwordHash = password_hash($pass, PASSWORD_BCRYPT, array("cost" => 12));
    
    $sql = "INSERT INTO member (email, password) VALUES (:email, :password)";
    $stmt = $conn->prepare($sql);
  
   $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $passwordHash);
 
   $result = $stmt->execute();
    
    if($result){
        echo 'Thank you for registering with our website.';
    }   
}
 
?>
<html>
<head>
  <title></title>
  <style type="text/css">
    body{
      background-color:  #f2f2f2;
    }
    form {
      background-color: white;
      box-sizing: border-box;
      box-shadow: 2px 2px 5px 1px rgba(0, 0, 0, 0.2);
      width: 600px;
      margin: 100px auto 0;
      padding-bottom: 100px;
    }
    input {
      margin: 40px 25px;
      width: 500px;
      display: block;
      border: none;
      padding: 10px 0;
      border-bottom: solid 1px ;
      font-size: 20px;
    }
      button {
      border: none;
      cursor: pointer;
      padding: 30px;
      width: 300px;
      margin: 20px auto 0;
      font-size: 20px;
    }
    h1 {
      padding: 30px;
    }
    </style>
</head>
<body>
  <form action="" method='post'>
  <h1>Login</h1>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type='submit' name="register" style="  background: #d9d9d9; float: left;">REGISTER</button>
  <button type='submit' name="login" style=" background: black; color: white; float: right;">LOGIN</button>
  </form>
</body>
</html>