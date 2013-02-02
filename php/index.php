<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include("class/Database.class.php");
include("class/Note.class.php");
include("class/Notes.class.php");

// Connect to our SQL Database
Database::connect();

// Determine what is happening
$cmd = $_REQUEST['cmd'];
$ret = array();
switch ($cmd)
{
	case "generate_tree":
		// generate tree logic checks
		exit;	
	case "add":
		$college = $_REQUEST['college'];
		$major = $_REQUEST['major'];
		$class = $_REQUEST['class'];
		$tags = $_REQUEST['tags'];
		$title = $_REQUEST['title'];
		$content = $_REQUEST['content'];
		if ($college!=NULL&&$major!=NULL&&$class!=NULL&&$tags!=NULL&&$title!=NULL&&$content!=NULL)
		{
			$query = sprintf("INSERT INTO notes (college, major, field, class, subject, tags, title, content) VALUES ('%s', '%s', '', '%s', '', '%s', '%s', '%s')", utf8_encode($college), utf8_encode($major), utf8_encode($class), utf8_encode($tags), utf8_encode($title), utf8_encode($content));
			$result = mysql_query($query);
			if ($result) $ret['success'] = true;
			else $ret['success'] = false;
		}
		else $ret['success'] = false;
		
		echo json_encode($ret);
		exit;
	default:
		$query = "SELECT * FROM notes";
		$result = mysql_query($query);
		$notes = Notes::queryToArray($result);
		foreach ($notes as $note)
		{
			$ret[] = $note->toArray();
		}
		echo json_encode($ret);
		exit;
}

?>
