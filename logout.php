<?

if(empty($_SESSION[AgentID]))
{
	header("location:index.php");
}


session_start();
session_unset();
session_unregister();
session_destroy();


header("location:index.php");

?>



