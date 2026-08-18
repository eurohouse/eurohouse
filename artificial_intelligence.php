<?php
function loadAllEnvFiles(string $baseDir): array {
    $variables=[]; if (!is_dir($baseDir)) {
        error_log('Warning: Base directory not found at '.$baseDir);
        return $variables;
    } $iterator=new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($baseDir,FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    ); foreach ($iterator as $file) {
        if ($file->getFilename()==='.env'&&$file->isFile()) {
            $lines=file($file->getPathname(),FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line=trim($line);
                if ($line===''||strpos($line,'#')===0||strpos($line,'=')===false) {
                    continue;
                } list($name,$value)=explode('=',$line,2);
                $name=trim($name); $value=trim($value);
                if (stripos($name,'export ')===0) {
                    $name=substr($name,7);
                    $name=trim($name);
                } if ((substr($value,0,1)==='"'&&substr($value,-1)==='"')
		||(substr($value,0,1)==="'"&&substr($value,-1)==="'")) {
                    $value=substr($value,1,-1);
                } putenv("$name=$value");
                $variables[$name]=$value;
            }
        }
    } $_ENV=array_replace($_ENV, $variables);
    $_SERVER=array_replace($_SERVER, $variables);
    return $variables;
} $allEnvVars=loadAllEnvFiles(__DIR__);
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    echo json_encode(['error'=>'Method not allowed']);
    exit;
} $input=json_decode(file_get_contents('php://input'),true);
if (json_last_error()!==JSON_ERROR_NONE||!isset($input['messages'])) {
    http_response_code(400);
    echo json_encode(['error'=>'Invalid input']); exit;
} $apiKey=$allEnvVars['AI_API_KEY']??getenv('AI_API_KEY'); if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error'=>'Server misconfigured: missing AI_API_KEY']);
    error_log('AI_API_KEY not set'); exit;
} $apiUrl=$allEnvVars['AI_API_URL']??getenv('AI_API_URL'); if (!$apiUrl) {
    http_response_code(500);
    echo json_encode(['error'=>'Server misconfigured: missing AI_API_URL']);
    error_log('AI_API_URL not set'); exit;
} $payload=json_encode(['model'=>($input['model']??''),'messages'=>$input['messages'],]);
$referer=$_SERVER['HTTP_REFERER']??''; $options=[
    'http'=>[
        'method'=>'POST','header'=>[
            'Authorization: Bearer '.$apiKey,
            'Content-Type: application/json',
            'HTTP-Referer: '.$referer,
            'X-Title: Eurohouse UX/UI',
            'Content-Length: '.strlen($payload),
        ],'content'=>$payload,'ignore_errors'=>true,
	'protocol_version'=>'1.1',
    ],
]; $context=stream_context_create($options);
$result=@file_get_contents(($apiUrl??''),false,$context);
$headers=$http_response_header??[]; $httpCode=500;
foreach ($headers as $header) {
    if (stripos($header,'HTTP/')===0) {
        $parts=explode(' ',$header,3);
        if (count($parts)>=2&&is_numeric($parts[1])) {
            $httpCode=(int)$parts[1]; break;
        }
    }
} if ($result===false) {
    $error=error_get_last();
    http_response_code(502);
    echo json_encode([
        'error'=>'Upstream request failed',
        'details'=>$error?($error['message']??'Unknown error'):'Unknown error'
    ]); error_log('Stream error to AI: '.($error['message']??'Unknown')); exit;
} if ($httpCode!==200) {
    http_response_code($httpCode);
    echo $result; exit;
} echo $result; exit;