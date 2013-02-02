<?php

include_once('Node.class.php');
include_once('Database.class.php');
Database::connect();
class Notes
{
	static function generateTree ($options = array("major"=>"any", "college"=>"any", "class"=>"any"), $type = NULL)
	{
		$query = "SELECT n.title, n.id, com.college_id, cl.major_id, cl.class_id FROM colleges_majors com, majors_classes cl, notes n WHERE com.major_id=cl.major_id 
				AND cl.class_id=n.class";
		if (($options["major"] != "any") && (is_int($options["major"]))) {
			$query .= "AND cl.major_id=".$options["major"];
		}
		if (($options["college"] != "any") && (is_int($options["college"]))) {
			$query .= "AND com.college_id=".$options["college"];
		}
		if (($options["class"] != "any") && (is_int($options["class"]))) {
			$query .= "AND cl.class_id=".$options["class"];
		}
		$response = mysql_query($query);
		$majors_array = array();
		$colleges_array = array();
		$globalNode = new Node(NULL,0,"UC Berkeley");
		while ($row = mysql_fetch_assoc($response)) {
			$newNode = new Node(NoteType.nclass, $row['id'], $row['name']);
			if (in_array($row["major_id"], $majors_array)) {
				$majorNode = $majors_array[$row["major_id"]];
				$majorNode->addChild($newNode);
			} else {
				$majorNode = new Node(1, $row["major_id"], $row['title']);
				$majorNode->addChild($newNode);
				$majors_array[$row["major_id"]] = $majorNode;
			}
			if (in_array($row["college_id"], $colleges_array)) {
				$tmpNode = $colleges_array[$row["college_id"]];
				$tmpNode->addChild($majorNode);
			} else {
				$tmpNode = new Node(1, $row["college_id"], $row['title']);
				$tmpNode->addChild($majorNode);
				$colleges_array[$row["major_id"]] = $tmpNode;
			}
		}
		foreach ($colleges_array as $key => $value) {
			$globalNode->addChild($value);
		}
		return $globalNode;
	}
	
	static function queryToArray($result)
	{
            
		if ($result && mysql_num_rows($result) > 0)
		{
			$ret = array();
			while ($array = mysql_fetch_array($result)) $ret[] = new Note($array);
			return $ret;
		}
	}
}

?>