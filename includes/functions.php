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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="https://isaiahcash.com/tiny/includes/css/style.css">
    </head>
    <body>
    <div class="d-block" style="background-color: #e9ecef">
        <a class="btn btn-primary btn-large m-1" href="/home/projects.php"><i class="fas fa-arrow-left"></i> Return to Isaiah's Website</a>
    </div>
    <?php
}

function script_includes()
{
    ?>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://isaiahcash.com/tiny/includes/js/scripts.js"></script>
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

    $params = array("short_key" => $short_key, "full_url" => $full_url);
    $sql = "INSERT INTO urls (short_key, full_url) VALUES (:short_key, :full_url)";
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
    $sql = "INSERT INTO hits (url_id, client_info) VALUES (:url_id, :client_info)";
    $params = array("url_id" => $url_id, "client_info" => $client_info);
    $query = DB::query($sql, $params);

    return $query;

}