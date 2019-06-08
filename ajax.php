<?php
require_once('includes/config.php');

$output = array('flag' => '', 'message' => '');

$rand = rand(0, 100);

if(isset($_POST)){
    $full_url = $_POST['full_url'];

    // Remove all illegal characters from url
    $full_url = filter_var($full_url, FILTER_SANITIZE_URL);


    if(check_full_url($full_url)) {
        $row = search_full_url($full_url);
        if ($row != false) {
            $output['flag'] = 1;
            $output['message'] = "This URL already existed!<br><br>" . get_button($rand, $row['short_key']);
            echo json_encode($output);
            exit;
        }

        $row = create_new_url($full_url);
        if ($row != false) {
            $output['flag'] = 1;
            $output['message'] = "You created a brand new URL!<br><br>" . get_button($rand, $row['short_key']);
            echo json_encode($output);
            exit;
        }
    }
}

$output['flag'] = 0;
$output['message'] = "Error. Make sure to use 'http://' or 'https://' in the URL.";
echo json_encode($output);
exit;

function get_button($rand, $short_key)
{
    $tiny_address = "https://isaiahcash.com/tiny/";

    $button =
        "<div class='input-group mb-2'>"
        . "<input type='text' id='copy_url-" . $rand . "' class='form-control' placeholder='URL' value='" . $tiny_address . $short_key . "' contenteditable='true'>"
        . "<div class='input-group-append'>"
        . "<button class='btn btn-success' type='button' id='click_copy-" . $rand . "' onclick='copy_text(" . $rand . ")'>Click to copy!</button>"
        . "</div>"
        . "</div>";

    return $button;
}