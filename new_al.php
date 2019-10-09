<?php
session_start();
include("pdoInc.php");
$whiteList = array('image/jpeg','image/png','image/gif');
$newDir = "./img/";
$result = '';
$resultStr = '';

if(!isset($_SESSION['account'])||$_SESSION['admin']!=1){
	echo "你沒有權限進行此操作";
	die ("<meta http-equiv=REFRESH CONTENT=0;url=login.php>");
}

else if(isset($_POST['name'])&&isset($_POST['id'])&&isset($_POST['kind'])&&isset($_POST['brand'])&&isset($_POST['area'])&&isset($_POST['ml'])&&isset($_POST['den'])&&isset($_POST['price'])&&isset($_FILES["al-img"]) && $_FILES["al-img"]["name"]!=NULL){
	// echo $_POST['id'].$_POST['kind'];
			if (empty($_POST['name'])||trim($_POST['name']) == ''||
				empty($_POST['id'])||trim($_POST['id']) == ''||
				empty($_POST['kind'])||trim($_POST['kind']) == ''||
				empty($_POST['brand'])||trim($_POST['brand']) == ''||
				empty($_POST['area'])||trim($_POST['area']) == ''||	
				empty($_POST['ml'])||trim($_POST['ml']) == ''||
				empty($_POST['den'])||trim($_POST['den']) == ''||	
				empty($_POST['price'])||trim($_POST['price']) == ''){
				$resultStr = '請確實填入內容';
			}
			else{
				//圖片上傳處理
				$extension = @strtolower(end(explode('.', $_FILES["al-img"]["name"])));
				 if(in_array($_FILES["al-img"]["type"], $whiteList) && $_FILES["al-img"]["size"] <= 1024 * 1024){
			        $result = "Submit file OK.";
			        $imgname = time().".".$extension;
			        move_uploaded_file($_FILES["al-img"]["tmp_name"], $newDir.$imgname);
			        

			        // 找出合適選單
			        $sql="SELECT al_board.id ,al_category.id as kind from al_board 
						inner JOIN al_category on al_board.id=al_category.type_id
						where al_board.name=? and al_category.cate_n=?";
					$sth=$dbh->prepare($sql);
					$sth->execute(array($_POST['id'],$_POST['kind']));
					while($row = $sth->fetch(PDO::FETCH_ASSOC)){
						$id=$row['id'];
						$kind=$row['kind'];
					};
				
        			//送資料進資料庫
			        if(preg_match('/^.{1,30}$/u', $_POST['name'], $match)){
			        	$name=$match[0];
			        	if(preg_match('/^.{1,30}$/u', $_POST['brand'], $match)){
			        		$brand=$match[0];
			        		if(preg_match('/^.{1,10}$/u', $_POST['area'], $match)){
			        			$area=$match[0];
			        			if(preg_match('/^\d{1,5}$/', $_POST['ml'], $match)){
				        			$ml=$match[0];
				        			if(preg_match('/^\d{1,2}.?\d{1,2}$/', $_POST['den'], $match)){
					        			$den=$match[0];
					        			if(preg_match('/\d{1,7}/', $_POST['price'], $match)){
						        			$price=$match[0];
						        			
						        		// 	echo $id.','.$kind.','.$name.','.$area.','.$brand.','.$ml.','.$den.','.$price.','.$imgname;
						        			
						        			$sql="INSERT INTO al_list(i,kind,name,area,brand,ml,density,price,img)VALUES(?,?,?,?,?,?,?,?,?)";
									        $sth=$dbh->prepare($sql);
									        $sth->execute(array($id,$kind,$name,$area,$brand,$ml,$den,$price,$imgname));
									        echo '<meta http-equiv=REFRESH CONTENT=0;url=viewBoard.php?id='.$id.'&&kind='.$kind.'>';
							        		}
							        		
						        
						        		else{
						        			$resultStr='請填入正確的價錢';
						        		}
					        		}
					        		else{
					        			$resultStr='請填入正確格式的酒精濃度';
					        		}
				        		}
				        		else{
				        			$resultStr='請填入正確格式的容量';
				        		}

			        		}
			        		else{
			        			$resultStr='請填入10字以內的產地';
			        		}
			        	}
			        	else{
			        		$resultStr='請填入30字以內的品牌';
			        	}

			        }
			        else{
			        	$resultStr='請填入30字以內的名字';
			        }
			    }

				else if(!in_array($extension, $whiteList)){
					$resultStr = '請上傳符合格式的檔案';
				}
				else if($_FILES["al-img"]["size"] > 1024 * 1024){
				        $resultStr = "檔案太大";
			    }

			}
		}	

			    

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>New Al</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="topbar.css">
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
		height: 22px;
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
		height: 200px;
		/*line-height: 250px;*/
	}
	.rowline textarea{
		width: 250px;
		height: 200px;
		line-height: 20px;
		border: 0;
		padding: 8px;

	}
	input[type='file']{
		width: 190px;
		margin:0;
		height: 60px;
		line-height: 30px;
		/*right: 0;*/
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
			<form action="new_al.php" method='post' enctype="multipart/form-data">
				<div class='rowline'><div class='left'>酒類名稱</div>
				<div class='right'><input type="text" name='name'></div></div>

				<div class='rowline'><div class='left'>酒款</div>
				<div class='right'>
				<?php 
				$sth = $dbh->query('SELECT * from al_board ORDER BY id');
				echo "<select class='choseid' name='id'>";
				echo "<option></option>";
				while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		        	echo "<option id=".$row['id'].">".$row['name']."</option>";
		        }
		        echo "</select>";
				?></div></div>

				<div class='rowline'><div class='left'>酒類型</div>
				<div class='right'>
				<select class='al-kind' name='kind'>
					<option></option>
					<?php
					$dbh->query('SELECT * from al_category where type_id=1 and id !=0 ORDER BY id');
					while($row = $sth->fetch(PDO::FETCH_ASSOC)){
		        	echo "<option>".$row['cate_n']."</option>";
		        	}
					?>
				</select></div></div>

				<div class='rowline'><div class='left'>品牌名</div>
				<div class='right'><input type="text" name='brand'></div></div>

				<div class='rowline'><div class='left'>產地</div>
				<div class='right'><input type="text" name='area'></div></div>

				<div class='rowline'><div class='left'>容量</div>
				<div class='right'><input type="text" name='ml'style="width: 50px;" >ml</div></div>

				<div class='rowline'><div class='left'>酒精濃度</div>
				<div class='right'><input type="text" name='den' style="width: 50px;">%</div></div>

				<div class='rowline'><div class='left'>價錢</div>
				<div class='right'><input type="text"name='price' style="width: 50px;">元</div></div>

				<div class='rowline'><div class='left'>產品圖</div>
				<div class='right'><input type="file" name='al-img'><?php echo $result;?></div></div>

				<!-- <div class='rowline textreview'><div class='left'>產品簡述</div>
				<div class='right'><textarea name="bri" id="brief" cols="30" rows="10"></textarea></div></div> -->
				
				<div class="sub"><input type="submit" value='確定新增'></div>

				<div id="error"><?php echo $resultStr;?></div>
			</form>
		</div>
	
</body>
</html>
<script>
	$(document).ready(function(e){
		$('.choseid').on('change',function(){
			var al_id = $(this).children(":selected").attr("id");
			
			$.post(
				"ajax_newal_showkind.php",{
					"al_id":al_id
				}
			).done(function(data){
				$('.al-kind').empty();
				if(data =="No Data"){
						$('.al-kind').append("目前沒有此類酒款");
					}
				else{
					$('.al-kind').append(data);
			
				}
			})
		});
			
	});	
		
	
		
	
</script>