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

}