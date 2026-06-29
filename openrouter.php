<?php
// api/openrouter.php

// --- НАЧАЛО: простой .env-лоадер без зависимостей ---
$envPath = __DIR__ . '/../.env'; // .env лежит в корне проекта, рядом с index.php
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Пропускаем комментарии и пустые строки
        if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) {
            continue;
        }

        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

        // Удаляем кавычки по краям, если они есть (поддерживает "value", 'value')
        if ((substr($value, 0, 1) === '"' && substr($value, -1) === '"')
            || (substr($value, 0, 1) === "'" && substr($value, -1) === "'")) {
            $value = substr($value, 1, -1);
        }

        putenv("$name=$value");
        $_ENV[$name] = $value;       // чтобы работало $_ENV['KEY']
        $_SERVER[$name] = $value;   // чтобы работало getenv() и иногда $_SERVER
    }
} else {
    // Можно залогировать, если хочешь, но не выводи ошибку клиенту
    error_log('Warning: .env file not found at ' . $envPath);
}
// --- КОНЕЦ: простой .env-лоадер ---

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // лучше заменить на конкретный домен
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (json_last_error() !== JSON_ERROR_NONE || !isset($input['messages'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Читаем ключ из переменной окружения
$apiKey = getenv('OPENROUTER_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Server misconfigured: missing OPENROUTER_API_KEY']);
    error_log('OPENROUTER_API_KEY not set');
    exit;
}

$model = $input['model'] ?? 'meta-llama/llama-3.1-8b-instruct:free';

$payload = json_encode([
    'model' => $model,
    'messages' => $input['messages'],
]);

$referer = $_SERVER['HTTP_REFERER'] ?? '';

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'HTTP-Referer: ' . $referer,
            'X-Title: Eurohouse UX/UI',
            'Content-Length: ' . strlen($payload),
        ],
        'content' => $payload,
        'ignore_errors' => true, // чтобы получить реальный HTTP‑код из заголовков
        'protocol_version' => '1.1',
    ],
];

$context = stream_context_create($options);
$result = @file_get_contents('https://openrouter.ai/api/v1/chat/completions', false, $context);

// Получаем HTTP‑статус из метаданных потока
$meta = stream_get_meta_data($context);
// В метаданных нет прямого HTTP‑кода, поэтому смотрим заголовки ответа
$headers = $http_response_header ?? [];

$httpCode = 500; // дефолт при ошибке
foreach ($headers as $header) {
    if (stripos($header, 'HTTP/') === 0) {
        // Пример строки: "HTTP/1.1 200 OK"
        $parts = explode(' ', $header, 3);
        if (count($parts) >= 2 && is_numeric($parts[1])) {
            $httpCode = (int)$parts[1];
            break;
        }
    }
}

if ($result === false) {
    $error = error_get_last();
    http_response_code(502);
    echo json_encode([
        'error' => 'Upstream request failed',
        'details' => $error ? ($error['message'] ?? 'Unknown error') : 'Unknown error'
    ]);
    error_log('Stream error to OpenRouter: ' . ($error['message'] ?? 'Unknown'));
    exit;
}

if ($httpCode !== 200) {
    // Пробрасываем статус и тело ошибки от OpenRouter
    http_response_code($httpCode);
    echo $result;
    exit;
}

echo $result;
exit;
