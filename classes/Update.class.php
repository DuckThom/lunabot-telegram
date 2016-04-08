<?php

/*************************************
 * Class Update
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API Update array
 *************************************/
class Update {

	private $update_id;
	public  $message;

	public function __construct($input)
	{
		$this->update_id  = $input['update_id'];
		$this->message	  = new Message($input['message']);
	}

	/**
	 * Update ID
	 *
	 * @return int
	 */
	public function getId()
	{
		return $this->update_id;
	}

	/**
	 * Sender ID
	 *
	 * @return int
	 */
	public function getSenderId()
	{
		return $this->message->from->getId();
	}

	public function getSenderFirstName()
	{
		return $this->message->from->getFirstName();
	}

	public function getCommand()
	{
		return $this->message->getCommand();
	}

	public function getTarget()
	{
		return $this->message->getTarget();
	}

	public function getArguments()
	{
		return $this->message->getArgument();
	}

	public function getChatId()
	{
		return $this->message->chat->getId();
	}

}
