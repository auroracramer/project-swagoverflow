<?php

class Node
{
	public $id, $type, $name, $links, $children = array();
	function __construct($id=NULL, $type=NULL, $name=NULL, $links = array())
	{
		$this->id = $id;
		$this->type = $type;
		$this->name = $name;
		$this->links = $links;
	}
	
	function addChild($e)
	{
		$this->children[] = $e;
	}
	
	function toD3Array($id = 0, $parent = 0, $group = 0)
	{
		if ($id == 0)
		{
			$ret = array("nodes" => array(), "links" => array());
			$ret["nodes"][] = array("name" => $this->name, "group" => $group);
			foreach ($this->children as $child)
			{
				$tarr = $child->toD3Array(sizeof($ret["nodes"]), $parent, $group+1);
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
					$tarr = $child->toD3Array($id + sizeof($ret[0]), $id, $group+1);
					$ret[0] = array_merge($ret[0], $tarr[0]);
					$ret[1] = array_merge($ret[1], $tarr[1]);
				}
			}
			
			return $ret;
		}
	}

	static function fromXML($xml)
	{
		$xml = file_get_contents($xml);
		$p = xml_parser_create();
		$scope = array();
		$ret = array();
		while (xml_parse_into_struct($p, $xml, $vals, $index))
		{
			var_dump($vals);
			for ($i=0; $i<sizeof($vals); $i++)
			{
				echo "1";
				if (($vals[$i]["tag"]=="NODE") && ($vals[$i]["type"]=="open"))
				{
					if (sizeof($scope)==0) $current_node = new Node();
					else
					{
						$current_node = new Node();
						$scope[sizeof($scope)-1]->addChild($current_node);
					}
				}
				elseif (($vals[$i]["tag"]=="NODE") && ($vals[$i]["type"]=="close"))
				{
					if (sizeof($scope)==0) $ret[] = $current_node;
					else
					{
						$current_node = new Node();
						$scope[sizeof($scope)-1]->addChild($current_node);
					}
				}
				elseif (($vals[$i]["tag"]=="ID")) $current_node->id = $vals[$i]["value"];
				elseif (($vals[$i]["tag"]=="NAME")) $current_node->name = $vals[$i]["value"];
				elseif (($vals[$i]["tag"]=="ID")) $current_node->id = $vals[$i]["value"];
				elseif (($vals[$i]["tag"]=="TYPE")) $current_node->id = $vals[$i]["value"];
				elseif (($vals[$i]["tag"]=="CHILDREN") && ($vals[$i]["type"]=="open")) $scope[] = $current_node;
				elseif (($vals[$i]["tag"]=="CHILDREN") && ($vals[$i]["type"]=="close")) $current_node = array_pop($scope);
			}
		}
		xml_parser_free($p);

		return $ret;
	}
}

?>