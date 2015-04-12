/**
 * GChat - PHP-Core Message_Writer-Class
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
<?php

class Message_Writer {

    public function Write_Message($message, $sender) {
	if (!$this->hashtml($message)) {
        	$date = date("Y-m-d H:i:s");
        	$connection = new mysqli(/*DB*/, /*DB-USer*/, /*Password*/, /*Table*/);
        	$return = 0;

        	$id = $connection->query("SELECT max(id) as id FROM messages ");
        	$id = $id->fetch_all();
        	$id_ = $id[0][0] + 1;

        	$sql_str = "INSERT INTO messages (`id`, `message_text`, `message_sender`, `date`) VALUES (?, ?, ?, ?)";

        	if ($stmt = $connection->prepare($sql_str)) {
        	    $stmt->bind_param("isss", $id_, $message, $sender, $date);
        	    $return = $stmt->execute();
        	}
//      	  print_r($id_ . $message . $sender . $date);
        	$connection->close();
        	return $return;
	} else {
            	return 0;
        }
    }

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

}
