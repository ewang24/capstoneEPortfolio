<?php
session_start();
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$raceId = $_SESSION['Id'];

$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
        if($mysqli->connect_errno)
        {
        echo "Failed to connect to mysql: (" . $myqli-> connect_errno . ") " . $mysqli->conect_error . $mysqli->        host_info;
        }

     $query="select Name, FactionName,UnMember,FactionId from `Race` inner join `Faction` using(FactionId) where `RaceId` = $raceId";
        $result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
	$row = $result->fetch_assoc();
	$name = $row['FactionName'];
	$un = $row['UnMember'];
	$factionId = $row['FactionId'];
	$raceName = $row['Name'];
?>
<html>
<title><?php echo $name;?></title>
<h1><?php echo $raceName." Is In The Faction \"".$name."\"";?>:</h1>
<body bgcolor ="e5e5ff">
<table bgcolor = "ccccff">
<tr>
<td>UnMember?</td>
<td align = "left"><?php if($un == 0){echo "False";}else{echo "True";}?></td>
</tr>
<tr>
<td>All Members:</td>
<td>
<select>
<?php
$query = "select Name from Race inner join Faction using(FactionId) where FactionId=$factionId";
$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
while($row = $result->fetch_assoc())
{
	?>
	<option><?php echo $row['Name'];?><option>
	<?php
}
?>
</select>
</td>
</tr>
<tr>
<td>Rules:</td>
</tr>
<tr>
<td colspan = "2">
<?php
	$count = 1;
     $query="select Rule from `FacConditions` where FactionId = $factionId";
        $result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
        while($row = $result->fetch_assoc())
	{	
		echo "Condition ".$count.": ".$row['Rule']."<br>";
		$count++;
	}
	
 
?>
</td>
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
<input type = "button" value = "Back" onclick = "back()">
<input type = "button" value = "Return to Main" onclick="backToMain()">
</body>
</html>


