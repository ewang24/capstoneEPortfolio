<html>
<?php
session_start(); 
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
if(empty($_POST['starSys']))
{
$starSysId=$_SESSION['starSys'];
}
else
{
$starSysId = $_POST['starSys'];
}
$_SESSION['starSys']=$starSysId;
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
?>

<h1>Explore Star System <?php echo $starSysId;?>
 <?php $mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
        if($mysqli->connect_errno)
        {

        echo "Failed to connect to mysql: (" . $myqli-> connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info;

        }

        $query = "select * from `StarSys` where `StarSysId` = $starSysId;";
	$result = $mysqli->query($query)or die ($mysqli->error. __LINE__);
	  $row1 = $result->fetch_assoc();
	$diameter=$row1['Diameter'];
	$planetNum = $row1['PlanetNum'];
	$population = $row1['Population'];


?></h1>
<title>Star System <?php echo $starSysId;?></title>
<body bgcolor = "e5e5ff">
<form action = "planet.php" method = "post">
<table bgcolor="ccccff">

<tr>
<td>Diameter:</td>
<td><?php echo $diameter;?> (au)</td>
</tr>

<tr>
<td>Number of Planets:</td>
<td><?php echo $planetNum;?></td>
</tr>

<tr>
<td>Population:</td>
<td><?php echo $population;?></td>
</tr>

<tr>
<td>Planets:</td>
<td><select name = "planets">
<?php
	 $query = "select PlanetId, Name from `Planet` inner join `StarSys` using(`StarSysId`) where `StarSysId` = $starSysId;";

	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
while($row1 = $result->fetch_assoc())
	{
		$planetName = $row1['Name'];
		$planetId = $row1['PlanetId'];
	?>
<option value = "<?php echo $planetId;?>"><?php echo $planetName;?></option>
	<?php
	}
	?>
</select>
</td>
<td>
	<input type = "submit" value = "explore planet">
</td>

</tr>

</table>
</form>
</body>
<script>
function back()
{
window.location.href="territoryMain.php";
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

</html
