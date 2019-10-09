<?php
session_start();
include("pdoInc.php");

// if(isset($_POST['login'])){
// 	echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
// }

// if (isset($_POST['logout'])) {
	
// 	echo"<meta http-equiv=REFRESH CONTENT=0;url=logout.php>";
// }
// if (isset($_POST['revise'])&&isset($_SESSION['account'])) {
// 	echo"<meta http-equiv=REFRESH CONTENT=0;url=revise.php>";
// }
if(isset($_POST['newBoard'])&&$_POST['newBoard']!=null &&$_POST['newBoard']!=''&&$_SESSION['admin']==1){
	
	$sql='INSERT INTO al_board(name) values(?)';
	$sth=$dbh->prepare($sql);
	$sth->execute(array($_POST['newBoard']));
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>LadingPage</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">	
	<link rel="stylesheet" type="text/css" href="topbar.css">
	<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
	<style>
		
		.newb{
			font-size:12px;
			height: 34px;
			line-height: 34px;
			right:40px;
			position: relative;

		}
		.newb input{
			margin:0;
			height: 20px;
			vertical-align:middle;
		}
		.newb input[type='search']{
			width: 150px;
		}
		.newb input[type='submit']{
			width: 70px;
			height:20px;
			-webkit-appearance:none;
			line-height: 0;
			padding: 0;
			background-color: black;
			border: 1px white solid;
			color: white;
			border-radius: 0rem;
			font-size: 12px;
			margin-left: 2px;

		}
		.newb{
			display: inline-block;
		}	
		
		.newb{
			margin-left: 10px;
		}
		.cardContent{

			max-width: 1000px;
			margin: 0 auto;
		}




		.card{
			
			font-size: 30px;
			line-height: 200px;
			text-align: center;
			border: 0;
			background-color: transparent;
			color:white;

		}
		.thumb{
			background:rgba(0,0,0,0.3);
			border-radius: .5rem;
		}

		li{
			position: relative;
			float: left;	
			width: 312px;
			height: 200px;	
			margin: 10px;
			
			
		}
		
		.b-img{
			border-radius: .5rem;
			-webkit-transition: 0.1s linear;
			width: 312px;
			height: 200px;	
			position: absolute;
			top: 0;
			background-size: cover;

		}
		
		.b-img:hover{
			-webkit-transform: scale(1.05);
		}

		
		
	</style>
</head>
<body>
	<div class="top">
		<div class="member">
			<form action="board.php" method="post" class='greet'>
				<?php
				if (!isset($_SESSION['account'])) {
					echo "<div class='acc'><span class=''>Hi, 訪客</span>";
					echo "<a href='login.php'>登入</a></div>";
				}
				else {
					echo "<div class='acc'><span class='tt'>Hi, ".$_SESSION['account']." (".$_SESSION['nickname'].")</span>";
					echo "<a href='logout.php' >登出</a> ";
					echo "<a href='revise.php' >修改帳號資料</a></div>";
					if ($_SESSION['admin']==1) {
						echo "<div class='newb'><ul class=' newBoard'><input type='text'name='newBoard' placeholder='新增酒類名稱'>";
						echo "<input type='submit'  value='確定新增' class='button'></ul></div>";
					}
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
	<!-- 分隔 -->
		
		<div class="content">
			<div class="cardContent">

        
<?php
    $sth = $dbh->query('SELECT * from al_board ORDER BY id');
    // $id= 1;
    while($row = $sth->fetch(PDO::FETCH_ASSOC)){
        
        echo '<li>
        <div class=\'b-img\' style=\'background-image:url(icon/'.$row['id'].'.jpg);\'>
        <div class=\'thumb\'>
	        <a href="viewBoard.php?id='.$row['id'].'&&kind=0">
	        
				<div class=\'card\'>'
				.$row['name'].
				'</div>
			
       		</a>
       		</div></div></li>';
        
    }
?>
<!-- <div style="background-image: url(icon/1.jpg);"> -->
		</div>
	</div>

</body>
</html>
