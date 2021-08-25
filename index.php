<?php
require_once('includes/config.php');

if(isset($_GET['url']))
{
    $sk = $_GET['url'];
    $row = search_short_key($sk);
    if($row != false)
    {
        push_client_info($row['url_id']);
        header('location: ' . $row['full_url']);
        die;
    }
}

start_page();

navigate_home();

?>

<div class="container">
    <div class="row mt-5">
        <div class="col-xs-12 col-md-6 col-lg-4 mt-2">
            <h3>Tiny URL Service</h3>
            <h5>Create a new tiny URL.</h5>

            <form>
                <label for="full_url">Full URL:</label>
                <input type="text" id="full_url" name="full_url" class="form-control">
                <br>

                <div class="g-recaptcha" data-sitekey="6LcK1gUcAAAAAA7JkydG_qI3GOSnJnfXLFvXEKDb"></div>

                <button type="submit" id="submit_button" name="submit_button" class="btn btn-primary mt-3">Submit</button>
            </form>

        </div>
        <div class="col-xs-12 col-md-6 col-lg-8 mt-2">
            <div id="output"></div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-12">
            <h5>Current URLs</h5>
            <div class="table-responsive" style="padding: 5px;">
                <table id="urls" class="table table-bordered table-hover" style="width: 100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Short Key</th>
                        <th>Tiny URL</th>
                        <th>Full URL</th>
                        <th>Created</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h5>URL Hits</h5>
            <div class="table-responsive" style="padding: 5px;">
                <table id="hits" class="table table-bordered table-hover" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Short Key</th>
                        <th>Full URL</th>
                        <th>Client Info</th>
                        <th>Timestamp</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js"></script>

<?php
script_includes();
?>

<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

<?php
end_page();
?>
