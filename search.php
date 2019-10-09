<?php
session_start();
include("pdoInc.php");


?>

<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">	
	<link rel="stylesheet" type="text/css" href="topbar.css">
	<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
</head>
<style type="text/css">
	.cards>li{
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
</style>
<body>
	<div class="top">
		<div class="member">
			<form action="search.php" method="post" class='greet'>
				
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
			<div class="cardsrow">
					<ul class="cards">
<?php
if(isset($_GET['q'])){
	$passThis = "%".$_GET['q']."%";
	$sql = "SELECT * FROM al_list WHERE name LIKE ?";
	$sth = $dbh->prepare($sql);
	$sth->bindParam(1,$passThis);
	$sth->execute();
	
	if($sth->rowCount() > 0){
		while($row = $sth->fetch(PDO::FETCH_ASSOC)){
			$name = mb_substr( $row['name'],0,13,"utf-8");
			$name.='...';
			echo "<li>
					<div class='thumb'>
						<a href='product.php?id=".$row['i']."&&productid=".$row['id']."' title='".$row['name']."'>
							<div class='img-s'>";
							if($row['id']>592){
                    		    echo"<img src=\"img/".$row['img']."\" alt=".$row['name'].">";
                    		}
                    		else{
                    			echo"<img src=\"img/".$row['img'].".jpg\" alt=".$row['name'].">";
                    		}	
							
			echo		"</div>
							<div class='info'>".$name."<br>
							<div class='num'>";
							if($row['price']==0){
                            	echo "<span class='view-price'>無資料</span><br>";}
                            else{echo "<span class='view-price'>".$row['price']."元</span><br>";}

							$ml = str_replace('ml','',$row['ml']);
                            $den = str_replace('%','',$row['density']);
                            echo"<span class='view-ml'>".$ml.'ml/'
                            	.$den."%</span></div></div>
						</a>
					</div>
				</li>";

		}}
	else{
		echo "查無結果";
	}
	
}
?>
</ul>
</div>
</div>
</div>
</body>
</html>