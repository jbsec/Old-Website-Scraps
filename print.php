<?
require_once("conn.php");
require_once("includes.php");

$q1 = "select * from doctors_members, doctors_categories where doctors_members.AgentID = '$_GET[id]' and doctors_categories.CategoryID = doctors_members.primary_specialty ";
$r1 = mysql_query($q1) or die(mysql_error());
$a1 = mysql_fetch_array($r1);

	$Image1 = "bg_info2.gif";

	$desc = nl2br($a1['bio']);

	if(!empty($a1['secondary_specialty']))
	{
		//get the secondary speciality name
		$qsec = "select CategoryName from doctors_categories where CategoryID = '$a1[secondary_specialty]' ";
		$rsec = mysql_query($qsec) or die(mysql_error());
		$asec = mysql_fetch_array($rsec);

		$secondary = "Secondary speciality: <span class=SubCatLinks>$asec[CategoryName]</span><br>";
	}

	$ShowInfo = "<table border=\"0\" align=\"center\" width=\"100%\">\n\t\t\t\t<tr>\n\t\t\t\t<td width=\"60%\" valign=top><span class=\"BlackLink\">$a1[FirstName] $a1[LastName]<br>$a1[hospital]<br>Primary specialty: <span class=SubCatLinks>$a1[CategoryName]</span><br>$secondary<br><br>$a1[address], $a1[city], $a1[state], $a1[country]<br></span>";
	
	if(!empty($a1[phone]))
	{
		$contacts[] = "Phone: $a1[phone]";
	}

	if(!empty($a1[cellular]))
	{
		$contacts[] = "Cellular: $a1[cellular]";
	}

	if(!empty($a1[pager]))
	{
		$contacts[] = "Pager: $a1[pager]";
	}

	if(strlen($a1[website]) > '11')
	{
		$contacts[] = "<br><a class=BlackLink href=\"$a1[website]\" target=\"_blank\">$a1[website]</a>";
	}

	if(!empty($contacts))
	{
		$ShowContacts = implode(", ", $contacts);
	}

	if(!empty($a1['memberships']))
	{
		$mem = nl2br($a1['memberships']);
	}

	if(!empty($a1['picture']))
	{
		$logo = "<a href=\"info.php?id=$a1[AgentID]&i=2\"><img src=\"yellow_images/$a1[picture]\" width=100 style=\"border-color:black; border-width:1px\"></a>";
	}

	if(!empty($a1['medical_school']))
	{
		$schools[] = "Medical school: <b>$a1[medical_school]</b>";
	}

	if(!empty($a1['residency_training']))
	{
		$schools[] = "Residency training: <b>$a1[residency_training]</b>";
	}

	if(!empty($a1['graduation_year']))
	{
		$schools[] = "Graduated: <b>$a1[graduation_year]</b>";
	}

	if(!empty($schools))
	{
		$schools_str = "<br>".implode("<br>", $schools);
	}

	//additional info - gender, military, birthyear
	if(!empty($a1['gender']))
	{
		$ainfo[] = "Gender: <b>$a1[gender]</b>";
	}

	$ainfo[] = "Military: <b>$a1[military]</b>";

	if(!empty($a1['birthyear']))
	{
		$ainfo[] = "Birth year: <b>$a1[birthyear]</b>";
	}

	if(!empty($ainfo))
	{
		$additional = "<br><br>".implode("<br>", $ainfo);
	}

	//get the testimonials
	$qt = "select * from doctors_testimonials where AgentID = '$a1[AgentID]' and tstatus = 'approved' order by tid desc ";
	$rt = mysql_query($qt) or die(mysql_error());

	if(mysql_num_rows($rt) > '0')
	{
		$tes = "<table align=\"center\" width=\"100%\" cellspacing=\"5\">\n";

		while($at = mysql_fetch_array($rt))
		{
			$tes .= "<tr bgcolor=\"#DDDDDD\">\n\t<td>$at[testimonial_text]\n<br>\n<div align=\"right\">$at[testimonial_name]</div></td>\n</tr>\n\n";
		}

		$tes .= "</table>\n\n";
	}

	$ShowInfo .= "$ShowContacts<br>$schools_str $additional</td>\n\t\t\t\t<td align=center valign=top width=\"40%\">$logo<br><br>For more information call<br><b> $a1[FirstName] $a1[LastName]<br>$a1[phone]</b><br>or click <span class=\"RedLink\">here</span> to email.</td>\n\t\t\t</tr>\n\n\t\t\t<tr>\n\t\t\t\t<td valign=top colspan=\"2\"><br>$desc<br><br>$mem</td>\n\t\t\t</tr>\n\n<tr>\n\t<td colspan=\"2\" align=\"center\"><a href=\"add_testimonial.php?id=$a1[AgentID]\" class=\"BlackLink\">Add your testimonial</a></td>\n</tr>\n\n<tr>\n\t<td colspan=\"2\" align=\"center\">$tes</td>\n</tr>\n\n</table>\n\n";




$MyAddress = str_replace(" ", "+", $a1[address]);
$MyAddress = str_replace(",", "", $MyAddress);

$ListingID = $a1[AgentID];

require_once("templates/PrintHeaderTemplate.php");
require_once("templates/PrintTemplate.php");	
require_once("templates/PrintFooterTemplate.php");

?>