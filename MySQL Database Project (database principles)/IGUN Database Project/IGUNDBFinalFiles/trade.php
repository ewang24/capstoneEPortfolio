<?php
session_start();
$uName = $_SESSION['uName'];
$pWord = $_SESSION['pWord'];
$dbName = $_SESSION['dbName'];
$_SESSION['uName'] = $uName;
$_SESSION['pWord'] = $pWord;
$_SESSION['dbName']= $dbName;
$tradeId=$_POST['trade'];
$mysqli = new mysqli("127.0.0.1",$uName,$pWord,$dbName);
if($mysqli->connect_errno)
{
echo "Failed to connect to mysql: (" . $myqli->connect_errno . ") " . $mysqli->conect_error . $mysqli->host_info . "\nYour password may be wrong";
}
$query = "select * from `Trade` where `TradeId` = $tradeId";
	$result = $mysqli->query($query) or die ($mysqli->error.__LINE__);
	$row = $result->fetch_assoc();
	$profit = $row['TradeProfit'];

?>
<html>
<title>Trade</title>
<body bgcolor = "e5e5ff">
<h1>Trade Number <?php echo $tradeId;?><h1>
<table bgcolor = "cccccff">
<tr>
<td>Trade Profit:</td>
<td><?php echo $profit;?></td>
<tr>
<tr>
<td>Trade Routes:</td>
<td>
<select>
<?php
$query = "select Route  from `TradeRoutes` where `TradeId` = $tradeId";
$routeResult = $mysqli->query($query) or die ($mysqli->error.__LINE__);
if($routeResult->num_rows>0)
{
while($routeRow = $routeResult->fetch_assoc())
{
?>
<option><?php echo $routeRow['Route']?><option>
<?php
}
}
else
{
?>
<option>None</option>
<?php
}
?>
</select>
</td>
<tr>
<tr>
<td>Trade Partners:</td>
<td>
<select>
<?php
$partnerQuery = "select Name from Race inner join TradePartners using(RaceId) where TradeId = $tradeId";
$partnerResult = $mysqli->query($partnerQuery) or die ($mysqli->error.__LINE__);
if($partnerResult->num_rows>0)
{
while($partnerRow = $partnerResult->fetch_assoc())
{
?>
<option><?php echo $partnerRow['Name'];?></option>
<?php
}}
?>
</select>
</td>
<tr>
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


