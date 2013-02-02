<?php

class Note
{
	public $id, $college, $field, $nclass, $subject, $difficulty, $tags, $title, $body;
	function __construct($college_or_fetch, $major = NULL, $nclass = NULL, $difficulty = NULL, $tags = NULL, $title = NULL, $content = NULL)
	{
		if (is_array($college_or_fetch))
		{
			$this->id = $college_or_fetch["id"];
			$this->college = $college_or_fetch["college"];
			$this->major = $college_or_fetch["major"];
			$this->nclass = $college_or_fetch["class"];
			$this->difficulty = $college_or_fetch["difficulty"];
			$this->tags = explode(" ", $college_or_fetch["tags"]);
			$this->title = $college_or_fetch["title"];
			$this->content = $college_or_fetch["content"];
		}
		elseif (is_int($college_or_fetch)&&$major!=NULL&&$nclass!=NULL&&$difficulty!=NULL&&$tags!=NULL&&$title!=NULL&&$content!=NULL)
		{
			$this->college = $college;
			$this->major = $major;
			$this->nclass = $nclass;
			$this->subject = $subject;
			$this->difficulty = $difficulty;
			$this->tags = explode(" ", $tags);
			$this->title = $title;
			$this->content = $content;
		}
		else
		{
			// We've been supplied an incompatible/invalid argument set	
		}
	}
	
	function toArray()
	{
		return array($this->college, $this->major, $this->nclass, $this->difficulty, $this->tags, $this->title, $this->content);
	}
}

?>