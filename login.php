<?
require_once("conn.php");


if(isset($_POST[s1]))
{
	$q1 = "select * from doctors_members where username = '$_POST[us]' and password = '$_POST[ps]' ";
	$r1 = mysql_query($q1) or die(mysql_error());

	if(mysql_num_rows($r1) == '1')
	{
		//ok
		$a1 = mysql_fetch_array($r1);

		$_SESSION[AgentID] = $a1[AgentID];
		$_SESSION[username] = $a1[username];
		$_SESSION[MaxOffers] = $a1[offers];
		$_SESSION[AccountStatus] = $a1[AccountStatus];
		$_SESSION[AccountExpireDate] = $a1[ExpDate];

		header("location:index.php");
		exit();
	}
	else
	{
		$error = "<font face=verdana color=red size=2><b>Invalid username/password!</b></font>";
	}

}


//get the templates
require_once("includes.php");
require_once("templates/HeaderTemplate.php");
require_once("templates/LoginTemplate.php");
require_once("templates/FooterTemplate.php");

?>

