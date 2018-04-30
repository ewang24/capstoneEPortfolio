<?php
session_start();
$rName = $_SESSION['rName'];
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$Id = $_SESSION['Id'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName'] = $dbName;
$_SESSION['raceId'] = $Id;
?>

<html>
<head><title>Military</title></head>
	<body bgcolor = "e5e5ff">
	<h1>Military Information:<h1>
	<?php
	echo $rName;

	$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
	if($mysqli->connect_errno)
	{

	echo "Failed to connect to mysql: (" . $myqli->	connect_errno . ") " . $mysqli->conect_error . $mysqli->	host_info;

	}

	$query="select * from `Military` inner join `MilCom` using(MilitaryId) where `RaceId` =$Id";
	$result = $mysqli->query($query) or die ($mysqli->error.	__LINE__);

	echo "<br>";
	if($result->num_rows>0)
	{
	$row1 = $result->fetch_assoc();
	$milId = $row1['MilitaryId'];
	$_SESSION['milId']=$milId;
	$flSize = $row1['FleetSize'];
	$gfSize = $row1['GroundForceSize'];
	$comFName = $row1['ComFirstName'];
	$comLName = $row1['ComLastName'];
	}
	else
	{
	echo "No results";
	}	

	?>
	<form method = "post" action = "fleet.php">
	<table bgcolor="ccccff">
	<tr bgcolor = "ccccff">
	<td><?php echo $rName;?> Military Commander: </td><td><?php echo $comFName." ".$comLName; ?></td>
	</tr>
	<tr>
	<td>Fleet Size:</td>
	<td><?php echo $flSize;?></td>
	</tr>
	<tr>
	<td>Ground Force Size:</td>
	<td><?php echo $gfSize;?></td>
	</tr>
	<tr>
	<td>Fleets:</td>
	<td><select name = "fleet">
	<?php
		$query = "select MilFleetId, FleetName from MilFleet where MilitaryId = $milId";
		$result = $mysqli->query($query) or die ($mysqli->error. __LINE__);
		while($starRow =$result->fetch_assoc())
		{
			$milFleetId = $starRow['MilFleetId'];
			$fName = $starRow['FleetName'];
			?>
			<option value = "<?php echo $milFleetId;?>"><?php echo $fName;?></option>
			<?php
		}
	?>

	</select></td>
	<td><input type = "submit" value = "Submit" name ="submit"></td>
	</form>
	</tr>
	</table>
	<script>
	function back()
	{
		window.location.href="raceMain.php";
		return false;
	}
	function backToMain()
	{
		window.location.href="main.php";
		return false;
	}
	</script>
<input type = "button" value = "Back To Race Main" onclick = "back()">
<input type = "button" value = "Back To Main" onclick = "backToMain()">

	
	
<html>
	



