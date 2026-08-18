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
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
if ($_SERVER['REQUEST_METHOD']==='OPTIONS') {
    http_response_code(204); exit;
} if ($_SERVER['REQUEST_METHOD']!=='POST') {
    http_response_code(405);
    echo json_encode(['error'=>'Method not allowed']);
    exit;
} $rawInput=file_get_contents('php://input'); $input=json_decode($rawInput,true);
if (json_last_error()!==JSON_ERROR_NONE||empty($input['location'])) {
    http_response_code(400); echo json_encode([
        'error'=>'Invalid input or missing location',
        'details'=>json_last_error_msg()
    ]); error_log('Weather Proxy Bad Request: '.json_last_error_msg()." | Input: ".$rawInput);
    exit;
} $locationQuery=trim($input['location']);
$isoCode=isset($input['units'])?strtoupper(trim($input['units'])):'UN';
$provider='openweathermap';
$apiKey=$allEnvVars['WEATHER_API_KEY']??getenv('WEATHER_API_KEY');
if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error'=>'Server misconfigured: Missing Weather API Key']);
    exit;
} $cacheDir=__DIR__.'/weather_cache';
if (!is_dir($cacheDir)) { mkdir($cacheDir,0755,true); }
$cacheKey=md5($provider.':'.$locationQuery.':'.$isoCode);
$cacheFile=$cacheDir.'/'.$cacheKey.'.json'; $cacheTTL=600;
if (file_exists($cacheFile)&&(time()-filemtime($cacheFile)<$cacheTTL)) {
    readfile($cacheFile); exit;
} $url=''; $baseOptions=[
    'http'=>[
        'method'=>'GET',
        'header'=>['User-Agent: Eurohouse UX/UI'],
        'ignore_errors'=>true,
        'protocol_version'=>'1.1',
        'timeout'=>15,
    ]
]; $owmUnits=match($isoCode) {
    'US','LR','MM','GB','UK'=>'imperial',
    default=>'metric'
}; $url="https://api.openweathermap.org/data/2.5/weather?q=".urlencode($locationQuery)."&appid={$apiKey}&units={$owmUnits}";
$referer=$_SERVER['HTTP_REFERER']??'';
if (!empty($referer)) {
    $baseOptions['http']['header'][]='Referer: '.$referer;
} $context=stream_context_create($baseOptions);
$result=@file_get_contents($url,false,$context);
$headers=$http_response_header??[];
$httpCode=500; foreach ($headers as $header) {
    if (stripos($header,'HTTP/')===0) {
        $parts=explode(' ',$header,3);
        if (count($parts)>=2&&is_numeric($parts[1])) {
            $httpCode=(int)$parts[1]; break;
        }
    }
} if ($result===false) {
    $error=error_get_last();
    http_response_code(502);
    $output=[
        'status'=>'failure',
        'source_provider'=>$provider,
        'error'=>'Upstream request failed',
        'details'=>$error['message']??'Unknown socket error',
        'attempted_url'=>$url
    ]; file_put_contents($cacheFile,json_encode($output));
    echo json_encode($output); exit;
} $dataFromUpstream=json_decode($result,true);
$normalized=normalizeWeatherResponse($dataFromUpstream,$provider);
http_response_code((isset($normalized['error']))?$httpCode:200);
file_put_contents($cacheFile,json_encode($normalized));
echo json_encode($normalized); exit;
function normalizeWeatherResponse(array $data,string $provider): array {
    return [
        'provider'=>'openweathermap',
        'name'=>$data['name']??'',
        'main'=>$data['main']??[],
        'weather'=>$data['weather'][0]??[],
        'clouds'=>$data['clouds']??[]
    ];
}
