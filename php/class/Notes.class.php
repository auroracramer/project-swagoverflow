<?php
include('Database.class.php');
Database::connect();
class Notes
{
	static function generateTree ($options = NULL)
	{
		if ($options == NULL)
		{
			// Generate generic tree
		}
		else
		{
//                        $query_colleges= "SELECT DISTINCT college FROM notes";
//                        $response_colleges = mysql_query($query_colleges);
//                        
//                        while ($row=mysql_fetch_assoc($response_colleges)) {
//                            $majors = "SELECT * FROM notes WHERE college=".$row['college'];
//                            $response_majors = mysql_query($majors);
//                        }
//                        
//                        $query_majors= "SELECT college FROM notes GROUP By college";
//                        $response_majors = mysql_query($query_majors);
//                            
//                        $query_classes= "SELECT college FROM notes GROUP By college";
//                        $response_classes = mysql_query($query_classes);
                    
                    $query = "SELECT n.title, n.id, com.college_id, cl.major_id, cl.class_id FROM colleges_majors com, majors_classes cl, notes n WHERE com.major_id=cl.major_id 
                        AND cl.class_id=n.class";
                    $response = mysql_query($query);
                    while ($row = mysql_fetch_assoc($query)) {
                        $newNote = new Note($row);
                    }
                    
		}
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