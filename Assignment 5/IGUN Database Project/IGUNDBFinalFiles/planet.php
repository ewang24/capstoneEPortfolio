<?php
session_start();
if(empty($_POST['planets']))
{
$planetId = $_SESSION['planets'];
}
else
{
$planetId = $_POST['planets'];
}
$uName = $_SESSION['uName'];
$dbName = $_SESSION['dbName'];
$pWord = $_SESSION['pWord'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
$_SESSION['planets']=$planetId;
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info . "\nYour password may be wrong";
}

	$query = "select * from `Planet` where planetId = $planetId;";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
	$pRow = $result->fetch_assoc();
	$planetName = $pRow['Name'];
	$size = $pRow['Size'];
	$density = $pRow['Density'];
	$mass = $pRow['Mass'];
	$type = $pRow['Type'];
	$atmo = $pRow['Atmosphere'];
	$grav = $pRow['Gravity'];
	$colonized = $pRow['Colonized'];
	$lang = $pRow['LocLanguage'];
	$pop = $pRow['population'];
?>
<html>
<title>Explore <?php echo $planetName?></title>
<body bgcolor = "e5e5ff">
<h1>Planet <?php echo $planetName ?></h1>
<form action = "moon.php" method = "post">
<table bgcolor="ccccff">

<tr>
<td>Size:</td>
<td><?php echo $size;?></td>
</tr>

<tr>
<td>Density:</td>
<td><?php echo $density;?></td>
</tr>

<tr>
<td>Mass:</td>
<td><?php echo $mass;?></td>
</tr>

<tr>
<td>Type:</td>
<td><?php  if($type == null){echo "Unkown";}else{echo $type;}?></td>
</tr>

<tr>
<td>Atmosphere:</td>
<td><?php if($atmo == null){echo "None"; }else{echo $atmo;}?></td>
</tr>

<tr>
<td>Gravity:</td>
<td><?php echo $grav;?></td>
</tr>

<tr>
<td>Colonized?</td>
<td><?php if($colonized == 0){ echo "No";}else{echo"Yes";}?></td>
</tr>

<tr>
<td>Local Language:</td>
<td><?php if($lang == null){echo "None"; }else{echo $lang;}?></td>
</tr>

<tr>
<td>Population:</td>
<td><?php if($pop == null){echo "None"; }else{echo $pop;}?></td>
</tr>

<tr>
<td>Number of Moons:</td>
<td>
	<?php
	$query = "select count(`MoonId`) from `Moon` where `Moon`.`PlanetId` = $planetId";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
        $row = $result->fetch_assoc();
	$moonNum = $row['count(`MoonId`)'];
	echo $moonNum;
	 ?>
</td>
<td>
<select name = "moons">
<?php $query = "select `Name`,`MoonId` from `Moon` where `Moon`.`PlanetId` = $planetId";
        $result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
        while($row = $result->fetch_assoc())
	{
		?><option value = "<?php echo $row['MoonId'];?>"><?php echo $row['Name'];?></option>
	<?php
	}
?>
</select>
</td>
<td>
<input type = "Submit" value = "Explore Moon">
</td>
</tr>
</table>
</form>
</body>
<script>
function back()
{
window.location.href="starSys.php";
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

</html>


