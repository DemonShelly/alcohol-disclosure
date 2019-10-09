<?php
session_start();
include("pdoInc.php");


?>



<!DOCTYPE html>
<html>
<head>
	<title>whisky</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="topbar.css">
	<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<style>
	body{
		text-decoration: none;
	}
	a{
		text-decoration: none;
	}
	.rightContent{
		/*max-width: 1260px;*/
	}
	.cards>li{
		position: relative;
		float: left;
		width: 140px;
		height: 290px;
		border-radius: .3em;
		border-color: grey;
		margin: 10px;
		padding: 10px;
		font-size: 16px;
		background-color: white;
		box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);
	}
	.img-s{
		position: relative;
		text-align: center;
		width: 118px;
		height: 150px;
		line-height: 150px;

	}
	
	.img-s img{
		/*margin: 0px auto;*/
		max-height: 150px;
		max-width: 118px;
	}
	.thumb {
		text-align: center;
	}
	.thumb .info{
		margin-top: 10px;

	}
	.thumb .num{
		margin-top: 8px;
		margin-bottom: 8px;
	}
	.thumb .view-price{
		font-size: 20px;
		font-weight: 700;
		color: #ff9933;
	}
	.thumb .view-ml{
		font-size: 10px;
	}
	.del{
		position:absolute;
        z-index: 50;
        top:0px;
        right: 0px;
        height: 20px;
        width: 20px;	
        background-size: cover;
        background-image: url('icon/del.svg');
	}


/*新增的*/
	.cardsrow{
		overflow: auto;
		margin:10px auto;
	}
	.more{
		text-align: center;
		position: relative;

	}
	.morebtn{
		background-color: black;
		color: white;
		font-size:14px;
		width: 100px;
		height: 50px;
		margin-top:0;
	}

	

</style>

<body>
	<div class="top">
		<div class="member">
			<form action="viewBoard.php" method="post" class='greet'>
				
				<?php
				if (!isset($_SESSION['account'])) {
					echo "<div class='acc'><span class='tt'>Hi, 訪客</span>";
					echo "<a href='login.php'>登入</a></div>";
				}
				else {
					echo "<div class='acc'><span>Hi, ".$_SESSION['account']." (".$_SESSION['nickname'].")</span>";
					echo "<a href='logout.php'>登出</a>";
					if($_SESSION['admin']==1){
						echo "<a href=\"new_al.php\">新增酒款</a>";
					}

					
				}		
				?>
				
				</div>
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
			<div class="leftBar">
				<ul class="category">

<!-- 左側欄 -->
<?php  


if (isset($_GET['id'])) {
	$sql = "SELECT * from al_category where type_id = ? ORDER BY id";
	$sth = $dbh->prepare($sql);
	$sth->execute(array((int)$_GET['id']));
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		echo '<li><a href=\'viewBoard.php?id='.$row['type_id'].'&&kind='.$row['id'].'\'>'.$row['cate_n']."</a></li> ";
	}
}
?>					

				</ul>
			</div>
<!-- 右側欄 -->
			<div class="rightContent">
				<div class="rank_bar">
					<form action="" method="post">
						<select name="ranking" id="ranking">
							<option value="def" id='d'>加入順序</option>
							<option value="price-asc">價格（由低到高）</option>
							<option value="price-desc">價格（由高到低）</option>
							<option value="ml-asc">容量（由少到多）</option>
							<option value="ml-desc">容量（由多到少）</option>
							<option value="density-asc">酒精濃度（由低到高）</option>
							<option value="density-desc">酒精濃度（由高到低）</option>
							<!-- <option value="avg()">酒精濃度（由高到低）</option> -->
						</select>
					</form>
				</div>
				<div class="cardsrow">
					<ul class="cards">
						
						<!-- <li> -->
<?php

if (isset($_GET['id'])&&isset($_GET['kind'])) {
	//select all products
	if($_GET['kind']==0){
		$sql = "SELECT * from al_list where i=? ORDER BY id limit 25";
		$sth = $dbh->prepare($sql);
		$sth->execute(array((int)$_GET['id']));
	}
	//select chosen products
	else{
	
		$sql = "SELECT * from al_list where i=? and kind=? ORDER BY id limit 25";
		$sth = $dbh->prepare($sql);
		$sth->execute(array((int)$_GET['id'],(int)$_GET['kind']));
	}
	
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		$name = mb_substr( $row['name'],0,13,"utf-8");
		$name.='...';
		
echo "<li>";
	if (isset($_SESSION['account'])) {
        	if($_SESSION['admin'] == 1){
				echo"<a class='del' href='del.php?id=".$_GET['id']."&&kind=".$_GET['kind']."&&productid=".$row['id']."'></a>";
			}};
echo	"<div class='thumb'>
			<a href='product.php?id=".$_GET['id']."&&productid=".$row['id']."' title='".$row['name']."'>
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
							
					</ul>
				</div>
				<div class="more">
					<input type="button" class="morebtn" value="載入更多">
				</div>
			</div>

		</div>
	
	</div>
</body>
</html>
<script>
	$(document).ready(function(){
		$('#d').click();
		
	});
	var least = 1;
	var rankway = 'def';
	$('#ranking').on('change',function(){

		rankway = $(this).val();
		$.post(
			"ajax_ranking.php",
			"id=" + <?php echo $_GET['id']?> + "&kind=" + <?php echo $_GET['kind']?> +"&rankway="+rankway
			).done(function(data){
				$('.cards').empty();//清空欄位
				$('.cards').append(data);
			
			})
	});

	$('.morebtn').on('click',function(){

		$.post(
			"ajax_loadingmore.php",
			"id=" + <?php echo $_GET['id']?> + "&kind=" + <?php echo $_GET['kind']?> +"&least="+25*least+"&rankway="+rankway
			).done(function(data){
				// $('.cards').empty();//清空欄位
				$('.cards').append(data);
			
			})
		least+=1;

	});
</script>