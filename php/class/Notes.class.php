<?php

include_once('Node.class.php');
include_once('Database.class.php');
Database::connect();
class Notes
{
	static function generateTree ($options = array("major"=>-1, "college"=>-1, "class"=>-1), $type = NULL)
	{
		
		/*
		$query = "SELECT c.major_name, c_m.college_id, m.major_name, m_cl.major_id, cl.id, cl.class_name FROM colleges c, colleges_majors c_m, majors m, majors_classes m_cl, classes cl WHERE c.id=c_m.college_id AND c_m.major_id=m_cl.major_id AND m_cl.class_id=cl.id";
		if (($options["major"] != -1) && (is_int($options["major"]))) $query .= "AND m_cl.major_id=".$options["major"];
		if (($options["college"] != -1) && (is_int($options["college"]))) $query .= "AND c_m.college_id=".$options["college"];
		if (($options["class"] != -1) && (is_int($options["class"]))) $query .= "AND m_cl.class_id=".$options["class"];
		$response = mysql_query($query);
		$majors_array = array();
		$colleges_array = array();
		$globalNode = new Node(NULL,0,"UC Berkeley");
		while ($row = mysql_fetch_assoc($response)) {
			$newNode = new Node(NoteType.nclass, $row['id'], $row['class_name']);
			if (in_array($row["major_id"], $majors_array)) {
				$majorNode = $majors_array[$row["major_id"]];
				$majorNode->addChild($newNode);
			} else {
				$majorNode = new Node(NodeType.major, $row["major_id"], $row['major_name']);
				$majorNode->addChild($newNode);
				$majors_array[$row["major_id"]] = $majorNode;
			}
			if (in_array($row["college_id"], $colleges_array)) {
				$tmpNode = $colleges_array[$row["college_id"]];
				$tmpNode->addChild($majorNode);
			} else {
				$tmpNode = new Node(NodeType.college, $row["college_id"], $row['college_name']);
				$tmpNode->addChild($majorNode);
				$colleges_array[$row["major_id"]] = $tmpNode;
			}
		}
		foreach ($colleges_array as $key => $value) {
			$globalNode->addChild($value);
		}
		return $globalNode;
		*/
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