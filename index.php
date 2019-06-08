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
?>
<br>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">
            <h3>Tiny URL Service</h3>
            <h5>Create a new tiny url:</h5>
            <label for="full_url">Full URL:</label>
            <input type="text" id="full_url" name="full_url" class="form-control">
            <br>
            <button id="submit_button" name="submit_button" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-xs-12 col-sm-8 col-md-6">
            <br>
            <div id="output"></div>
        </div>
    </div>
</div>

<?php
script_includes();
end_page();
?>
