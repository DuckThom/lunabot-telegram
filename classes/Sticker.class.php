<?php

/*************************************
 * Class Sticker
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API Sticker array
 *************************************/
class Sticker {

	private $file_id;
	private $width;
	private $height;
	public  $thumb;
	private $file_size;

	public function __construct($input)
	{
		$this->file_id 	 = $input["file_id"];
		$this->width 	 = $input["width"];
		$this->height 	 = $input["height"];
		$this->thumb 	 = new PhotoSize($input["thumb"]);
		$this->file_size = (isset($input["file_size"]) ? $input["file_size"] : false);
	}

	/**
	 * @return string
	 */
	public function getFileId()
	{
		return (string) $this->file_id;
	}

	/**
	 * @return int
	 */
	public function getWidth()
	{
		return (int) $this->width;
	}

	/**
	 * @return int
	 */
	public function getHeight()
	{
		return (int) $this->height;
	}

	/**
	 * @return mixed
	 */
	public function getFileSize()
	{
		return $this->file_size;
	}

}