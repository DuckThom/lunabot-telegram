<?php

/*************************************
 * Class Message
 *
 * This class will be used to parse the result array
 *
 * @var Telegram bot API Message array
 *************************************/
class Message {

    private $message_id;
    public  $from;
    private $date;
    public  $chat;
//  public  $forward_from;
//  private $forward_date;
//  public  $reply_to_message;
    private $text;
//  public  $audio;
//  public  $document;
//  public  $photo;
    public  $sticker;
//  public  $video;
//  public  $contact;
//  public  $location;
//  public  $new_chat_member;
//  public  $left_chat_member;
//  private $new_chat_title;
//  public  $new_chat_photo;
    private $type;

    public function __construct($input)
    {
        $this->message_id       = $input["message_id"];
        $this->from             = new User($input["from"]);
        $this->date             = $input["date"];
        $this->chat             = (isset($input["chat"]["title"])         ? new GroupChat($input["chat"])             : new User($input["chat"]));
//      $this->forward_from     = (isset($input["forward_from"])          ? new User($input["forward_from"])          : false);
//      $this->forward_date     = (isset($input["forward_date"])          ? $input["forward_date"]                    : false);
//      $this->reply_to_message = (isset($input["reply_to_message"])      ? new Message($input["reply_to_message"])   : false);
        $this->text             = (isset($input["text"])                  ? $input["text"]                            : false);
//      $this->audio            = (isset($input["audio"])                 ? new Audio($input["audio"])                : false);
//      $this->document         = (isset($input["document"])              ? new Document($input["document"])          : false);
//      $this->photo            = (isset($input["photo"])                 ? new Photo($input["photo"])                : false);
        $this->sticker          = (isset($input["sticker"])               ? new Sticker($input["sticker"])            : false);
//      $this->video            = (isset($input["video"])                 ? new Video($input["video"])                : false);
//      $this->contact          = (isset($input["contact"])               ? new Contact($input["contact"])            : false);
//      $this->location         = (isset($input["location"])              ? new Location($input["location"])          : false);
//      $this->new_chat_member  = (isset($input["new_chat_participant"])  ? new User($input["new_chat_participant"])  : false);
//      $this->left_chat_member = (isset($input["left_chat_participant"]) ? new User($input["left_chat_participant"]) : false);
//      $this->new_chat_title   = (isset($input["new_chat_title"])        ? $input["new_chat_title"]                  : false);
//      $this->new_chat_photo   = (isset($input["new_chat_photo"])        ? new Photo($input["new_chat_photo"])       : false);

        if ($this->text)
            $this->type = 'text';
//      elseif ($this->audio)
//          $this->type = 'audio';
//      elseif ($this->document)
//          $this->type = 'document';
//      elseif ($this->photo)
//          $this->type = 'photo';
        elseif ($this->sticker)
            $this->type = 'sticker';
//      elseif ($this->video)
//          $this->type = 'video';
//      elseif ($this->contact)
//          $this->type = 'contact';
//      elseif ($this->location)
//          $this->type = 'location';
//      elseif ($this->new_chat_member || $this->left_chat_member || $this->new_chat_title || $this->new_chat_photo)
//          $this->type = 'notice';
        else
            $this->type = 'unknown';

    }
    
    /**
     * @return int
     */
    public function getMessageId()
    {
        return (int) $this->message_id;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return (int) $this->date;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return (string) $this->type;
    }

    /**
     * @return mixed
     */
    public function getCommand()
    {
        // Split the message in to [command] - [arguments]
        $command = preg_replace("/\//", "", explode(" ", $this->text));

        if (strrpos($command[0], "@") !== false)
        {
            // Split the command and the target
            $command = explode("@", $command[0]);

            // Return the command without the target
            return (isset($command[0]) ? $command[0] : false);
        }
        
        // Return the command or false
        return (isset($command[0]) ? $command[0] : false);
    }

    /**
     * @return mixed
     */
    public function getArgument()
    {
        // Split the message in to [command] - [arguments]
        $array = explode(" ", $this->text);

        // Return the arguments or an empty string
        return (isset($array[1]) ? $array[1] : '');
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        // Split the message in to [command] - [arguments]
        $command = preg_replace("/\//", "", explode(" ", $this->text));

        if (strrpos($command[0], "@") !== false)
        {
            // Split the command and the target
            $botName = explode("@", $command[0]);

            // Return the target without the command
            return (isset($botName[1]) ? $botName[1] : false);
        }
        
        // Return false because no target was found
        return false;
    }
}