<?php

require base_path('headers.php');

use Core\Database;
use Http\Forms\RegistrationForm;
use Core\Response;

$id = $_POST['email'];

$errors = [];

$form = new RegistrationForm();

if ($form->validate($id)) {
  $user = storeUser($id)['email'];
  $response['status'] = "$user cím sikeresen regisztrálva.";
  http_response_code(Response::SUCCESS);
} else {
  http_response_code(Response::BAD_REQUEST);
}

function storeUser($email)
{
  $config = require base_path('config.php');
  $db = new Database($config['database'], $config['username'], $config['password']);
  $query = "insert into users (email, password) values (:email, :password)";
  $db->query($query, [
    ':email' => $email,
    ':password' => password_hash('123456', PASSWORD_BCRYPT)
  ]);

  $userId = $db->lastInsertId();
  $query = "SELECT * FROM users WHERE id = :id";
  return $db->query($query, [':id' => $userId])->find();
}

if ($form->errors()) $response['errors'] = $form->errors();
echo json_encode($response);