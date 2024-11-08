<?php

require base_path('headers.php');

use Core\Database;

$json = file_get_contents('php://input');
$input = json_decode($json, true);

$id = $input['id'];

$config = require base_path('config.php');
$db = new Database($config['database'], $config['username'], $config['password']);

$query = "SELECT * FROM events WHERE id = :id";
$players = $db->query($query, [':id' => $id])->find();

$categoryQuery = "SELECT * FROM eventCategories WHERE eventId = :eventId";
$players['categories'] = $db->query($categoryQuery, [':eventId' => $id])->get();

$extraFeesQuery = "SELECT * FROM extraFees WHERE eventId = :eventId";
$players['extraFees'] = $db->query($extraFeesQuery, [':eventId' => $id])->get();

echo json_encode($players);
