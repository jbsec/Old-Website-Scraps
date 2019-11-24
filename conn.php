<?

//enter your MySQL database host name, often it is not necessary to edit this line
$db_host = "localhost";

//enter your MySQL database username
$db_username = "your_db_username";

//enter your MySQL database password
$db_password = "your_db_password";

//enter your MySQL database name
$db_name = "your_db_name";

//enter the directory name, where the scritps are installed.
//for example, if you install the scripts at http://www.your_url.com/doctors enter "doctors"
//else - leave blank
$script_dir = "medical";

		  ////////////////////////////////////////////////////////////
		 //////         do not edit below this line	///////
		///////////////////////////////////////////////////////////

//connect to the database server
$connection = mysql_connect($db_host, $db_username, $db_password) or die(mysql_error());

//select database
$db = mysql_select_db($db_name, $connection);

session_start();

$t = time();

if(!empty($script_dir))
{
	$dir = "/$script_dir";
}

?>