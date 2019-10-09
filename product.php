<?php
session_start();
include("pdoInc.php");

if (isset($_GET['q'])) {	
	echo "<meta http-equiv=REFRESH CONTENT=0;url=search.php?q=".$_GET['q'].">";
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

	.category{
		font-size: 12px;
		line-height: 40px;
	}
	.category>li{

	}
	.rightContent{
		width: 80%;
		position: relative;
		margin:10px;
		
	}
	.pd-info{
		display: flex;
		height:420px; 

	}
	
	.pd-img{
		flex:1;
		display: flex;
		justify-content: center;
  		align-items: center;
		margin: 10px;
		background-color: white;
		/*width: 800px; */
		flex-grow: 2;
		/*box-shadow: 0 1px 3px rgba(0,0,0,.12), 0 1px 2px rgba(0,0,0,.24);*/
	
	}
	.pd-img>img{
		max-width: 500px;
		max-height: 400px;
	}
	
	.pd-brief{
		position: relative;
		flex:1;
		display: flex;
		align-items:flex-end;
		flex-direction: column;
		/*background-color: lightgrey;*/
		margin: 10px;	
	}
	.pd-brief .title{
		font-size: 20px;
		font-weight: 400;
		text-align: right;
	}

	.pd-brief .price{
		font-size: 12px;
		font-weight: 100;
		text-align: right;
		margin: 30px 0;
		line-height: 25px;
	}
	.funcbtn{
		position:absolute;
		bottom:40px;
		margin:20px 0;
	}
	.funcbtn>button{
		background-color: white;
		padding: 15px;
		border: 1px rgb(224, 224, 224) solid;

	}
	.funcbtn>.review>a{
		color: white;
	}
	.funcbtn>.review{
		background-color: black;
		color: white;
	}
	.avg-score{
		position: absolute;
		bottom: 120px;
		font-size: 40px;
		font-weight: 200;
	}
	.re-right>.score{
		font-size: 50px;
		font-weight: 300 ;
	}
	.avg-score-tt{
		text-align: right;
		font-size: 13px;
	}
/*選擇地區*/
	.return-info{
		margin-top:10px;
		margin-bottom:20px;
		height:  auto;
		min-height: 300px;

	}
	
	.return-bar input[type='button']{
		font-size: 14px;
		border-style: none;
		min-width:90px; 
		height: 30px;
		width: 100px;
		background-color: transparent;
		border:1px lightgrey solid;
	}

	
	.ch-review{
		background-color: black;
		/*color: white;*/
	}

/*報價區*/
	.re-item{
		background-color: white;
		box-shadow: 0 1px 3px rgba(0,0,0,.12);
		/*border-radius: 16px; */
		margin-top: 5px;
		padding: 20px;
		min-height: 100px;
		display: flex;
		justify-content: space-between;
		/*padding-top:10px;*/
	}
	.re-right{
		text-align: right;

	}
	.re-left>div{
		margin: 10px;
	}
	.re-title{
		font-size: 20px;
		font-weight: 400;

	}
	.re-add{
		font-size: 12px;
		font-weight: 100;
		margin-top: -3px;
	}
	.re-note{
		font-size: 13px;
		font-weight: 350;
		margin-bottom: 0; 
	}
	.perml{
		font-size: 50px;
		font-weight: 300 ;

	}
	.perml>span{
		font-size: 12px;
	}
	.ch-review{
		position: absolute;
		right: 0;
		/*background-color: lightcoral;*/
	}
	/*圖片區*/
	
	.re-img img{
		max-width: 100px;
		max-height: 75px;
	}
	.re-img img:hover{
		max-width: 440px;
		max-height: 330px;

	}
	/*評分區*/
	.rev{
		height: 100px;
	}

	
	.thin,.total{
		font-size: 15px;
		font-weight: 300;
	}
	.re-rank{
		margin:5px;
	}
	
	.re-acc>.name{
		font-size: 12px;
		font-weight: 200;
		position: relative;
		vertical-align: middle;
	}
	.timesta{
		margin-left: 50px;
		font-size: 8px;
		vertical-align: bottom;
	}
	.re-text,.score{
		line-height: 1.15;

	}
	.userhead{
		display: inline-block;
		vertical-align: middle;
        z-index: 50;
        top:0px;
        right: 0px;
        height: 10px;
        width: 10px;
        margin-right: 5px;	
        background-size: cover;
        background-image: url('icon/user.svg');
	}
	.re-text{
		line-height: 1.5;
		font-size: 14px;
	}
	.title-bar{
		/*line-height: 30px;*/
	}
	.re-title{
		display: inline-block;
	}
	.re-acc-float{
		margin-left: 20px;
		display: inline-block;
		height: 30px;
		vertical-align: middle;
	}
</style>
<body>
	<div class="top">
		<div class="member">
			<form action="product.php" method="post" class='greet'>
				
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

				<div class="pd-info">
<?php
if (isset($_GET['id'])&&isset($_GET['productid'])) {
	$sql = "SELECT * from al_list where id=? and i=?";
	$sth = $dbh->prepare($sql);
	$sth->execute(array(
		(int)$_GET['productid'],
		(int)$_GET['id']
	));
	while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		echo "<div class=\"pd-img item\">";
		if($row['id']>592){
		    echo"<img src=\"img/".$row['img']."\" alt=".$row['name'].">";
		}
		else{
			echo"<img src=\"img/".$row['img'].".jpg\" alt=".$row['name'].">";
		}
		echo	"</div>
				<div class=\"pd-brief item\">
					<div class=\"title\">
						<span>".$row['name']."</span>
					</div>
					<div class=\"price\">建議售價&nbsp;&nbsp;";
					if($row['price']==0){echo"無資料";}
					else{echo $row['price']."元";}
		echo				
					
					"<br>容量&nbsp;&nbsp;";
				$ml = str_replace('ml','',$row['ml']);
				$den = str_replace('%','',$row['density']);
		echo		$ml."ml
					<br>酒精濃度&nbsp;&nbsp;".
					$den."%
					</div>"
				;
	}
}
	
