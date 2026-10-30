
<?php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'POST required']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$id = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT);
$action = $input['action'] ?? '';

if (!$id || !in_array($action, ['add', 'remove'], true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$file = dirname(__DIR__) . '/data/resources.json';

$handle = fopen($file, 'c+');

if (!$handle || !flock($handle, LOCK_EX)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Cannot access resources']);
    exit;
}

$contents = stream_get_contents($handle);
$resources = json_decode($contents ?: '[]', true);

if (!is_array($resources)) {
    flock($handle, LOCK_UN);
    fclose($handle);

    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

$found = false;
$newCount = 0;

foreach ($resources as &$resource) {
    if ((int)($resource['id'] ?? 0) === $id) {

        $found = true;
        $current = max(0, (int)($resource['favorites'] ?? 0));

        if ($action === 'add') {
            $current++;
        } else {
            $current = max(0, $current - 1);
        }

        $resource['favorites'] = $current;
        $newCount = $current;
        break;
    }
}

unset($resource);

if (!$found) {
    flock($handle, LOCK_UN);
    fclose($handle);

    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Resource not found']);
    exit;
}

$newJson = json_encode(
    $resources,
    JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
);

rewind($handle);
ftruncate($handle, 0);
$written = fwrite($handle, $newJson);

if ($written === false || !fflush($handle)) {
    flock($handle, LOCK_UN);
    fclose($handle);

    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Save failed']);
    exit;
}

flock($handle, LOCK_UN);
fclose($handle);

echo json_encode([
    'success' => true,
    'id' => $id,
    'favorites' => $newCount
]);
