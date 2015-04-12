$(document).ready(function() {
    var chat_window = $(".chat_window_container");
    var chat_history = $(".chat_history");
    var chat_text_input = $(".chat_text_input");
    var chat_name_input = $(".chat_name_input");
    var chat_send_button = $(".chat_send_button");
    var online_container = $(".onlinecontainer");
    var last_call = "";
    var last_search_for_users = "";
    var n_s = false;
    var own_name = "";
    clearall();
    set_call();

//    $(function() {
//        $.ajax({
//            url: "modules/ajax_chat/backend/gchat_core.php",
//            type: "POST",
//            data: {type: "snu"}
//        })
//                .done(function(data) {
//                    if (data.length > 0)
//                    {
//                        var return_ = JSON.parse(data);
//
//                        for (var x = 0; x < return_.length; x++)
//                        {
//                            //padding-left: 15px;
//                            var str = '<div><span>[' + return_[x]["date"] + '|***' + return_[x]["sender"] + '***]:</span><span style="display: inline;">' + return_[x]["message_text"] + "</span></div>";
////                            var srch_str = $("#item_" + last_call_ + "");
//                            var srch_str = '[' + return_[x]["date"] + '|***' + return_[x]["sender"] + '***]:' + return_[x]["message_text"] + "";
//                            var y = chat_history.text().indexOf(srch_str);
//                            if (y == -1)
//                            {
//                                chat_history.append(str);
//                            }
//                        }
//                        chat_history.animate({scrollTop: $(document).height()}, "slow");
//                    }
////                    $("#removable_div").remove();
//                })
//                .fail(function() {
//                    chat_history.append("Cannot load chat history...");
//                })
//                .always(function() {
//                    set_call();
////                    alert("complete");
//                });
//    });

    setInterval(function() {

        get_messages();
        get_online_users();
    }, 5000);

    $(".chat_name_input").on("change", function() {
        console.log("123");
    });

    function get_messages()
    {
//        chat_history.append('<div id="removable_div">Getting Messages</div>');
        $.ajax({
            url: "modules/ajax_chat/backend/gchat_core.php",
            type: "POST",
            data: {time: last_call}
        })
                .done(function(data) {
                    if (data.length > 0)
                    {
                        var return_ = JSON.parse(data);

                        for (var x = 0; x < return_.length; x++)
                        {
                            //padding-left: 15px;
                            var str = '<div><span>[' + return_[x]["date"] + '|***' + return_[x]["sender"] + '***]:</span><span style="display: inline;">' + return_[x]["message_text"] + "</span></div>";
//                            var srch_str = $("#item_" + last_call_ + "");
                            var srch_str = '[' + return_[x]["date"] + '|***' + return_[x]["sender"] + '***]:' + return_[x]["message_text"] + "";
                            var y = chat_history.text().indexOf(srch_str);
                            if (y == -1)
                            {
                                chat_history.append(str);
                            }
                        }
                        chat_history.animate({scrollTop: $(document).height()}, "slow");
                    }
//                    $("#removable_div").remove();
                })
                .fail(function() {
                    chat_history.append("Cannot load chat history...");
                })
                .always(function() {
                    set_call();
//                    alert("complete");
                });
    }

    function send_messages(message, sender)
    {
        if (sender != "" && message != "")
        {
            $.ajax({
                url: "modules/ajax_chat/backend/gchat_core.php",
                type: "POST",
                data: {type: "m", message: message, sender: sender}
            })
                    .done(function(data) {
//                    alert(data);
                    })
                    .fail(function(data) {
                        alert(data);
                    })
                    .always(function() {
//                    alert("complete");
                    });
        }
    }

    function get_online_users()
    {
        if ($(".chat_name_input").val() != "")
        {
            own_name = $(".chat_name_input").val();
        }
        else
        {
            own_name = "123";
        }
        $.ajax({
            url: "modules/ajax_chat/backend/gchat_core.php",
            type: "POST",
            data: {type: "gou", own_name: own_name}
        })
                .done(function(data) {
                    if (data.length > 0)
                    {
                        console.log(data);
                        var return_ = JSON.parse(data);

                        for (var x = 0; x < return_.length; x++)
                        {
                            console.log(return_[x]["username"]);
                            var srch_str = "[" + return_[x]["username"] + "]";
                            var str = "<div><span>" + srch_str + "</span></div>";
                            var y = online_container.text().indexOf(srch_str);
                            if (y == -1)
                            {
                                online_container.append(str);
                            }
                            else
                            {
                                continue;
                            }
                        }
                    }
                    else
                    {
                        console.log(data);
                    }
                }
                )
                .fail(function(data) {
                    for (var x = 0; x < data.length; x++)
                        alert(data[x]);
                })
                .always(function() {
//                    alert("complete");
                });
    }

    chat_send_button.on("click", function() {
        var message = chat_text_input.val();
        var sender = chat_name_input.val();
        chat_text_input.val("");
        send_messages(message, sender);
    });

    chat_text_input.keypress(function(e) {
        if (e.which === 13)
        {
            var message = chat_text_input.val();
            var sender = chat_name_input.val();
            chat_text_input.val("");
            send_messages(message, sender);
        }
    });

    function clearall()
    {
        chat_history.html("");
        chat_text_input.val("");
        chat_name_input.val("");
    }

    function set_call()
    {
        var date = new Date();
        var curr_day = 0;
        if (date.getDate() > 0 && date.getDate() < 10)
        {
            curr_day = "0" + date.getDate();
        }
        else
        {
            curr_day = date.getDate();
        }
        var curr_month = 0;
        if (date.getMonth() > 0 && date.getMonth() < 10)
        {
            curr_month = "0" + (date.getMonth() + 1);
        }
        else
        {
            curr_month = (date.getMonth() + 1);
        }
        var curr_year = date.getFullYear();
        var curr_sec = 0;
        if (date.getSeconds() >= 0 && date.getSeconds() < 10)
        {
            curr_sec = "0" + date.getSeconds();
        }
        else
        {
            curr_sec = date.getSeconds();
        }
        var curr_min = 0;
        if (date.getMinutes() >= 0 && date.getMinutes() < 10)
        {
            curr_min = "0" + date.getMinutes();
        }
        else
        {
            curr_min = date.getMinutes();
        }
        var curr_hour = 0;
        if (date.getHours() >= 0 && date.getHours() < 10)
        {
            curr_hour = "0" + date.getHours();
        }
        else
        {
            curr_hour = date.getHours();
        }
        last_call = curr_year + "-" + curr_month + "-" + curr_day + " " + curr_hour + ":" + curr_min + ":" + curr_sec;
    }
});