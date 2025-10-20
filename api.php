<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
    $data = $_POST;
}

$content = isset($data['content']) ? trim((string)$data['content']) : '';
if ($content === '') {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu nội dung hoặc nội dung rỗng.'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$md5 = md5($content);

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
$base = $scheme . '://' . $host . ($basePath ? $basePath : '');
$url = $base . '/domdomit/' . $md5;

$dataFile = __DIR__ . DIRECTORY_SEPARATOR . 'data.json';
$store = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $decoded = json_decode($json, true);
    if (is_array($decoded)) {
        $store = $decoded;
    }
}

$store[$md5] = [
    'content' => $content,
    'created_at' => date('c')
];

file_put_contents($dataFile, json_encode($store, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo json_encode([
    'status' => 'ok',
    'md5' => $md5,
    'url' => $url
], JSON_UNESCAPED_UNICODE);

