<?php

require base_path('headers.php');

use Core\Database;
use Http\Forms\RegistrationForm;
use Core\Response;

$email = $_POST['email'];

$errors = [];

$form = new RegistrationForm();

if ($form->validate($email)) {
  $registeredEmail = storeEmail($email)['email'];
  $response['status'] = "$registeredEmail cím sikeresen regisztrálva.";
  http_response_code(Response::SUCCESS);
} else {
  http_response_code(Response::BAD_REQUEST);
}

function storeEmail($email)
{
  $config = require base_path('config.php');
  $db = new Database($config['database'], $config['username'], $config['password']);
  $query = "insert into emails (email, owner, project) values (:email, :owner, :project)";
  $db->query($query, [
    ':email' => $email,
    ':owner' => 1,
    ':project' => 1
  ]);

  $lastInsertedId = $db->lastInsertId();
  $query = "SELECT * FROM emails WHERE id = :id";
  return $db->query($query, [':id' => $lastInsertedId])->find();
}

if ($form->errors()) $response['errors'] = $form->errors();
echo json_encode($response);
