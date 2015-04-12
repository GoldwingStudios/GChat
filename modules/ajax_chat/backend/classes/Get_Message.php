/**
 * GChat - PHP-Core Message_Receiver-Class
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
<?php

class Message_Receiver {

    function get_messages($date) {

        $date = new DateTime($date);
        $return_messages = array();
        $sql_receiver = new sql_connect();
        $sql_str = "SELECT * FROM messages WHERE date>='" . $date->format("Y-m-d H:i:s") . "' ";
        $return = $sql_receiver->return_array($sql_str);
        foreach ($return as $r) {
	if (!$this->hashtml($r["message_text"])) {
            $message_object = new Message_Object();
            $message_object->id = $r["id"];
            $message_object->message_text = $r["message_text"];
            $message_object->sender = $r["message_sender"];
            $message_object->date = $r["date"];
            array_push($return_messages, $message_object);
        }
	}
        return $return_messages;
    }

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

}
