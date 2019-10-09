<?php
session_start();
include("pdoInc.php");

if(!isset($_SESSION['account'])){
	die("<meta http-equiv=REFRESH CONTENT=0;url=login.php>");
}

// if (isset($_POST['backToBoard'])) {
// 	echo"<meta http-equiv=REFRESH CONTENT=0;url=board.php>";

// }

$resultStr = '';
if(isset($_POST['nickname']) && isset($_POST['password'])){
    $sth = $dbh->prepare('SELECT account FROM member WHERE account = ? and password = md5(?)');
    $sth->execute(array($_SESSION['account'], $_POST['password']));

    if($sth->rowCount() == 1){
    	// echo "succees";
        if($_POST['newpwd1'] != '' && $_POST['newpwd2'] != ''){
            if($_POST['newpwd1'] == $_POST['newpwd2']){
                $sth2 =  $dbh->prepare('UPDATE member SET nickname = ?, password = md5(?) WHERE account = ?');
                $sth2->execute(array($_POST['nickname'], $_POST['newpwd1'], $_SESSION['account']));
                $resultStr = '修改暱稱或密碼成功';
                $_SESSION['nickname'] = $_POST['nickname'];
            }
            else {
                $resultStr = '兩次新密碼填寫不同';
            }
        }
        else {
            $sth2 =  $dbh->prepare('UPDATE member SET nickname = ? WHERE account = ?');
            $sth2->execute(array($_POST['nickname'], $_SESSION['account']));
            $_SESSION['nickname'] = $_POST['nickname'];
            $resultStr = '修改暱稱成功';
        }
    }
    else {
        $resultStr = '密碼填寫錯誤';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>revise</title>
	
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
	
		
	</style>
</head>
<body>
	 <div class="container">
	 	<div class="title">
			修改資料
		</div>
		<form action="<?php echo basename($_SERVER['PHP_SELF']);?>" method="POST" id='revise'>
		<div class="row">
			<div class="label">帳號</div>
			<div class="labelText">
			<?php echo $_SESSION['account'];?>
		    </div></div>
		<div class="row">
		   	<div class="label">暱稱</div>
		   	<div class="labelText">
		   	<input name="nickname" value="<?php echo $_SESSION['nickname']?>"><br/></div></div>
		<div class="row">	  
		    <div class="label">原密碼</div>
		    <div class="labelText">
		    <input name="password" placeholder="必填"><br/></div></div>
	    <div class="row">
		    <div class="label">修改密碼</div>
		    <div class="labelText">
		    <input name="newpwd1" placeholder="僅修改密碼時需填"><br/></div></div>
	    <div class="row">
		    <div class="label">確認密碼</div>
		    <div class="labelText">
		    <input name="newpwd2" placeholder="僅修改密碼時需填"><br/></div></div>
	    <div id="error">
	    	<?php echo $resultStr;?><br/>
	    </div>
		    <input type="submit" id='submit' value="確定修改">
		    <input type="button" id='cancel' value="取消" onclick="backToBoard()">
		</form>
	</div>

</body>
</html>
<script>
	function backToBoard(){
		window.location.href='board.php';
	}
</script>