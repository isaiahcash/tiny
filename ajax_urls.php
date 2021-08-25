<?php
require_once('includes/config.php');
$output['data'] = [];

$sql = "SELECT url_id, short_key, full_url, date_created FROM urls";
$query = DB::query($sql);
while($result = $query->fetch(PDO::FETCH_ASSOC))
{

    $result['tiny_url'] = "https://isaiahcash.com/tiny/" . $result['short_key'];

    $output['data'][] = $result;
}

echo json_encode($output);


?>
