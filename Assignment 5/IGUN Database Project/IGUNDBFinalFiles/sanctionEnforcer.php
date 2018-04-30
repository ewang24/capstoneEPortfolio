<?php
session_start();
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
$sanc = $_POST['sancEnf'];
$enfQuery = "select Name from Race inner join SanctionEnforcer using(RaceId) where SanctionId = $sanc";
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info . "\nYour password may be wrong";
}
$query = "select * from Sanction where SanctionId = $sanc";
$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
$row = $result->fetch_assoc();
$sancName = $row['SanctionName'];
$estab =$row['EstabDate'];
?>
<html>
<body bgcolor = "e5e5ff">
<title>Sanction</title>
<h1>Sanction: <?php echo $sancName;?></h1>
<table>
<tr>
<td>Date of Establishment:</td>
<td><?php echo $estab ?></td>
</tr>
<tr>
<td>Enforcers:</td>
<td>
<select>
<?php 
$enfResult = $mysqli->query($enfQuery) or die ($mysqli->error.__LINE__);
echo $enfQuery;
if($enfResult->num_rows)
{
while($row = $enfResult->fetch_assoc())
{
?>
	<option><?php echo $row['Name'];?></option>
<?php
}
}
else
{
?>
<option>No Enforcers</option>
<?php
}
?>
</select>
</td>
</tr>
<tr>
<td colspan = "2"><?php
$conQuery = "select `Rule` from `SancConditions` where `SanctionId` = $sanc";
$conResult = $mysqli->query($conQuery) or die ($mysqli->error.__LINE__);
$c = 1;
while($row = $conResult->fetch_assoc())
{
	echo "Condition ".$c.": ".$row['Rule']."<br>";
	$c++;
}
 ?></td>
</tr>
</table>
<script>
function back()
{
	window.location.href="diplomacyMain.php";
	return false;
}

function backToMain()
{
	window.location.href="main.php";
	return false;
}

</script>
<input type = "button" value = "Back" onclick = "back()">
<input type = "button" value = "Back To Main" onclick = "backToMain()">
</body>
</html>



