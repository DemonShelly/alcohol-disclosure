<?php
session_start();
include("pdoInc.php");
$result='';
$resultStr='';
$whiteList = array('image/jpeg','image/png','image/gif');
$newDir = "./re_img/";

if(!isset($_SESSION['account'])){
	echo "請先登入進行操作";
	die ("<meta http-equiv=REFRESH CONTENT=0;url=login.php>");
}

else if (isset($_POST['price'])&&isset($_POST['ml'])&&isset($_POST['region'])&&isset($_POST['add_name'])&&isset($_POST['address'])&&isset($_POST['note'])) {
	if (empty($_POST['price'])||trim($_POST['price']) == ''||empty($_POST['ml'])||trim($_POST['ml']) == ''||empty($_POST['region'])||trim($_POST['region']) == ''||empty($_POST['add_name'])||trim($_POST['add_name']) == ''||empty($_POST['address'])||trim($_POST['address']) == '') {
		$result = "請確實填入內容";
	}
	 
	else{
		$price=$_POST['price'];
		$ml = $_POST['ml'];
		$region = $_POST['region'];
		$add_name = $_POST['add_name'];
		$address = $_POST['address'];
		$note = $_POST['note'];
		
		if(preg_match('/^\d+$/', $price, $match)){
			$price = $match[0];
			if(preg_match('/^\d+$/', $ml, $match)){
				$ml = $match[0];
				if(preg_match('/^[\p{Han}]{3}$/u', $region, $match)){
					$region = $match[0];
					if(preg_match('/^(\p{Han}|.|\r|\n){1,30}$/u', $add_name, $match)){
						$add_name = $match[0];
						if(preg_match('/^[\p{Han}\w]+$/u', $address, $match)){
							$address = $match[0];
							if(preg_match('/^(\p{Han}|.|\r|\n){0,30}$/u', $note, $match)){
								$note = $match[0];
								$imgname='';

								//如果有上傳圖片 處理過程
								if(isset($_FILES["re-img"]) && $_FILES["re-img"]["name"]!=NULL){
									$extension = @strtolower(end(explode('.', $_FILES["re-img"]["name"])));
									if(in_array($_FILES["re-img"]["type"], $whiteList) && $_FILES["re-img"]["size"] <= 1024 * 1024){
								        $resultStr = "Submit file OK.";
								        $imgname = time().".".$extension;
								        // echo $imgname;
								        move_uploaded_file($_FILES["re-img"]["tmp_name"], $newDir.$imgname);
								    }
								    else if(!in_array($extension, $whiteList)){
										$result = '請上傳符合格式的檔案';
									}
									else if($_FILES["al-img"]["size"] > 1024 * 1024){
								        $result = "檔案太大";
								    }	
								}	
								//塞資料進資料庫
								// echo (int)$_GET['productid'].'<br>'.
								// 	$price.'<br>'.
								// 	$ml.'<br>'.
								// 	$region.'<br>'.
								// 	$add_name.'<br>'.
								// 	$address.'<br>'.
								// 	$note.'<br>'.
								// 	$imgname.'<br>'.
								// 	$_SESSION['account'].'<br>'.
								// 	$_SESSION['nickname'];


								$sql = "INSERT INTO al_return(al_id,price,ml,region,add_name,address,note,img,account,nickname) VALUES(?,?,?,?,?,?,?,?,?,?)";
								$sth = $dbh->prepare($sql);
								$sth -> execute(array(
									(int)$_GET['productid'],
									$price,
									$ml,
									$region,
									$add_name,
									$address,
									$note,
									$imgname,
									$_SESSION['account'],
									$_SESSION['nickname']
								));
								echo"<meta http-equiv=REFRESH CONTENT=0;url=product.php?id=".$_GET['id']."&&productid=".$_GET['productid'].">";
							}
							else{
								$result = '請勿輸入超過三十字的備註';
							}	
							
						}
						else{
							$result = '請輸入有效的地址';
						}
					}
					else{
						$result = '請輸入有效的販售地';
					}
				}
				else{
					$result = '請輸入有效的地區';
				}
			}
			else{
				$result = '請輸入有效的容量';
			}
		}
		else{
			$result = '請輸入有效的價錢';
		}
				
}}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Return</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="topbar.css">
</head>
<style>
	.content{
		font-size: 15px;
		/*background-color: white;*/
		max-width: 400px;
		margin:140px auto;
		display: flex;
		flex-wrap: wrap;
		height:500px;
	}
	
	#error{
		color: red;
		text-align: center;
	}
	.content form{
		width: 400px;
		padding: 20px;
		/*text-align: center;*/
	}
	.rowline{
		position: relative;
		width: 100%;
		height: 50px;
		line-height: 50px;
		vertical-align: middle;
	}
	.left{
		position: absolute;
		left: 0;
		font-weight: 500;
	}
	.right{
		vertical-align: middle;
		position: absolute;
		right: 0;
		width: 250px;
		height: 50px;
	}
	
	.textreview{
		margin: 20px 0;
		height: 60px;
		/*line-height: 250px;*/
	}
	.rowline textarea{
		width: 250px;
		height: 60px;
		line-height: 20px;
		border: 0;
		padding: 8px;

	}
	.upload input[type='file']{
		margin:0;
		height: 60px;
		line-height: 30px;
	}
	input[type='text'],select{
		/*text-align: right;*/
		padding: 8px;
		font-size: 15px;
		border-radius: 2px;
		background-color: white;
		width: 250px;
		height: 33px;
		margin-bottom: 8px;
		border-style: none;

	}
	
	
	.sub input{
		text-align: center;
	    background-color: black;
	    color: white;
	    font-size: 20px;
	    border-radius: 2px;
	    width: 370px;
	    height: 50px;
	    margin-top: 20px;
	    /*margin-bottom: 5px;*/
	}
