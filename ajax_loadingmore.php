<?php
session_start();
include("pdoInc.php");

if(isset($_POST['id'])&&isset($_POST['kind'])&&isset($_POST['least'])&&isset($_POST['rankway'])){

	$least = $_POST['least'];
	$rankway = $_POST['rankway'];
	$newrank = str_replace('-', ' ', $rankway);

	
	if($_POST['kind']==0){
		if($newrank == 'def'){
			$sql = "SELECT * from al_list where i=? ORDER BY id limit 25 OFFSET $least";
		}
		else{
			$sql = "SELECT * from al_list where i=? ORDER BY $newrank limit 25 OFFSET $least";
		}
		$sth = $dbh->prepare($sql);
		$sth->execute(array((int)$_POST['id']));
	}
	else{
		if($newrank == 'def'){
			$sql = "SELECT * from al_list where i=? and kind=? ORDER BY id limit 25 OFFSET $least";
		}
		else{
			$sql = "SELECT * from al_list where i=? and kind=? ORDER BY $newrank limit 25 OFFSET $least";
		}
		$sth = $dbh->prepare($sql);
		$sth->execute(array((int)$_POST['id'],(int)$_POST['kind']));
	}
	
	
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		$name = mb_substr( $row['name'],0,13,"utf-8");
		$name.='...';
		
		echo "<li>";
			if (isset($_SESSION['account'])) {
		        	if($_SESSION['admin'] == 1){
						echo"<a class='del' href='del.php?id=".$_POST['id']."&&kind=".$_POST['kind']."&&productid=".$row['id']."'></a>";
					}};
		echo	"<div class='thumb'>
					<a href='product.php?id=".$_POST['id']."&&productid=".$row['id']."' title='".$row['name']."'>
						<div class='img-s'>";
if($row['id']>592){
		    echo"<img src=\"img/".$row['img']."\" alt=".$row['name'].">";
		}
		else{
			echo"<img src=\"img/".$row['img'].".jpg\" alt=".$row['name'].">";
		}	
echo					
			"</div>
				<div class='info'>".$name."<br>
				<div class='num'>";
if($row['price']==0){
	echo "<span class='view-price'>無資料</span><br>";}
else{echo "<span class='view-price'>".$row['price']."元</span><br>";}
$ml = str_replace('ml','',$row['ml']);
$den = str_replace('%','',$row['density']);
echo"				<span class='view-ml'>".$ml.'ml/'
				.$den."%</span></div></div>
					</a>
				</div>
			</li>";
	}
}

	




?>