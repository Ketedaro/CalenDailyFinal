<?php
	include('/../modele/connectDB.php');
	//suppression / modification de l'event
	if(isset($_POST['sup'])) {
		$id = $_POST['upd'];
		$date = $_POST['date'];
		$event = $_POST['event'];
		if($_POST['sup'] == 1)
			$sql = "delete from calendar where id = $id";
		else
			$sql = "update calendar set event = '$event' where id = $id";
		mysqli_query($db, $sql);
		header("Location: calendar.php");
	}
	//ajout d'un event
	else if(isset($_POST['event'])) {
		$date = $_POST['date'];
		$event = $_POST['event'];
		$sql = "insert into calendar (date, event) values('$date', '$event')";
		mysqli_query($db, $sql);
		echo $sql;
		header("Location: calendar.php");
	}	else {
		$date = $_GET['date'];
?>

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<h1>Event : <?php echo $date;?></h1>

<?php
	$sql = "select * from calendar where date='$date'";
	$req = mysqli_query($db, $sql);
	if(mysqli_num_rows($req) == 1)
		while($data=mysqli_fetch_array($req)) {
			$mod = 1;
			$id = $data['id'];
			$event = $data['event'];
		} else {
		$mod = 0;
		$event = "";
	}
?>

		<form name="gr" action="event.php" method="post"><input type='hidden' name='date' value='<?php echo $date; ?>'>
			<table>
		        <tr height="50px"><td widateh="150px"><strong>Event</strong></td><td><input type="text" name="event" value="<?php echo $event;?>"/></td></tr>
		        <tr height="50px">
		        <?php
							if($mod == 0)
								echo "<td colspan='2'><input type='submit' value='Ajouter'></td>";
							else
							{

								echo "<td colspan='2'><input type='submit' value='Modifier'>&nbsp;&nbsp;<input type='button' value='Supprimer' onclick='del()'>";
								echo "<input type='hidden' id='sup' name='sup' value='0'><input type='hidden' name='upd' value='$id'></td>";
							}
							?>
		        </tr>
			</table>
		</form>
	</body>
</html>

<?php
}
?>

<script type="text/javascript">
function del() {
	if(confirm("Delete this event ?") == true) {
		document.getElementById('sup').value = 1;
		gr.submit();
	}
}
</script>
