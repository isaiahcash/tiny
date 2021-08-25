<?php
require_once('includes/config.php');

$output = array('flag' => '', 'message' => '');

$rand = rand(0, 100);

if(isset($_POST)) {

    $secret_key = "6LcK1gUcAAAAAAoiIyAAcaJZctRB7GcvIR96cuL1";
    $response = $_POST['g-recaptcha-response'];
    $remote_ip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $response . "&remoteip=" . $remote_ip;
    $google_response = file_get_contents($url);
    if ($google_response !== false) {
        $google_response = json_decode($google_response);

        if (isset($google_response->success) && $google_response->success == true) {


            $full_url = $_POST['full_url'];

            // Remove all illegal characters from url
            $full_url = filter_var($full_url, FILTER_SANITIZE_URL);


            if (check_full_url($full_url)) {
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
        else{
            $output['flag'] = 0;
            $output['message'] = "Error. The reCAPTCHA failed. Please try again.";
        }
    }
    else{
        $output['flag'] = 0;
        $output['message'] = "Error. The reCAPTCHA connection to Google failed. Please try again.";
    }
}

$output['flag'] = 0;
$output['message'] = "Error. Make sure to use 'http://' or 'https://' in the URL.";
echo json_encode($output);
exit;

