<?php
require_once('includes/config.php');
$output['data'] = [];

$sql = "SELECT u.short_key, u.full_url, h.client_info, h.hit_timestamp FROM hits h LEFT JOIN urls u ON h.url_id = u.url_id";
$query = DB::query($sql);
while($result = $query->fetch(PDO::FETCH_ASSOC))
{
    $output['data'][] = $result;
}

echo json_encode($output);


?>
