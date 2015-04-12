/**
 * GChat - PHP-Core
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
<?php

error_reporting(0);
mysqli_report(MYSQLI_REPORT_ERROR);
include '../../../backend/Sql_Connect.php';
include './classes/Message_Object.php';
include './classes/Write_Message.php';
include './classes/get_message.php';
include './classes/online_users.php';

$ip_address = $_SERVER["REMOTE_ADDR"];
$type = $_POST["type"];
$date = $_POST["time"];
$message = $_POST["message"];
$sender = $_POST["sender"];
$own_name = $_POST["own_name"];

if (!isset($type)) {
    $message_receiver = new Message_Receiver();
    $x = $message_receiver->get_messages($date);
    echo json_encode($x);
} else if (isset($type) && isset($message) && $type == "m") {
    $message_writer = new Message_Writer();
    echo $message_writer->write_message($message, $sender);
} else if (isset($type) && $type == "gou") {
    $online_users = new Online_Users();
    $set = $online_users->set_self($own_name, $ip_address);
    if ($set == 1 || $set == 2) {
        $result = $online_users->get_users();
    } else {
        return;
    }
    echo json_encode($result);
}

