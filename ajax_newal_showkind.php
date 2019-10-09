<?php
session_start();
include("pdoInc.php");

if(isset($_POST['al_id'])){
	// echo $_POST['al_id'];
	$sql = "SELECT * FROM al_category where type_id=?";
	$sth = $dbh->prepare($sql);
    $sth->execute(array($_POST['al_id']));
    while($row = $sth->fetch(PDO::FETCH_ASSOC)){
    	echo "<option>".$row['cate_n']."</option>";
    }

	

}


?>