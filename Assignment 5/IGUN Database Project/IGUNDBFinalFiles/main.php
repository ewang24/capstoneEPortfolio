
<?php
session_start();
//variables from form
if(empty($_POST['uName']))
{
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];

}
else
{
$uName = $_POST['uName'];
$pWord = $_POST['pWord'];
$dbName = $_POST['dbName'];
}
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
?>
<html>
<head>
<title>Intergalactic United Nations</title>
</head>
<body bgcolor = "e5e5ff">
<h1>Main screen:</h1>
<h2><?php echo $uName;?>, you have sucessfully logged in to IGUN DB.</h2>
<form name = f method = "post" action = "militaryMain.php">
<table>


<?php
//Begin php
echo '<p>Login attempt at ';
echo date('H:i jS F');
echo '</p>';
echo '<p>User name: ';
echo $uName;
echo '</p>';
echo '<p>Database name: ';
echo $dbName;
echo '</p>';
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->connect_error . $mysqli->host_info . "\nYour password may be wrong";
}
else
{
echo $mysqli->host_info . "<br>";
}
echo "All information stored in this system is confidential.<p>";
echo "Select a race:";
?>
<tr>
<td>Race:</td>
<td>
<select name = "race">
	<?php
	$query = "select RaceId,Name,Language,leader,FactionName from `Race` inner join `Faction` using(FactionId)";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
	echo "<br>";
	if($result->num_rows>0)
	{
	while($row1 = $result->fetch_assoc())
	{
		$entry = $row1['Name'];
		$Id = $row1['RaceId'];
	?>
	<option value = "<?php echo $Id;?>"><?php echo $entry;?></option>
	<?php
	}
	}
	else
	{
	echo 'NO RESULTS';
	}
	mysqli_close($mysqli);
	//end php
	?>
</select>
</td>
</tr>
</table>
<input type = "submit" value = "Submit" name = "third" onclick = "f.action='raceMain.php';return true;">
</form>
<script>
function logout()
{
	window.location.href="login.html";
	return false;
}
</script>
<input type = "button" value = "Logout" onclick = "logout()">
</body>
</html>


