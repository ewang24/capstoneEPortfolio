<?php
session_start();
$Id = $_POST['moons'];
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];

$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;

$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);

if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info . "\nYour password may be wrong";
}
	$query = "select * from `Moon` where MoonId = $Id";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
	$row1 = $result->fetch_assoc();
	$name = $row1['Name'];
	$size = $row1['Size'];
	$density = $row1['Density'];
	$mass = $row1['Mass'];
	$type = $row1['Type'];
	$atmo = $row1['AtmoMakeUp'];
	$grav = $row1['Gravity'];
	$inh = $row1['Inhabit'];
	$pop = $row1['Population'];
?>
<html>
<title>Explore <?php echo $name;?></title>
<body bgcolor = "e5e5ff">
<h1>Moon <?php echo $name;?></h1>
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
<td><?php echo $type;?></td>
</tr>
<tr>
<td>Atmosphere:</td>
<td><?php if($atmo == null){echo "None";}else{echo $atmo;}?></td>
</tr>
<tr>
<td>Gravity:</td>
<td><?php echo $grav;?></td>
</tr>
<tr>
<td>Inhabited?</td>
<td><?php if($inh == 'Y'){echo "Yes";}else{echo"No";}?></td>
</tr>
<tr>
<td>Population:</td>
<td><?php echo $pop;?></td>
</tr>

</table>
</body>
<script>
function back()
{
window.location.href="planet.php";
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


