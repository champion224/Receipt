<?php
// 헤더 설정: JSON 응답
header('Content-Type: application/json');

// POST 데이터 읽기
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['status' => 'error', 'message' => '잘못된 JSON']);
    exit;
}

if (!is_array($data)) {
    echo json_encode(['status' => 'error', 'message' => '데이터 형식이 올바르지 않습니다.']);
    exit;
}

// 저장할 파일 경로
$file = __DIR__ . '/items.json';

// 기존 데이터 읽기
$oldData = [];
if (file_exists($file)) {
    $content = file_get_contents($file);
    $oldData = json_decode($content, true);
    if (!is_array($oldData)) $oldData = [];
}

// 덮어쓰기(또는 원하는 방식으로 병합 가능)
$newData = $data;

file_put_contents($file, json_encode($newData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(['status' => 'success']);
?>
