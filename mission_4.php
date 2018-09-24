<?php
header('Content-Type:text/html;charset=UTF-8');

//データベースに接続
$dsn='データベース名';
$user='ユーザ名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password);


//テーブル作成
$sql="CREATE TABLE data4(id INT AUTO_INCREMENT PRIMARY KEY,name char(32),comment TEXT,date DATETIME,password char(32))";
$stmt=$pdo->query($sql);//SQL実行


//編集用
$ePW=$_POST['ePW'];
$eid=$_POST['edit'];
if(!empty($_POST['edit'])&&!empty($_POST['ePW'])){
	$sql = "SELECT * FROM data4 where id=$eid";
	$stm = $pdo -> prepare($sql);
	$stm -> execute();
	$results = $stm -> fetchAll();
	foreach ($results as $row){
		$ename=$row['name'];
		$pwpw=$row['password'];
		$ecomment=$row['comment'];
	}
	
}
?>

<html>
<head>
<meta charset="UTF-8">
<title>mission_4.php</title>
<body>
<form action="mission_4.php"method="POST">
<table type="solid">
<tr><td><input type="text"name="<?php if($pwpw=$ePW){echo "eename";}else{echo "name";}?>" value="<?php if($pwpw=$ePW){echo "$ename";}?>" placeholder="名前">
<tr><td><input type="text"name="<?php if($pwpw=$ePW){echo "eecomment";}else{echo "comment";}?>" value="<?php if($pwpw=$ePW){echo "$ecomment";}?>"placeholder="コメント">
<tr><td><input type="text"name="PW" placeholder="パスワード">
<input type="hidden" name="eid" value="<?php echo "$eid";?>">
<input type="submit" value="送信"></td></tr><br>
<tr><td><input type="text"name="delete"placeholder="削除対象番号">
<tr><td><input type="text"name="dPW" placeholder="パスワード">
<input type="submit" value="削除"></td></tr>
<tr><td><input type="text"name="edit"placeholder="編集対象番号">
<tr><td><input type="text"name="ePW" placeholder="パスワード">
<input type="submit" value="編集"></td></tr>
</table>
</form>
</body>
</html>

<?php


//コメント入力機能
if(!empty($_POST['name'])&&!empty($_POST['comment'])&&!empty($_POST['PW'])){
	$sql = $pdo -> prepare("INSERT INTO data4(name,comment,date,password) VALUES(:name,:comment,:date,:password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> bindParam(':password', $PW, PDO::PARAM_STR);
	
	$name=$_POST['name'];//名前
	$comment=$_POST['comment'];//コメント
	$PW=$_POST['PW'];//パスワード
	$date=date('Y-m-d H:i:s');//日付
	$sql -> execute();

}


//削除機能
elseif(!empty($_POST['delete'])&&!empty($_POST['dPW'])){
	$dPW=$_POST['dPW'];//パスワード
	$did=$_POST['delete'];//削除対象番号
	$sql = 'SELECT * FROM data4';
	$stm = $pdo -> prepare($sql);
	$stm -> execute();
	$results = $stm -> fetchAll();
	foreach ($results as $row){
		$ddid=$row['id'];
		$ddpw=$row['password'];
		if(($ddid==$did)&&($ddpw==$dPW)){
			$sql = "delete from data4 where id=$did";
			$result = $pdo->query($sql);
			}
	}

}

//編集機能
elseif(!empty($_POST['eename'])&&!empty($_POST['eecomment'])){
	$eeid=$_POST['eid'];
	$eename=$_POST['eename'];//編集後の名前
	$eecomment=$_POST['eecomment'];//編集後のコメント
	$sql = "update data4 set name='$eename',comment='$eecomment' where id = $eeid";
	$result = $pdo->query($sql);
}

//データの表示
	$sql = 'SELECT * FROM data4 ORDER BY id';
	$stm = $pdo -> prepare($sql);
	$stm -> execute();
	$results = $stm -> fetchAll();
	foreach ($results as $row){
	echo $row['id'].' ';
	echo $row['name'].' ';
	echo $row['comment'].' ';
	echo $row['date'].'<br>';
	}
?>

