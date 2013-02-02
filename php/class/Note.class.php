<?php

class Note
{
	public $college, $field, $nclass, $subject, $difficulty, $tags, $title, $body;
	function __construct($college_or_fetch, $major = NULL, $field = NULL, $nclass = NULL, $subject = NULL, $difficulty = NULL, $tags = NULL, $title = NULL, $body = NULL)
	{
		if (is_array($college_or_fetch))
		{
			$this->college = $college_or_fetch["college"];
			$this->major = $college_or_fetch["major"];
			$this->field = $college_or_fetch["field"];
			$this->nclass = $college_or_fetch["class"];
			$this->subject = $college_or_fetch["subject"];
			$this->difficulty = $college_or_fetch["difficulty"];
			$this->tags = explode(" ", $college_or_fetch["tags"]);
			$this->title = $college_or_fetch["title"];
			$this->body = $college_or_fetch["body"];
		}
		elseif (is_string($college_or_fetch)&&$major!=NULL&&$field!=NULL&&$nclass!=NULL&&$subject!=NULL&&$difficulty!=NULL&&$tags!=NULL&&$title!=NULL&&$body!=NULL)
		{
			$this->college = $college;
			$this->major = $major;
			$this->field = $field;
			$this->nclass = $nclass;
			$this->subject = $subject;
			$this->difficulty = $difficulty;
			$this->tags = explode(" ", $tags);
			$this->title = $title;
			$this->body = $body;
		}
		else
		{
			// We've been supplied an incompatible/invalid argument set	
		}
	}
}

?>