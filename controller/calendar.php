<?php
	include('/../modele/connectDB.php');
?>

<!DOCTYPE html>
<html>
<head>
<title>Calen'Daily</title>
<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8" />
<link href = "/CalenDailyProject/view/css/calendarstyle.css" rel = "stylesheet" type = "text/css" />
</head>

<?php
$sql = "select date from calendar";
$req = mysqli_query($db,$sql);
$temp = 0;
while($data = mysqli_fetch_array($req)) {
	$list[$temp] = $data[0];
	$temp++;
}
if($temp == 0)
	$list[0] = "";
	$lien_redir = "event.php";
	$casu = "#00FFFF";
	$spe = "#FFA500";
	$month_array  =  Array("", "January", "February", "March", "April", "May", "June", "July", "August","September", "October", "November", "December");


if(isset($_GET['month']) && isset($_GET['year'])) {
	$month = $_GET['month'];
	$year = $_GET['year'];
} else {
	$month = date("n");
	$year = date("Y");
}
$s = strlen($month)-1;
if($month<10)
	$month = $month[$s];
$color = array($casu,$spe);
$l_day = date("t",mktime(0,0,0,$month,1,$year));
$x = date("N", mktime(0, 0, 0, $month,1 , $year));
$y = date("N", mktime(0, 0, 0, $month,$l_day , $year));
$title = $month_array[$month]." : ".$year;

?>
<body>
<center>

<form name = "date" method = "get" action = "">
<?php
if(isset($_GET['admin']))
	echo '<input type = "hidden" name = "admin" />';
?>
<select name = "month" id = "month" onChange = "change()" class = "liste">
<?php
	for($i = 1;$i<13;$i++) {
		echo '<option value="'.$i.'"';
		if($i == $month)
			echo ' selected ';
		echo '>'.$month_array[$i].'</option>';
	}
?>
</select>
<select name = "year" id = "year" onChange = "change()" class = "liste">
<?php
	for($i = 2017;$i<2038;$i++) {
		echo '<option value="'.$i.'"';
		if($i == $year)
			echo ' selected ';
		echo '>'.$i.'</option>';
	}
?>
</select>
</form>
<table class = "tableau"><caption><?php echo $title ;?></caption>
<tr><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th><th>Sun</th></tr>
<tr>
<?php

$case = 0;
if($x>1)
	for($i = 1;$i<$x;$i++) {
		echo '<td class="desactive">&nbsp;</td>';
		$case++;
	}
for($i = 1;$i<($l_day+1);$i++) {
	$f = $y = date("N", mktime(0, 0, 0, $month,$i , $year));
	if($i<10)
		$tempo = "0".$i;
	else
		$tempo = $i;
	if($month<10)
		$mm = "0".$month;
	else
		$mm = $month;
	$date = $year."-".$mm."-".$tempo;
	$lien = $lien_redir;
	$lien.= "?date=".$date;
	echo "<td";
	if(in_array($date, $list)) {
		echo " class = 'special' onmouseover = 'over(this,1,2)'";
		echo " onclick = 'go_lien(\"$lien\",this)' ";
	}	else {
		echo" onmouseover = 'over(this,0,2)' ";
		echo " onclick = 'go_lien(\"$lien\",this)' ";
	}
	echo" onmouseout = 'over(this,0,1)'>$i</td>";
	$case++;
	if($case%7 == 0)
		echo "</tr><tr>";
}
if($y != 7)
	for($i = $y;$i<7;$i++) {
		echo '<td class="desactive">&nbsp;</td>';
	}
?>
</tr>
</table>
<br>
<br>
<a href="/CalenDailyProject/modele/logout.php">Logout</a>
</center>
</body>
</html>

<script type = "text/javascript">
	function change() {
		document.date.submit();
	}
	function over(this_,a,t) {
	<?php
	echo "var c2 = ['$color[0]','$color[1]'];";
	?>
	var col;
	if(t == 2)
		this_.style.backgroundColor = c2[a];
	else
		this_.style.backgroundColor = "";
	}

	function go_lien(a,this_) {
		over(this_,0,1);
		top.document.location = a;
	}
</script>
