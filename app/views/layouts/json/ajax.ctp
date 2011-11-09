<?php
header("Content-Type: application/json");
$json = array(
	'content'  => $content_for_layout,
	'status'   => !empty($status)   ? $status   : 'success',
	'message'  => !empty($message)  ? $message  : '',
	'redirect' => !empty($redirect) ? $redirect : null,
	'data'     => !empty($data) ? $data : '',
);

echo json_encode($json);
?>