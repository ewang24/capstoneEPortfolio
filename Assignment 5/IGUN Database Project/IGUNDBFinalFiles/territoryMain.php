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
$_SESSION['Id'] = $Id;
?>

<html>
<head><title>Territory</title></head>
	<body bgcolor = "e5e5ff">
	<h1>Territory Information:<h1>
	<?php
	echo $rName;

	$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
	if($mysqli->connect_errno)
	{

	echo "Failed to connect to mysql: (" . $myqli->	connect_errno . ") " . $mysqli->conect_error . $mysqli->	host_info;

	}

	$query="select sum(Population) as Pop,sum(PlanetNum) as PlanetNum ,Sov.Name as SovName, Race.Name as Racename, SovId, StarSysId, PlanetNum, Population, Diameter, Resources from `Sov` inner join `Race` using(RaceId) left  join `StarSys` using(sovId) where `RaceId` =$Id";
	$result = $mysqli->query($query) or die ($mysqli->error.	__LINE__);

	echo "<br>";
	if($result->num_rows>0)
	{
	$row1 = $result->fetch_assoc();
	$sovName = $row1['SovName'];
	$planetNum = $row1['PlanetNum'];
	$pop = $row1['Pop'];
	$sovId = $row1['SovId'];
	}
	else
	{
	echo "No results";
	}	

	?>
	<form method = "post" action = "starSys.php">
	<table bgcolor="ccccff">
	<tr bgcolor = "ccccff">
	<td><?php echo $rName;?> holds sovereignty over </td><td><?php echo $sovName; ?></td>
	</tr>
	<tr>
	<td><?php echo $sovName;?> Contains <?php echo $planetNum;?> planets</td>
	</tr>
	<tr>
	<td><?php echo $sovName;?> has a total population of</td>
	<td><?php echo $pop;?>*10^3</td>
	</tr>
	<tr>
	<td>Select a star system for more information: </td>
	<td><select name = "starSys">
	<?php
		$query = "select StarSysId from StarSys where SovId = $Id";
		$result = $mysqli->query($query) or die ($mysqli->error. __LINE__);
		while($starRow =$result->fetch_assoc())
		{
			$starSysId = $starRow['StarSysId'];
			echo "starSysId";
			?>
			<option value = "<?php echo $starSysId;?>"><?php echo $starSysId;?></option>
			<?php
		}
	?>
	</select></td>
	<td><input type = "submit" value = "Submit" name = "submit"></td>
	</tr>
	<tr>
	<td><?php echo $sovName?> has
 <?php 
$query = "select count(SpaceStationId) from SpaceStation where RaceId = $Id";
 $result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
$spaceStationRow = $result->fetch_assoc();
 echo $spaceStationRow['count(SpaceStationId)'];
?> space stations:</td>
	</tr>
	<tr>
	<td colspan = "3">
	<?php
	$query = "select * from SpaceStation where RaceId = $Id";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
	while($station=$result->fetch_assoc())
	{
		echo "Space station ".$station['SpaceStationId']." is a  ".$station['Use']." station. Population: ".$station['Population'].". Ship capacity: ".$station['ShipCap'].". Flight craft capacity:  ".$station['FlightCraftCap'].". Industrial capacity?: ".$station['IndustrialCap']."<br>";
	}
?>
	</td>
	</tr>
	</table>
	</form>

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
<input type = "button" value = "Back" onclick = "back()">
<input type = "button" value = "Return to Main" onclick="backToMain()">

	
<html>
	


