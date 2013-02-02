<?php
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

include_once("class/Database.class.php");
include_once("class/Note.class.php");
include_once("class/Notes.class.php");

// Connect to our SQL Database
Database::connect();

// Determine what is happening
$cmd = $_REQUEST['cmd'];
$ret = array();
switch ($cmd)
{
	case "generate_tree":
		$ret = Notes::generateTree()->toArray();
		break;	
	case "add":
		$college = $_REQUEST['college'];
		$major = $_REQUEST['major'];
		$class = $_REQUEST['class'];
		$difficulty = $_REQUEST['difficulty'];
		$tags = $_REQUEST['tags'];
		$title = $_REQUEST['title'];
		$content = $_REQUEST['content'];
		if ($college!=NULL&&$major!=NULL&&$class!=NULL&&$difficulty!=NULL&&$tags!=NULL&&$title!=NULL&&$content!=NULL)
		{
			$query = sprintf("INSERT INTO notes (college, major, class, difficulty, tags, title, content) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')", utf8_encode($college), utf8_encode($major), utf8_encode($class), utf8_encode($difficulty), utf8_encode($tags), utf8_encode($title), utf8_encode($content));
			$result = mysql_query($query);
			if ($result) $ret['success'] = true;
			else $ret['success'] = false;
		}
		else $ret['success'] = false;
		
		break;
	case "get_colleges":
		$ret["colleges"] = array();
		$query = "SELECT * FROM colleges";
		$result = mysql_query($query);
		while ($array = mysql_fetch_array($result)) $ret["colleges"][] = array($array["id"], $array["name"]);
		$ret['success'] = true;
		break;
	case "get_majors":
		if (isset($_REQUEST['id']))
		{
			$query = sprintf("SELECT * FROM colleges_majors WHERE college_id='%s'", intval($_REQUEST['id']));
			$result = mysql_query($query);
			while ($array = mysql_fetch_array($result))
			{
				$query2 = sprintf("SELECT * FROM majors WHERE id='%s'", $array['major_id']);
				$result2 = mysql_query($query2);
				if ($result2)
				{
					while ($array2 = mysql_fetch_array($result2)) $ret[] = array($array2["id"], $array2["name"]);
				}
			}
		}
		else $ret['success'] = false;
		break;
	case "get_classes":
		if (isset($_REQUEST['id']))
		{
			$query = sprintf("SELECT * FROM majors_classes WHERE major_id='%s'", intval($_REQUEST['id']));
			$result = mysql_query($query);
			while ($array = mysql_fetch_array($result))
			{
				$query2 = sprintf("SELECT * FROM classes WHERE id='%s'", $array['class_id']);
				$result2 = mysql_query($query2);
				if ($result2) while ($array2 = mysql_fetch_array($result2)) $ret[] = array($array2["id"], $array2["name"]);
			}
		}
		else $ret['success'] = false;
		break;
	default:
		$query = "SELECT * FROM notes";
		$result = mysql_query($query);
		$notes = Notes::queryToArray($result);
		foreach ($notes as $note) $ret[] = $note->toArray();
		break;
}

echo json_encode($ret);

?>
