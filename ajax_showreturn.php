<?php
include("pdoInc.php");

if (isset($_POST['al-id'])&&isset($_POST['region'])) {	
	$region = $_POST['region'];
	if($region =='全部地區'){
		$sql = "SELECT * from al_return where al_id =?";
	}
	else if($region == '北部'){
		$sql = "SELECT * from al_return where al_id =? and region in ('台北市','新北市','基隆市','桃園市','宜蘭縣','新竹縣','新竹市')";
	}
	else if($region =='中部'){
		$sql = "SELECT * from al_return where al_id =? and region in ('苗栗縣','台中市','彰化縣','南投縣','雲林縣')";
	}
	else if($region =='南部'){
		$sql = "SELECT * from al_return where al_id =? and region in ('嘉義縣','嘉義市','台南市','高雄市','屏東縣','澎湖縣')";
	}
	else if($region =='東部'){
		$sql = "SELECT * from al_return where al_id =? and region in ('花蓮縣','台東縣')";
	}
	else if($region =='外島地區'){
		$sql = "SELECT * from al_return where al_id =? and region in ('金門縣','連江縣')";
	}
	$sth = $dbh->prepare($sql);
	$sth -> execute(array((int)$_POST['al-id']));
	if($sth->rowCount() > 0){
		while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				$account = htmlspecialchars($row['account']);
				$nickname = htmlspecialchars($row['nickname']);
				$time = $row['time'];
				$add_name = htmlspecialchars($row['add_name']);
				$region = htmlspecialchars($row['region']);
				$address = htmlspecialchars($row['address']);
				$note = htmlspecialchars($row['note']);
				$perml = round($row['price']/$row['ml'],2);
				$img_r='re_img/'.$row['img'];
				echo"<div class='re-item'>
						<div class='re-left'>
							<div class='shop'>
								<div class=title-bar> <div class='re-title'>".$add_name."</div>
								<div class='re-acc-float'><div class='userhead'></div><span class='name'>".$account."(".$nickname.")</span><span class='timesta'>".$time."</span></div></div>
								<div class='re-add'>".$region.$address."</div>
							</div>
							<div class='re-note'>".$note."</div>";
						if($row['img']!=''){
							echo"<div class='re-img'>
								<a href>
									<img src=".$img_r.">
								</a>
								</div>";
							}
						echo"</div>
						
						<div class='re-right'>
							<div class='perml'>".$perml."<span class='thin'>元/ml</span></div>
							<div class='total'>".$row['price']."元/".$row['ml']."ml</div>
						</div>
					</div>
			";
		}
	}
	

	else{
		echo 'No data';
	}
}


?>