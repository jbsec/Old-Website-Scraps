<?
require_once("conn.php");
require_once("includes.php");

if(empty($_POST['website']))
{
	$my_website = "http://";
}
else
{
	$my_website = $_POST['website'];
}

if(isset($_POST[s1]))
{
	$MyExp = mktime(0,0,0,date(m) + 1, date(d), date(Y));

	if($_FILES['picture']['size'] > '0')
	{
		$ext_array = explode(".", $_FILES['picture']['name']);
		$ext = array_pop($ext_array);
		$ext = strtolower($ext);

		$allowed = array("gif", "jpg", "jpeg");
			
		if(in_array($ext, $allowed))
		{
			$new_picture = $t."_".$_FILES['picture']['name'];
			copy($_FILES['picture']['tmp_name'], "yellow_images/".$new_picture);
		}
	}

	$my_hospital = htmlspecialchars($_POST[hospital]);
	$my_address = htmlspecialchars($_POST[address]);
	$my_ms = htmlspecialchars($_POST[medical_school]);
	$my_rt = htmlspecialchars($_POST[residency_training]);
	$my_members = htmlspecialchars($_POST[memberships]);
	$my_bio = htmlspecialchars($_POST[bio]);

	$q1 = "insert into doctors_members set 
						username = '$_POST[NewUsername]',
						password = '$_POST[p1]',
						hospital = '$my_hospital',
						primary_specialty = '$_POST[primary_specialty]',
						secondary_specialty = '$_POST[secondary_specialty]',
						gender = '$_POST[gender]',
						FirstName = '$_POST[FirstName]',
						LastName = '$_POST[LastName]',
						address = '$my_address',
						city = '$_POST[city]',
						state = '$_POST[state]',
						country = '$_POST[country]',
						phone = '$_POST[phone]',
						cellular = '$_POST[cellular]',
						pager = '$_POST[pager]',
						email = '$_POST[email]',
						website = '$_POST[website]',
						medical_school = '$my_ms',
						residency_training = '$my_rt',
						graduation_year = '$_POST[graduation_year]',
						memberships = '$my_members',
						bio = 'my_bio',
						military = '$_POST[military]',
						birthyear = '$_POST[birthyear]',
						picture = '$new_picture',
						RegDate = '$t',
						ExpDate = '$MyExp' ";

	mysql_query($q1);

	if(ereg("key 2", mysql_error()))
	{
		$error = "<span class=\"RedLink\">The username <span class=\"BlackLink\">$_POST[NewUsername]</span> is already in use!<br>Select another one, please!</span>";

		unset($_POST[NewUsername]);
	}
	elseif(ereg("key 3", mysql_error()))
	{
		$error = "<span class=\"RedLink\">You are already registered!<br>Update your account, please!</span>";

		unset($_POST);
	}
	else
	{
		$last = mysql_insert_id();
		$_SESSION['NewAgent'] = $last;

		//send an email
		$to = $_POST['email'];
		$subject = "Your registration at $_SERVER[HTTP_HOST]$dir";
		$message = "Hello $_POST[FirstName] $_POST[LastName],\nhere is your login information for $_SERVER[HTTP_HOST]$dir\n\nUsername: $_POST[NewUsername]\nPassword: $_POST[p1]\n\nTo login, follow this link:\nhttp://$_SERVER[HTTP_HOST]$dir/login.php\n\nThank you for your registration!";

		$headers = "MIME-Version: 1.0\n"; 
		$headers .= "Content-type: text/plain; charset=iso-8859-1\n";
		$headers .= "Content-Transfer-Encoding: 8bit\n"; 
		$headers .= "From: $_SERVER[HTTP_HOST]$dir <$aset[ContactEmail]>\n"; 
		$headers .= "Reply-To: $_SERVER[HTTP_HOST]$dir <$aset[ContactEmail]>\n"; 
		$headers .= "X-Priority: 3\n"; 
		$headers .= "X-MSMail-Priority: Normal\n"; 
		$headers .= "X-Mailer: PHP/" . phpversion()."\n"; 

		mail($to, $subject, $message, $headers);		

		header("location:prices.php");
		exit();
	}

}


//get the templates
require_once("templates/HeaderTemplate.php");
require_once("templates/RegistrationTemplate.php");
require_once("templates/FooterTemplate.php");

?>

