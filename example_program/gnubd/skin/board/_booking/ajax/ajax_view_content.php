<?php
include_once('./_common.php');

$result  = sql_fetch(" select wr_content from $write_table where wr_id = '{$_POST['id']}' ");
$result['wr_content'] = str_replace("<img src", "<img style='max-width: 100%;' src", $result['wr_content']);
echo json_encode($result['wr_content']);
?>