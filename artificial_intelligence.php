<?php include 'functions.php';
$userSettings=fileopen('settings.json');
$cookie=whichCookie($userSettings['reserve']['unauthorized']);
$userData=fileopen($cookie.'_files/profile.json',json_encode($userSettings['defaults']));
$envPath=__DIR__.'/../.env'; if (file_exists($envPath)) {
    $lines=file($envPath,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line),'#')===0||strpos($line,'=')===false) {
            continue;
        } list($name,$value)=explode('=',$line,2);
        $name=trim($name); $value=trim($value);
        if ((substr($value,0,1)==='"'&&substr($value,-1)==='"')
	||(substr($value,0,1)==="'"&&substr($value,-1)==="'")) {
	    $value=substr($value,1,-1);
	} putenv("$name=$value");
        $_ENV[$name]=$value; $_SERVER[$name]=$value;
    }
} else {
    error_log('Warning: .env file not found at '.$envPath);
} header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    echo json_encode(['error'=>'Method not allowed']); exit;
} $input=json_decode(file_get_contents('php://input'),true);
if (json_last_error()!==JSON_ERROR_NONE||!isset($input['messages'])) {
    http_response_code(400);
    echo json_encode(['error'=>'Invalid input']); exit;
} $apiKey=getenv('API_KEY'); if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error'=>'Server misconfigured: missing API_KEY']);
    error_log('API_KEY not set'); exit;
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
$result=@file_get_contents(($userData['endpoint']??''),false,$context);
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