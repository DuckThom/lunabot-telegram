<?php

/*************************************
 * Class GroupChat
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API GroupChat array
 *************************************/
class GroupChat {

	private $id;
	private $title;

	public function __construct($input)
	{
		$this->id 		= $input["id"];
		$this->title 	= $input["title"];
	}

	/**
	 * Group chat ID
	 *
	 * @return int
	 */
	public function getId()
	{
		return (int) $this->id;
	}

	/**
	 * Group chat name
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return (string) $this->title;
	}

}