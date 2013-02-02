<?

include_once("SessionListTable.php");
include_once("ApplicationListTable.php");
include_once("ApplicationRegistryTable.php");
include_once("PageListTable.php");
/*
this class is a collection of static methods used to
create and destroy the database.
*/
class Database
{
	static function connect()
	{
		$mysql_connection = mysql_connect("localhost", "proje108_registr", "UpR]FS(gbuhB");
		$connected =  mysql_select_db("proje108_registry", $mysql_connection);
		
		if(!$connected) echo "Connection Fail: ".mysql_error()."<br />";
		else Debug::write("Successfully connected to database");
		
		return $mysql_connection;
	}
	
	static function mysql_table_exists($tableName)
	{
		$tables = mysql_list_tables("proje108_registry");
		$numRows = mysql_num_rows($tables);
		for ($i = 0; $i < $numRows; $i++)
		{
			if (mysql_tablename($tables, $i)===$tableName) return true;
		}
		
		return false;
	}
	
	static function destroy()
	{
		ApplicationListTable::destroy();
		ApplicationRegistryTable::destroy();
		//UserTableListTable::destroy();
		SessionListTable::destroy();
		PageListTable::destroy();
	}
	
	static function create()
	{
		ApplicationListTable::create();
		ApplicationRegistryTable::create();
		//UserTableListTable::create();
		SessionListTable::create();
		PageListTable::create();
	}
	
	static function init()
	{
		ApplicationListTable::init();
		ApplicationRegistryTable::init();
		//UserTableListTable::init();
		SessionListTable::init();
		PageListTable::init();
	}
	
	static function clear()
	{
		ApplicationListTable::clear();
		ApplicationRegistryTable::clear();
		//UserTableListTable::clear();
		SessionListTable::clear();
		PageListTable::init();
	}
	
	static function printContents()
	{
		ApplicationListTable::printContents();
		ApplicationRegistryTable::printContents();
		//UserTableListTable::printContents();
		SessionListTable::printContents();
		PageListTable::printContents();
	}
}

?>