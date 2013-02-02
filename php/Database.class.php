<?

//include_once("SessionListTable.php");
//include_once("ApplicationListTable.php");
//include_once("ApplicationRegistryTable.php");
//include_once("PageListTable.php");
/*
this class is a collection of static methods used to
create and destroy the database.
*/
class Database
{
	static function connect()
	{
		$mysql_connection = mysql_connect("localhost", "proje108_quiggle", "quiggle");
		$connected =  mysql_select_db("proje108_quiggle", $mysql_connection);
		
		if(!$connected) echo "Connection Fail: ".mysql_error()."<br />";
		else Debug::write("Successfully connected to database");
		
		return $mysql_connection;
	}
	
	static function mysql_table_exists($tableName)
	{
		$tables = mysql_list_tables("proje108_quiggle");
		$numRows = mysql_num_rows($tables);
		for ($i = 0; $i < $numRows; $i++)
		{
			if (mysql_tablename($tables, $i)===$tableName) return true;
		}
		
		return false;
	}
}

?>