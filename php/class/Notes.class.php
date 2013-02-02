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