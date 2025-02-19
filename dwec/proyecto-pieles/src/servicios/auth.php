<?php
// filepath: /path/to/your/server/auth.php

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$password = $data['password'];

// Usuario de prueba
$test_user = 'usuario';
$test_password = 'usuario';

$response = [];

if ($username === $test_user && $password === $test_password) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid credentials';
}

echo json_encode($response);
