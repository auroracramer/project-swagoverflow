<?php

class Node
{
	public $id, $name, $links, $children = array();
	function __construct($type, $id, $name, $links = array())
	{
		$this->type = $type;
		$this->id = $id;
		$this->name = $name;
		$this->links = $links;
	}
	
	function addChild($e)
	{
		$this->children[] = $e;
	}
	
	function toArray($id = 0, $parent = 0, $group = 0)
	{
		if ($id == 0)
		{
			$ret = array("nodes" => array(), "links" => array());
			$ret["nodes"][] = array("name" => $this->name, "group" => $group);
			foreach ($this->children as $child)
			{
				$tarr = $child->toArray(sizeof($ret["nodes"]), $parent, $group+1);
				$ret["nodes"] = array_merge($ret["nodes"], $tarr[0]);
				$ret["links"] = array_merge($ret["links"], $tarr[1]);
			}
			
			return $ret;
		}
		else
		{
			$ret = array(array(), array());
			$i = 1;
			$ret[0][] = array("name" => $this->name, "group" => $group);
			$ret[1][] = array("source" => $parent, "target" => $id, "value" => 3);
			if (sizeof($this->children) > 0)
			{
				foreach ($this->children as $child)
				{
					$tarr = $child->toArray($id + sizeof($ret[0]), $id, $group+1);
					$ret[0] = array_merge($ret[0], $tarr[0]);
					$ret[1] = array_merge($ret[1], $tarr[1]);
				}
			}
			
			return $ret;
		}
	}
}

?>