<?php
session_start();
include("pdoInc.php");

if(isset($_GET['productid'])&&isset($_GET['kind'])&&isset($_GET['id'])&&isset($_SESSION['account'])){
	if($_SESSION['admin']== 1){
		$sql ="DELETE FROM al_list where id=? ";
		$sth = $dbh->prepare($sql);
		$sth->execute(array($_GET['productid']));
		echo '<meta http-equiv=REFRESH CONTENT=0;url=viewBoard.php?id='.$_GET['id'].'&&kind='.$_GET['kind'].'>';
	}
	else{
		
		echo '你沒有權限進行操作';
		die('<meta http-equiv=REFRESH CONTENT=0;url=viewBoard.php?id='.$_GET['id'].'&&kind='.$_GET['kind'].'>');
	}
	
}
else{
	echo '你沒有權限進行操作';
	die('<meta http-equiv=REFRESH CONTENT=0;url=login.php>');


}

?>