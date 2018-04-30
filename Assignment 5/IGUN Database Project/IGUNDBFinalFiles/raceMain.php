<?php
session_start();
if(empty($_POST['race']))
{
$Id = $_SESSION['Id'];
}
else
{
$Id = $_POST['race'];
}
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName'] = $dbName;
$_SESSION['Id'] = $Id;
?>

<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<title>Race Description</title></head>
	<body bgcolor = "e5e5ff">
	<h1>Race Description:<h1>


	<?php
	
	$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
	if($mysqli->connect_errno)
	{
	echo "Failed to connect to mysql: (" . $myqli->	connect_errno . ") " . $mysqli->conect_error . $mysqli->	host_info;
	}

	$query="select * from `Race` inner join `Faction` using(FactionId) where `RaceId` = \"$Id\"";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);

	echo "<br>";
	$row1 = $result->fetch_assoc();
	?>
	<table border = "0">
	<tr bgcolor = "ccccff">
	<td>Race:</td>
	<td><?php echo $row1['Name'];$_SESSION['rName']=$row1['Name'];?></td>
	</tr>
	<tr bgcolor = "ccccff">
	<td>Species:</td>
	<td><?php echo $row1['Species']; ?></td>
	</tr>
	<tr bgcolor = "ccccff">
	<td>Leader:</td>
	<td><?php echo $row1['leader'];; ?></td>
	</tr>
	<tr bgcolor = "ccccff">
	<td>Language:</td>
	<td><?php echo $row1['Language']; ?></td>
	</tr>
	<tr bgcolor = "ccccff">
	<td>Faction Name:</td>
	<td><?php echo $row1['FactionName']; ?></td>
	</tr>
	<tr bgcolor = "ccccff">
	<td>Galactic Population:</td>
	<td><?php echo $row1['GalPop']; ?>*10^3</td>
	</tr>
	<tr bgcolor = "ccccff">
	<td>Homeworld:</td>
	<td><?php echo $row1['Homeworld']; ?></td>
	</tr>
	<table>
	<label><?php echo $row1['Description']; ?></table>
	<form action = "main.php" method = "post" name = "f">
	<input type = "submit" value = "Territory" onclick = "f.action='territoryMain.php';return true;">

	<input type = "submit" value = "Diplomacy" onclick = "f.action='diplomacyMain.php';return true;">
	<input type = "submit" value = "Military" onclick = "f.action='militaryMain.php';return true;">
	<input type = "submit" value = "Faction" onclick = "f.action='faction.php';return true;">
	
	</form>

<script>
function method()
	{
	window.location.href="main.php";
	return false;
	}
</script>

<input type = "button" value = "Back" onclick = "method()">





</body>


</html>
	




