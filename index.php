<?php
	#test3
	$IP = $_SERVER["REMOTE_ADDR"];
	$REFERER = $_SERVER["HTTP_REFERER"];
	$USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
	$HOST = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$today = date("Y-m-d H:i:s"); 
	if(preg_match('/Twitterbot/', $agent)){exit;}
	if(preg_match('/crawl/', $host)){exit;}
	

	if($_GET["2ch"]){
		$top_table = "2ch";
		$top_nomber = $_GET["2ch"];
	}elseif($_GET["blog"]){
		$top_table = "hatena";
		$top_nomber = $_GET["blog"];
	}elseif($_GET["news"]){
		$top_table = "google";
		$top_nomber = $_GET["news"];
	}elseif($_GET["naver"]){
		$top_table = "naver";
		$top_nomber = $_GET["naver"];
	}

		$local = "localhost";
		$user = "mugenantena";
		$pass = "mugen19260327";
		$db = "mugenantena";
		$con = mysql_connect($local,$user,$pass) or die("大変混み合っています。");
		$result = mysql_select_db($db,$con) or die("データの取得に失敗しました。");
		$result = mysql_query('SET NAMES utf8', $con);
	$result = mysql_query("SELECT no,count FROM access2 WHERE IP LIKE \"$IP\" AND referer LIKE \"$REFERER\"", $con);
	$no_count = mysql_fetch_array($result);
	if($no_count[0]){
		$no_count[1] = $no_count[1]+1;
		$result = mysql_query("UPDATE access2 SET count=\"$no_co[1]\",date=\"$today\" WHERE no=\"$no_count[0]\"", $con);
	}elseif(!$no_count[0]){
		$result = mysql_query("INSERT INTO access2(count,host,IP,agent,referer,date) VALUES (1,\"$HOST\",\"$IP\",\"$USER_AGENT\",\"$REFERER\",\"$today\")", $con);
	}

#	print "$date<br>$table_2ch<br>$HOST";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja"> 
<head> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="Content-Style-Type" content="text/css" /> 
<meta http-equiv="Content-Script-Type" content="text/javascript" /> 
<meta property="og:title" content="むげんあんてな"></meta>
<meta property="og:type" content=website></meta>
<meta property="og:url" content="http://mugenantena.com/"></meta>
<meta property="og:image" content="http://mugenantena.com/image/icon1.png/"></meta>
<meta property="og:site_name" content="アンテナサイト"></meta>
<meta property="og:description" content="話題になっているリンクをまとめたサイト"></meta>
<meta http-equiv="Content-Style-Type" content="text/css"></meta>
<title>むげんあんてな</title> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<link href="http://mugenantena.com/css/style.css" rel="stylesheet" type="text/css">
</head> 
<body> 
		<a href="http://mugenantena.com/" alt="むげんあんてな">
			<img src="./image/mugenantena.png" width="100%" border="0" alt="むげんあんてな">
		</a>	
<?php 
	
	if(($top_table) && ($top_nomber)){
		$local = "localhost";
		$user = "mugenantena";
		$pass = "mugen19260327";
		$db = "mugenantena";
		$con = mysql_connect($local,$user,$pass) or die("大変混み合っています。");
		$result = mysql_select_db($db,$con) or die("データの取得に失敗しました。");
		$result = mysql_query('SET NAMES utf8', $con);
		$result = mysql_query("SELECT no,name,url,title,link,location,image,favicon,date FROM $top_table WHERE no2 = $top_nomber", $con);
		$row = mysql_fetch_array($result);
		$no = $row[0];
		$name = $row[1];
		$url = $row[2];
		$title = $row[3];
		$link = $row[4];
		$location = $row[5];
		$image = $row[6];
		$favicon = $row[7];
		$date = $row[8];
		if(!$image){$image="./image/noimage.png";}

		echo <<<EOM
	<table id="table" style="margin-bottom:30px;">
		<tr>
			<td>
				<div id="table_title" style="float:left;">
					<img src="$favicon" width="13px" style="margin-right:5px;margin-left:5px;">
					<a href="$url" style="color:#cccccc;">
						$name
					</a>
				</div>
			</td>
		</tr>
		<tr>
			<td style="border: solid 1px #000000;">
				<div class="list" id="li2">
					<a href="$link" target="_blank">
						<img src="$image" style="width:60px;height:60px;top:0;left:0;margin-right:10px;float:left;">
						<span id="title">
							<b>
								$title
							</b>
						</span>
					</a>
				</div>
			</td>
		</tr>
	</table>
EOM;
	}
?>

<?php 
	$c=0;
	$flag = 0;
	$max = 30;
	$local = "localhost";
	$user = "mugenantena";
	$pass = "mugen19260327";
	$db = "2ch";
	$con = mysql_connect($local,$user,$pass) or die("大変混み合っています。");
	$result = mysql_select_db($db,$con) or die("データベースの選択に失敗しました。");
	$result = mysql_query('SET NAMES utf8', $con);
	$result = mysql_query("SELECT no,table_name,next_table FROM tables ORDER BY no DESC LIMIT 1", $con);
	$row = mysql_fetch_array($result);
	$table_name[] = $row[1];
	$table_name[] = $row[2];

	echo <<<EOM
	<table id="table" style="width:96%;">
		<tr>
			<td>
				<div id="table_title">
					2chまとめ
				</div>
				<font id="add_date">
					$add_date 更新
				</font>
			</td>
		</tr>
		<tr>
			<td style="border: solid 1px #000000;">
EOM;
	
	for($i=0;$i <= $c;$i++){
		$result = mysql_query("SELECT no,name,url,title,source_link,my_link,image,favicon,date FROM $table_name[$i] ORDER BY no DESC LIMIT $max", $con);
		while($row = mysql_fetch_array($result)) {
			$no = $row[0];
			$name = $row[1];
			$url = $row[2];
			$title = $row[3];
			$link = $row[4];
			$my_link = $row[5];
			$image = $row[6];
			$favicon = $row[7];
			$date = $row[8];
			if($flag % 2 == 0){$li="li1";}
			else {$li="li2";}
		
			echo <<<EOM
			<div class="list" id="$li">
				<a href="$link" target="_blank">
					<img src="$image" style="width:60px;height:60px;top:0;left:0;margin-right:10px;float:left;">
					<span id="title" style="">
						<b>
							$title
						</b>
					</span>
				</a>
			</div>
EOM;
			$flag++;
		}#while
		if(($flag < $max) && ($c < 2)){
			$c++;
			$max = $max - $flag;
		}
	}#for

	echo <<<EOM
			</td>
		</tr>
	</table>
EOM;
?>

<?php 
	if($flag){
		echo <<<EOM
		<a href="http://mugenantena.com/2ch/" style="color:#333333;float:right;margin-right:10px;margin-bottom:25px;">
			もっと見る
		</a>
EOM;
	}else{echo "<center>データがありません</center>";}
	$con = mysql_close($con);
?>
	
	<div id="footer">
			むげんあんてな
	</div>
</body>
</html>
