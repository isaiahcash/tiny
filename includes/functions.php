<?php

function start_page()
{
    ?>
    <!DOCTYPE HTML>
    <html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Tiny URL Service</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="/tiny/includes/css/font-awesome.css">
        <link rel="stylesheet" href="/tiny/includes/css/bootstrap.css">

        <link rel="stylesheet" href="https://isaiahcash.com/business/includes/source/datatables/datatables.css">
        <link rel="stylesheet" href="https://isaiahcash.com/business/includes/source/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.css">

        <link rel="stylesheet" href="/tiny/includes/css/style.css">

    </head>
    <body>
    <?php
}

function script_includes()
{
    ?>
    <script src="/tiny/includes/js/jquery-3.js"></script>
    <script src="/tiny/includes/js/bootstrap.js"></script>
    <script src="/tiny/includes/js/popper.js"></script>


    <script src="https://isaiahcash.com/rake/includes/source/datatables/datatables.js"></script>
    <script src="https://isaiahcash.com/rake/includes/source/datatables/DataTables-1.10.18/js/dataTables.bootstrap4.js"></script>

    <script src="/tiny/includes/js/scripts.js"></script>
    <?php
}

function end_page()
{
    ?>
    </body>
    </html>
    <?php
}

function search_short_key($short_key)
{
    $params = array("short_key" => $short_key);
    $sql = "SELECT * FROM urls WHERE short_key = :short_key";
    $query = DB::query($sql, $params);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function search_full_url($full_url)
{
    $params = array("full_url" => $full_url);
    $sql = "SELECT * FROM urls WHERE full_url = :full_url";
    $query = DB::query($sql, $params);
    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function create_new_url($full_url)
{
    $short_key = generate_short_key();

    $params = array("short_key" => $short_key, "full_url" => $full_url, "date_created" => date('Y-m-d H:i:s'));
    $sql = "INSERT INTO urls (short_key, full_url, date_created) VALUES (:short_key, :full_url, :date_created)";
    $query = DB::query($sql, $params);

    if($query != false)
    {
        $row = search_short_key($short_key);
        return $row;
    }

    return false;
}

function generate_short_key()
{
    $row = true;
    while($row != false)
    {
        $short_key = random_string(5);
        $row = search_short_key($short_key);
    }

    return $short_key;
}

function random_string($length = 5)
{
    $chars = '0123456789abcdefghijklmnopqrstuvwxyz';
    $chars_len = strlen($chars);
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $chars[rand(0, $chars_len - 1)];
    }
    return $random_string;
}

function check_full_url($full_url)
{
    if($full_url != "")
    {
        // Validate url
        if (filter_var($full_url, FILTER_VALIDATE_URL) !== false) {
            return true;
        }
    }
    return false;
}

function push_client_info($url_id)
{
    $data = new GetDataPlugin();
    $client_info = "";
    $client_info .= "\r\nIP               " . $data->ip();
    $client_info .= "\r\nOperative System " . $data->os();
    $client_info .= "\r\nBrowser          " . $data->browser();
    $client_info .= "\r\nScreen height    " . $data->height();
    $client_info .= "\r\nScreen width     " . $data->width();
    $client_info .= "\r\nJava enabled     " . $data->javaenabled();
    $client_info .= "\r\nCookie enabled   " . $data->cookieenabled();
    $client_info .= "\r\nLanguage         " . $data->language();
    $client_info .= "\r\nArchitecture     " . $data->architecture();
    $client_info .= "\r\nDevice           " . $data->device();
    $client_info .= "\r\nCountry          " . $data->geo('country');
    $client_info .= "\r\nRegion           " . $data->geo('region');
    $client_info .= "\r\nContinent        " . $data->geo('continent');
    $client_info .= "\r\nCity             " . $data->geo('city');
    $client_info .= "\r\nLogitude         " . $data->geo('logitude');
    $client_info .= "\r\nLatitude         " . $data->geo('latitude');
    $client_info .= "\r\nCurrency         " . $data->geo('currency');
    $client_info .= "\r\nProvetor         " . $data->provetor();
    $client_info .= "\r\nAgent            " . $data->agent();
    $client_info .= "\r\nReferer          " . $data->referer();
    $client_info .= "\r\nDate             " . $data->getdate();

    $hit_timestamp = date('Y-m-d H:i:s');

    $sql = "INSERT INTO hits (url_id, client_info, hit_timestamp) VALUES (:url_id, :client_info, :hit_timestamp)";
    $params = array("url_id" => $url_id, "client_info" => $client_info, "hit_timestamp" => $hit_timestamp);
    $query = DB::query($sql, $params);

    return $query;

}

function get_button($rand, $short_key)
{
    $tiny_address = "https://isaiahcash.com/tiny/";

    $button =
        "<div class='input-group mb-2'>"
        . "<input type='text' id='copy_url-" . $rand . "' class='form-control' placeholder='URL' value='" . $tiny_address . $short_key . "' contenteditable='true' readonly='true'>"
        . "<div class='input-group-append'>"
        . "<button class='btn btn-success' type='button' id='click_copy-" . $rand . "' onclick='copyText(" . $rand . ")'>Click to copy!</button>"
        . "</div>"
        . "</div>";

    return $button;
}
