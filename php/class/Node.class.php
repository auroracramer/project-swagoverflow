<?php

class Node
{
	public $id, $name, $links, $children = array();
	function __construct($type, $id, $name, $links = array())
	{
		$this->id = $id;
	}
	
	function addChild($e)
	{
		$this->children[] = $e;
	}
	
	function toArray()
	{
		
	}
}

?>