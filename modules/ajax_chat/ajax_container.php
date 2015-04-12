/**
 * GChat - HTML-Frontend
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */
<?php
<?php
include 'modules/ajax_chat/backend/Load_Scripts.php';
?>
<div class="chat_name_input_">
    <input class="chat_name_input" placeholder="Type in your name..." />
</div>

<div class="chat_window_container">
    <div class="chat_history"></div>
    <input class="chat_text_input" placeholder="Type in your message..." />
    <div class="chat_send_button">
        <span class="chat_send_button_text">
            Send!
        </span>
    </div>
</div>
<div class="whoisonline">
    <div class="onlinecontainer">
    </div>
</div>