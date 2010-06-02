<?php

/**
 * @author Jooria Refresh Your Website <www.jooria.com>
 * @copyright 2010
 */

	require_once ('pagination.php');
	include("../db/db_connect.php");
//connect to the mysql


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>How To Create A Pagination In PHP</title>

<!-- css skin -->
<link rel="stylesheet" type="text/css" href="style2.css" />
<style type="text/css">
a {
color:#333;
text-transform: capitalize;
}
a:hover{
color: #999;
text-decoration:underline
}
</style>
</head>
<body>
<?php

	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$page = ($page == 0 ? 1 : $page);
	$perpage = 1;//limit in each page
	$startpoint = ($page * $perpage) - $perpage;

	$sql = @mysql_query("select * FROM `category` order by id desc LIMIT $startpoint,$perpage");

while($Row = mysql_fetch_array($sql)) {

	echo '<p style="text-align: center;"><a target="_blank" href="'.$Row[0].'">'.$Row[1].'</a></p>';
	
}

	//show pages
	echo Pages("category",$perpage,"index.php?");
	
?>
<p><a>Your limit per page is = '<?php echo $perpage;?>'</a></p>
<a href="http://www.jooria.com/Tutorials/Website-Programming-16/Create-A-Pagination-In-PHP-125/index.html">Back to How To Create A Pagination In PHP</a>
</body>
</html>
