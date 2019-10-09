<?php
include("pdoInc.php");

if(isset($_POST['productid'])){
	$sql = "SELECT * from al_review  where productid = ?";
	$sth = $dbh->prepare($sql);
	$sth ->execute(array((int)$_POST['productid']));
	if($sth->rowCount() > 0){
		
		while($row = $sth->fetch(PDO::FETCH_ASSOC)){
			$account=htmlspecialchars($row['account']);
			$nickname=htmlspecialchars($row['nickname']);
			$time=htmlspecialchars($row['time']);
			$text_review=htmlspecialchars($row['text_review']);
			$score=htmlspecialchars($row['score']);
			echo"<div class='re-item rev'>
						<div class='re-left'>
							<div class='re-acc'><div class='userhead'></div><span class='name'>".$account."(".$nickname.")</span><span class='timesta'>".$time."</span></div>
							<div class='re-text'>".$text_review."</div>
						</div>
						<div class='re-right'>
							<div class='score'>".$score."分</div>
						</div>
					</div>
			";
			
			
		}


	}
	else{
		echo "No Data";
	}


}
?>