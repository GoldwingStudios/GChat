/**
 * GChat - PHP-Core Online_Users-Class
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
<?php

class Online_Users {

    public function __construct() {
        $this->sql = new sql_connect();
    }

    function get_users() {
        $sql_string = "SELECT id, username, ip_address FROM online_users";
        $users = $this->sql->return_array($sql_string);
        return $users;
    }

    function set_self($own_name, $IP_Address) {
	if (!$this->hashtml($own_name)) {
        $sql_string = "SELECT * FROM online_users WHERE username='$own_name'";
        $users = $this->sql->return_array($sql_string);
        $x = count($users);
        if ($x == 0) {
            //User is not in DB so he has to be added to it
            //if everything went well it will return true and this function will return 2
            if ($this->input_self($own_name, $IP_Address)) {
                return 2;
            }
        } else if ($x == 1) {
            //User is in DB and only this only got this IP
            //Re-Set the name of the User
            if ($this->reset_name($own_name, $IP_Address)) {
                return 1;
            }
        } else if ($x > 1) {
            //There are at least two other users with the same address
            //so he will not be add to the Users list anymore
            return "eheh";
        }
	}
    }

    private function input_self($own_name, $IP_Address) {
        $id = $this->get_max_id();
        $sql_str = "INSERT INTO online_users
            (`id`,`username`,`ip_address`)
            VALUES
            ('$id','$own_name','$IP_Address');";
        return $this->sql->execute($sql_str);
    }

    private function get_max_id() {
        $sql_str = "SELECT max(id) AS id FROM online_users";
        $result = $this->sql->return_row($sql_str);
        $result = $result["id"] + 1;
        return $result;
    }

    private function reset_name($own_name, $IP_Address) {
        $sql = "SELECT * FROM online_users WHERE username='$own_name'";
        $is_in_db = $this->sql->return_array($sql);
        if (count($is_in_db) == 0) {
            $sql_ = "SELECT * FROM online_users WHERE username LIKE '" . $own_name . "%'";
            $name_in_db = $this->sql->return_array($sql_);
            $x = count($name_in_db);
            if ($x == 0) {
                $sql_str = "UPDATE online_users SET username='$own_name' WHERE ip_address='$IP_Address'";
                $return = $this->sql->execute($sql_str);
                return $return;
            } else if ($x > 0) {
                $max_int = 0;
                foreach ($name_in_db as $name) {
                    $username = explode("_", $name["username"]);
                    if (count($username) > 1) {
                        if (is_numeric($username[1])) {
                            $max_int = $max_int + $username[1];
                        }
                    } else if (count($username) == 1) {
                        $max_int += 1;
                    }
                }
                $own_name = $own_name . "_" . $max_int;
                $sql_str = "UPDATE online_users SET username='$own_name' WHERE ip_address='$IP_Address'";
                $return = $this->sql->execute($sql_str);
                return $return;
            }
        } else {
            return true;
        }
    }

    private function hashtml($string) {
        if ($string != strip_tags($string))
            return true;
        else
            return false;
    }

}
