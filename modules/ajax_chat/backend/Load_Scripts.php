/**
 * GChat - JavaScript-Loader
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
<?php

$path = "modules/ajax_chat";
$scripts_path = $path . "/js/";

$scripts = glob($scripts_path . "*.js");
foreach ($scripts as $s) {
    echo '<script src="' . $s . '"></script>';
}
?>