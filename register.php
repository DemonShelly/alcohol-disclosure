<?php
session_start();
include('pdoInc.php');
$result='';

if(isset($_SESSION['account'])&& $_SESSION['account']!=null){
	echo '<meta http-equiv=REFRESH CONTENT=0;url=board.php>';
}
if (isset($_POST['back'])) {
	echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
}
else if (isset($_POST['nickname'])&&isset($_POST['account'])&&isset($_POST['password'])&&isset($_POST['passwordchk'])) {

	if (preg_match('/^[\p{Han}\w]{1,8}$/u', $_POST['nickname'], $match)) {
		$name = $match[0];
		if (preg_match('/^[a-zA-Z0-9_]{1,8}$/', $_POST['account'], $match)) {
			$acc = $match[0];
			if (preg_match('/^[a-zA-Z0-9_]{1,16}$/', $_POST['password'], $match)) {
				$pwd = $match[0];
				if (preg_match('/^[a-zA-Z0-9_]{1,16}$/', $_POST['passwordchk'],$match)) {
					$pwdchk = $match[0];
					if ($pwd != $pwdchk) {
						$result="兩次密碼輸入不一致";
					}

					else{
						$sql = 'SELECT * from member where account=?';
						$sth = $dbh->prepare($sql);
						$sth->execute(array($acc));
						if($sth->rowCount() == 1){
							$result="已存在此帳號";
						}
						else{
							$sth = $dbh->prepare('INSERT INTO member(account,password,nickname,admin) VALUES(?,?,?,?)');
							$sth->execute(array($acc,md5($pwd),$name,0));
							$row = $sth->fetch(PDO::FETCH_ASSOC);
							echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
						}
					}
					
				}
				else{
					$result="兩次密碼輸入不一致";
				}
			}
			else{
				$result='密碼不符合格式';
			}

		}
		else{
			$result='帳號不符合格式';
		}
	}
	else{
		$result='暱稱不符合格式';
	}
	
	// else  {
		
	// 	$sth = $dbh->prepare('INSERT INTO member(account,password,nickname,admin) VALUES(?,?,?,?)');
	// 	$sth->execute(array($acc,md5($pwd),$name,0));
	// 	$row = $sth->fetch(PDO::FETCH_ASSOC);
	// 	echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
	// }
}

?>


<!DOCTYPE html>
<html>
<head>
	<title>register</title>
	<style type="text/css">
		body{
			background-color: rgb(240,240,240);
			font-size: 15px;
			
		}
		
		span{
			margin: 0 10px;
		}
		.btn{
			font-size: 20px;
			width: 150px;
			margin: 0 10px;
			vertical-align: text-bottom;
			border: none;
			border-radius: 2px;
			padding: 5px 3px;
			background-color: rgb(240,245,243);
			
		}
		
		.container{
			position: relative;
			left: 50%;
			width: 400px;
			height: 460px;
			margin:100px 0 0 -200px;
			text-align: center;
		}
		.title{
			font-size: 40px;
			font-weight: bolder;
			margin: 10px auto;
			text-align: center;
		}
		#revise{
			font-size: 15px;
			width: 400px;
			height: 340px;
			border-radius: 2px;
			padding-top:10px;
		}
		.row{
			position: relative;
			height: 50px;
			line-height: 50px;
		}

		.label{
			display: inline-block;
			position: absolute;
			left: 30px;
			vertical-align: middle;
			font-weight: 500;
		}
		.labelText{
			text-align: right;
			margin-right: 30px;

		}
		input{
			text-align: right;
			font-size: 15px;
			border-radius: 2px;
			background-color: white;
			width: 250px;
			height: 33px;
			margin-bottom: 8px;
			border-style: none;
		}

		#submit,#cancel{
			text-align: center;
			background-color: black;
			color: white;	
			font-size: 20px;
			border-radius: 2px;
			width: 350px;
			height: 50px;
			margin-top: 5px ;
			margin-bottom: 5px;
			
		}
		#cancel{
			background-color: rgb(230,230,230);
			border: 1px lightgrey solid;
			color: black;
		}
		
		#error{
			font-size: 10px;
			color: red;
			padding: 0;
			margin: 0;
		}
	
		

		/*button{
			background-color: rgb(235,240,235);
			margin-top: 5px ;
	
		}*/
		#error{
			font-size: 10px;
			color: red;
		}

	</style>

</head>
<body>
	
<div class="container">
	<div class="title">
		註冊新帳號
	</div>
	<form action="register.php" method="post">
		<div class="row">
			<div class="label">
				暱稱</div>
			<div class="labelText">
				<input type="text" name="nickname" placeholder="8字內的中英文數字底線" ></div>
		</div>
		<div class="row">
			<div class="label">	
				新增帳號</div>
			<div class="labelText">
				<input type="text" name='account' placeholder="8字內的英文數字底線" ></div>
		</div>
		<div class="row">
			<div class="label">
				輸入密碼</div>
			<div class="labelText">
				<input type="password" name="password" placeholder="16字內的英文數字底線" ></div>
		</div>
		<div class="row">
			<div class="label">
				確認密碼</div>
			<div class="labelText">
				<input type="password" name="passwordchk" placeholder="再輸入一次密碼" ></div>
		</div>
		<div id="error">
			<?php echo $result;?><br/>
		</div>
			<input id='submit' type="submit" value="註冊">
			<button id='cancel'name='back'>返回登入頁</button>
	</form>
</div>
</body>
</html>

