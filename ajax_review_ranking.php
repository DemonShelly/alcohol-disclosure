<?php
include("pdoInc.php");

if (isset($_POST['region'])&&isset($_POST['rankway'])&&isset($_POST['al-id'])) {
	$region=$_POST['region'];
	$rankway=$_POST['rankway'];
	$newrank = str_replace('-', ' ', $rankway);
	$chk = (strstr($newrank,'avg')==true);
	// echo $chk;
	if($newrank == 'def'){
		if($region =='全部地區'){
			$sql = "SELECT * from al_return where al_id =? ORDER BY time";
		}
		else if($region == '北部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('台北市','新北市','基隆市','桃園市','宜蘭縣','新竹縣','新竹市') ORDER BY time";
		}
		else if($region =='中部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('苗栗縣','台中市','彰化縣','南投縣','雲林縣')ORDER BY time";
		}
		else if($region =='南部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('嘉義縣','嘉義市','台南市','高雄市','屏東縣','澎湖縣')ORDER BY time";
		}
		else if($region =='東部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('花蓮縣','台東縣')ORDER BY time";
		}
		else if($region =='外島地區'){
			$sql = "SELECT * from al_return where al_id =? and region in ('金門縣','連江縣')ORDER BY time";
		}
	}

	else if($chk != 1){
		// echo "not avg";
		if($region =='全部地區'){
			$sql = "SELECT * from al_return where al_id =? ORDER BY $newrank";
		}
		else if($region == '北部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('台北市','新北市','基隆市','桃園市','宜蘭縣','新竹縣','新竹市') ORDER BY $newrank";
		}
		else if($region =='中部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('苗栗縣','台中市','彰化縣','南投縣','雲林縣')ORDER BY $newrank";
		}
		else if($region =='南部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('嘉義縣','嘉義市','台南市','高雄市','屏東縣','澎湖縣')ORDER BY $newrank";
		}
		else if($region =='東部'){
			$sql = "SELECT * from al_return where al_id =? and region in ('花蓮縣','台東縣')ORDER BY $newrank";
		}
		else if($region =='外島地區'){
			$sql = "SELECT * from al_return where al_id =? and region in ('金門縣','連江縣')ORDER BY $newrank";
		}
		
	}
	else if($chk==1){

		$newrank = str_replace('avg price', '', $newrank);
		
		if($region =='全部地區'){
			$sql = "SELECT *,price/ml as avg from al_return where al_id =? ORDER BY avg $newrank";
			}
			else if($region == '北部'){
				$sql = "SELECT *,price/ml as avg from al_return where al_id =? and region in ('台北市','新北市','基隆市','桃園市','宜蘭縣','新竹縣','新竹市') ORDER BY avg $newrank";
			}
			else if($region =='中部'){
				$sql = "SELECT * from al_return where al_id =? and region in ('苗栗縣','台中市','彰化縣','南投縣','雲林縣')ORDER BY avg $newrank";
			}
			else if($region =='南部'){
				$sql = "SELECT * from al_return where al_id =? and region in ('嘉義縣','嘉義市','台南市','高雄市','屏東縣','澎湖縣')ORDER BY avg $newrank";
			}
			else if($region =='東部'){
				$sql = "SELECT * from al_return where al_id =? and region in ('花蓮縣','台東縣')ORDER BY avg $newrank";
			}
			else if($region =='外島地區'){
				$sql = "SELECT * from al_return where al_id =? and region in ('金門縣','連江縣')ORDER BY avg $newrank";
			}
	}
	$sth = $dbh->prepare($sql);
	$sth -> execute(array((int)$_POST['al-id']));
	if($sth->rowCount() > 0){
		while($row = $sth->fetch(PDO::FETCH_ASSOC)){
			
				$add_name = htmlspecialchars($row['add_name']);
				$region = htmlspecialchars($row['region']);
				$address = htmlspecialchars($row['address']);
				$note = htmlspecialchars($row['note']);
				$perml = round($row['price']/$row['ml'],2);
				$img_r='re_img/'.$row['img'];
				echo"<div class='re-item'>
						<div class='re-left'>
							<div class='shop'>
								<div class='re-title'>".$add_name."</div>
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
		echo 'No Data';
	}


}

?>
