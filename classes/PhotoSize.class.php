<?php

/*************************************
 * Class PhotoSize
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API PhotoSize array
 *************************************/
class PhotoSize {

	private $file_id;
	private $width;
	private $height;
	private $file_size;

	public function __construct($input)
	{
		$this->file_id 	 = $input["file_id"];
		$this->width 	 = $input["width"];
		$this->height 	 = $input["height"];
		$this->file_size = (isset($input["file_size"]) ? $input["file_size"] : false);
	}

	/**
	 * Image file ID
	 *
	 * @return string
	 */
	public function getId()
	{
		return (string) $this->file_id;
	}

	/**
	 * Image width
	 *
	 * @return int
	 */
	public function getWidth()
	{
		return (int) $this->width;
	}

	/**
	 * Image height
	 *
	 * @return int
	 */
	public function getHeight()
	{
		return (int) $this->height;
	}

	/**
	 * Image file size
	 *
	 * @return mixed
	 */
	public function getFileSize()
	{
		return $this->file_size;
	}

}