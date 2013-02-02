<?php

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
			// Fields that CAN be specified (it can break if some are given but others are not...):
			// college
			// major
			// field
			// class
			// subject
			// difficulty
			// tags (this will be done via PHP)
		}
	}
	
	static function queryToArray($query)
	{
		if ($query && mysql_num_rows($query) > 0)
		{
			$result = array();
			while ($array = mysql_fetch_array($query)) $result[] = new Note($array);
			return $result;
		}
	}
}

?>