</style>
<body>
	<div class="top">
		<div class="member">
			<form action="return.php" method="post" class='greet'>
				
				<?php
				if (!isset($_SESSION['account'])) {
					echo "<div class='acc'><span class='tt'>Hi, 訪客</span>";
					echo "<a href='login.php'>登入</a></div>";
				}
				else {
					echo "<div class='acc'><span>Hi, ".$_SESSION['account']." (".$_SESSION['nickname'].")</span>";
					echo "<a href='logout.php'>登出</a></div> ";

					
				}		
				?>
				
				
			</form>
		</div>

		<div class="top-right">
				<ul>
					<div class="search">
						<form action="search.php" method="get">
							<input type="search" name='q'>
							<input type="submit" value="搜尋">
						</form>	
					</div>
				</ul>
		</div>
	</div>
	<div class="header">
		<div class="bartt">
			<a href="board.php">
				<span class="banner">酒4要公開</span>
			</a>
		</div>		
	</div>
		
		<div class="content">
			<form action="return.php?id=<?php echo(int)$_GET['id']?>&&productid=<?php echo (int)$_GET['productid']?>" method='post'enctype="multipart/form-data">
				<?php 
				if (isset($_GET['productid'])) {
					$sql = "SELECT name from al_list where id = ?";
					$sth = $dbh->prepare($sql);
					$sth -> execute(array((int)$_GET['productid']));
					while($row = $sth->fetch(PDO::FETCH_ASSOC)){
						$name = $row['name'];
					}
				}
				?>
				<div class='rowline'><div class='left'>酒名</div><div class="right"><?php echo $name ?></div></div>
				<div class='rowline'><div class='left'>價錢</div><div class="right"><input name ='price'type="text" placeholder="請輸入數字"></div></div>
				<div class='rowline'><div class='left'>容量</div><div class="right"><input name = 'ml' type="text" placeholder="請以豪升為單位"></div></div>
				<div class='rowline'><div class='left'>地區</div><div class="right"><select name="region" class="region">
					<option value="基隆市">基隆市</option>
					<option value="台北市">台北市</option>
					<option value="新北市">新北市</option>
					<option value="桃園市">桃園市</option>
					<option value="新竹市">新竹市</option>
					<option value="新竹縣">新竹縣</option>
					<option value="苗栗縣">苗栗縣</option>
					<option value="台中市">台中市</option>
					<option value="彰化縣">彰化縣</option>
					<option value="南投縣">南投縣</option>
					<option value="雲林縣">雲林縣</option>
					<option value="嘉義市">嘉義市</option>
					<option value="嘉義縣">嘉義縣</option>
					<option value="台南市">台南市</option>
					<option value="高雄市">高雄市</option>
					<option value="屏東縣">屏東縣</option>
					<option value="宜蘭縣">宜蘭縣</option>
					<option value="花蓮縣">花蓮縣</option>
					<option value="台東縣">台東縣</option>
					<option value="澎湖縣">澎湖縣</option>
					<option value="澎湖縣">金門縣</option>
					<option value="澎湖縣">連江縣</option>
				</select></div></div>
				<div class='rowline'><div class='left'>販售地</div>
				<div class="right"><input name='add_name'type="text" placeholder="請輸入販售店名"></div></div>
				<div class='rowline'><div class='left'>地址</div>
				<div class="right"><input name='address' type="text"placeholder="請輸入販售地址"></div></div>
				<div class='rowline textreview'><div class='left'>備註</div>
				<div class="right"><textarea name="note" id="" placeholder="可以輸入30字內的備註"></textarea></div></div>

				<div class='rowline upload'><div class='left'>上傳照片</div><div class="right"><input type="file" name='re-img'></div></div>
				<div class="sub"><input type="submit" name="submit" value="送出"></div>
				<div id="error"><?php echo$result; ?></div>
			</form>
		</div>
	
</body>
</html>