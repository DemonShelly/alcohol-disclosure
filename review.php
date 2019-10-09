<?php
session_start();
include("pdoInc.php");
$result='';

if(!isset($_SESSION['account'])){
	echo "請先登入進行操作";
	die ("<meta http-equiv=REFRESH CONTENT=0;url=login.php>");
}

if(isset($_GET['id'])&&isset($_POST['score'])&&isset($_POST['textreview'])){
	if (empty($_POST['score'])||trim($_POST['score']) == ''||empty($_POST['textreview'])||trim($_POST['textreview']) == ''){
		$result = '請確實填入內容';
	}
	else{
		$score = $_POST['score'];
		$textreview = $_POST['textreview'];
	
		if(preg_match('/^\d{1,2}$/', $score, $match)){
			$score = $match[0];
			if(preg_match('/^(\p{Han}|.|\r|\n){1,100}$/u', $textreview, $match)){
				$textreview = $match[0];
				$sql = "INSERT INTO al_review(i,productid,score,text_review,account,nickname) VALUES(?,?,?,?,?,?)";
				$sth = $dbh->prepare($sql);
				$sth->execute(array((int)$_GET['id'],(int)$_GET['productid'],$score,$textreview,$_SESSION['account'],$_SESSION['nickname']));
				echo"<meta http-equiv=REFRESH CONTENT=0;url=product.php?id=".$_GET['id']."&&productid=".$_GET['productid'].">";
			}
			else{
				$result='請輸入100字內的文字評論';
			}
		}
		else{
			$result ='請輸入正確的數字';
		}

	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Product</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">	
	<link rel="stylesheet" type="text/css" href="topbar.css">
	<script type="text/javascript" src="jquery-3.4.1.min.js"></script>
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
		text-align: right;
	}
	
	.textreview{
		margin-top: 20px;
		height: 250px;
		/*line-height: 250px;*/
	}
	.rowline textarea{
		width: 250px;
		height: 230px;
		line-height: 20px;
		border: 0;
		padding: 8px;

	}
	
	.sub input{
		text-align: center;
	    background-color: black;
	    color: white;
	    font-size: 20px;
	    border-radius: 2px;
	    width: 380px;
	    height: 50px;
	    margin-top: 20px;
	    /*margin-bottom: 5px;*/
	}
	
</style>
<body>
<div class="top">
		<div class="member">
			<form action="review.php" method="post" class='greet'>
				
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
			<form action="review.php?id=<?php echo(int)$_GET['id']?>&&productid=<?php echo (int)$_GET['productid']?>" method='post'>
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
				<div class='rowline'><div class='left'>酒名</div>
				<div class='right'><?php echo $name ?> </div></div>

				<div class='rowline'><div class='left'>評分</div>
				<div class='right'><input type="range" id='scoreRange' name="score" min="0" max="10" step="1" value="5"><span id='scoreShow'>5</span>/10分</div></div>

				<div class='rowline textreview'><div class='left'>文字評論</div>
				<div class='right'><textarea name="textreview" id="textreview" cols="30" rows="10" placeholder="用文字分享一下你對這款酒的感受吧！"></textarea></div></div>
				<div class="sub"><input type="submit" value="送出"></div>
				<div id="error"><?php echo$result; ?></div>
			</form>
		</div>
	

</body>
</html>
<script>
	$('#scoreRange').on('change',function(){
		$('#scoreShow').empty();
		$('#scoreShow').append($(this).val());
		// console.log($(this).val());
	})
</script>