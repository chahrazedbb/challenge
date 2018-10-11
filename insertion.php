<?php
	require 'conn.php';


	$idm = $_POST['idm'];
	$what = $_POST['what'];
	$how = $_POST['how'];
	$when = $_POST['when'];
	$duration = $_POST["duration"];
	$sql = "INSERT INTO idea (what_about, how_it_works, when_it_works,member_id,duration)
    VALUES ('$what', '$how', '$when','$idm','$duration')";
    
    $result = $conn->exec($sql); 
    
    if($result){
    header('location:challenge.php');
		}
	
?>