?>
			<div class="funcbtn">
				<button class="return">
					<a href="return.php?id=<?php echo(int)$_GET['id']?>&&productid=<?php echo (int)$_GET['productid']?>" class="return">
							回報價格
					</a>
				</button>
				<button class="review">
					<a href="review.php?id=<?php echo(int)$_GET['id']?>&&productid=<?php echo (int)$_GET['productid']?>" class="review">
							給予評價
					</a>
				</button>
			</div>
				<div class="avg-score">
					<div class="avg-score-tt">平均評價分數</div>
		<?php
		if (isset($_GET['id'])&&isset($_GET['productid'])){
			$sql = "SELECT AVG(score)as avg from al_review where productid = ?";
			$sth = $dbh->prepare($sql);
			$sth->execute(array($_GET['productid']));
			while($row = $sth->fetch(PDO::FETCH_ASSOC)){
				if(round($row['avg'],1)==0){echo"暫無評價";}
				else{echo round($row['avg'],1).'分';}
			}

		}

		?>
				</div>
			</div>
			</div>
			<div class="return-info">
				<div class="return-bar">
					<div class="returnBut">
						<input type="button" value="全部地區" class='sel-reg' id='all' >
						<input type="button" value="北部" class='sel-reg' id='north' >
						<input type="button" value="中部" class='sel-reg' id='central'>
						<input type="button" value="南部" class='sel-reg' id='south' >
						<input type="button" value="東部" class='sel-reg' id='eastern'>
						<input type="button" value="外島地區" class='sel-reg' id='outland'>
					<!-- 顯示評價 -->
						<input type="button" value="查看評價" class="ch-review">
					</div>
					<div class="re-rank">
						<form action="" class="rankForm" method="post">
						<select name="ranking" id="ranking">
							<option value="def" id='d'>加入順序</option>
							<option value="avg price-asc">平均價格（由低到高）</option>
							<option value="avg price-desc">平均價格（由高到低）</option>
							<option value="price-asc">總價格（由低到高）</option>
							<option value="price-desc">總價格（由高到低）</option>
							<option value="ml-asc">總容量（由少到多）</option>
							<option value="ml-desc">總容量（由多到少）</option>
						</select>
					</form>
					</div>
				
				</div>
				<div class="return-con">
					
				</div>

			</div>
		

		</div>
	</div>
</body>
</html>
<script type="text/javascript">
	
	var lastRegion = '';
	$(document).ready(function(){
		$('#all').click();
	});	

	//地區ajax
	$('.sel-reg').on('click',function(){

		var regionid = $(this).val();
		lastRegion = regionid;
		$.post(
			"ajax_showreturn.php",
			"al-id=" + <?php echo $_GET['productid']?> + "&region=" + regionid
			).done(function(data){
				$('.return-con').empty();//清空欄位
				if(data =='No data'){
					$('.return-con').append("目前沒有資料");
				}
				else{
					$('.return-con').append(data);
					// console.log(lastRegion);
			
				}
		});
	});
	
	//查看評論ajax
	$('.ch-review').on('click',function(){
		$.post(
			"ajax_showreview.php",{
				"productid":<?php echo $_GET['productid']?>
			}
		).done(function(data){
			$('.return-con').empty();
			if(data =="No Data"){
					$('.return-con').append("目前沒有評價");
				}
				else{
					$('.return-con').append(data);
			
				}
		})

	})
	//地區排序ajax

	$('#ranking').on('change',function(){

		var rankway = $(this).val();

		$.post(
			"ajax_review_ranking.php",{
				'al-id':<?php echo $_GET['productid']?>,
				'region':lastRegion,
				'rankway':rankway
			}
			
			).done(function(data){
				// console.log(data);
				$('.return-con').empty();
				if(data =="No Data"){
					$('.return-con').append("目前沒有資料");
				}
				else{
					$('.return-con').append(data);
			
				}
			
			})
	});


	
			
			
</script>