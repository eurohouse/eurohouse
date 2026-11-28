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
    http_response_code(405); echo json_encode(['error'=>'Method not allowed']); exit;
} $input=json_decode(file_get_contents('php://input'),true);
if (json_last_error()!==JSON_ERROR_NONE||!isset($input['messages'])) {
    http_response_code(400);
    echo json_encode(['error'=>'Invalid input']); exit;
} $endpoint=trim($input['endpoint']??''); if ($endpoint==='') {
    http_response_code(400);
    echo json_encode(['error'=>'Missing required field: endpoint']); exit;
} if (!preg_match('/^[A-Za-z0-9_\/\-:.]+$/',$endpoint)) {
    http_response_code(400);
    echo json_encode(['error'=>'Invalid endpoint format']); exit;
} $apiBase=rtrim($allEnvVars['AI_API_BASE_URL']??getenv('AI_API_BASE_URL')??'','/');
if (!$apiBase) {
    http_response_code(500);
    echo json_encode(['error'=>'Server misconfigured: missing AI_API_BASE_URL']);
    error_log('AI_API_BASE_URL not set'); exit;
} $apiUrl=$apiBase.'/'.ltrim($endpoint,'/');
if (str_contains($endpoint,'chat/completions')) {
    $format='chat';
} elseif (str_contains($endpoint,'responses')) {
    $format='responses';
} elseif (str_contains($endpoint,'messages')) {
    $format='anthropic';
} else { $format='chat'; }
function buildChatPayload(array $input): array {
    return ['model'=>$input['model']??'','messages'=>$input['messages']??[]];
}
function buildResponsesPayload(array $input): array {
    $items=[]; foreach (($input['messages']??[]) as $msg) {
        $role=$msg['role']??'user';
        $isAssistant=($role==='assistant');
        $content=[]; if (is_array($msg['content']??null)) {
            foreach ($msg['content'] as $part) {
                if (($part['type']??'')==='text') {
                    $content[]=$isAssistant
                        ?['type'=>'output_text','text'=>$part['text']??'']
                        :['type'=>'input_text','text'=>$part['text']??''];
                } elseif (($part['type']??'')==='image_url') {
                    $content[]=['type'=>'input_image','image_url'=>$part['image_url']['url']??''];
                }
            }
        } else { $content=$msg['content']??''; }
        $items[]=['role'=>$role,'content'=>$content];
    } $payload=['model'=>$input['model']??'','input'=>$items];
    if (!empty($input['instructions'])) {
        $payload['instructions']=$input['instructions'];
    } if (!empty($input['previous_response_id'])) {
        $payload['previous_response_id']=$input['previous_response_id'];
    } return $payload;
}
function convertPartsForAnthropic(array $content): array {
    $out=[]; foreach ($content as $part) {
        switch ($part['type']??'') {
            case 'text':
                $out[]=['type'=>'text','text'=>$part['text']??'']; break;
            case 'image_url':
                $url=$part['image_url']['url']??'';
                if (preg_match('/^data:(image\/[a-z0-9.+\-]+);base64,(.+)$/i',$url,$m)) {
                    $out[]=['type'=>'image','source'=>[
                        'type'=>'base64','media_type'=>$m[1],'data'=>$m[2],
                    ]];
                } break;
            default:
        }
    } return $out;
}
function buildAnthropicPayload(array $input): array {
    $system=''; $raw=[]; foreach (($input['messages']??[]) as $msg) {
        $role=$msg['role']??'user'; $content=$msg['content']??'';
        if (is_array($content)) {
            $content=convertPartsForAnthropic($content);
        } if ($role==='system'&&is_string($content)) {
            $system.=($system?"\n":'').$content; continue;
        } $raw[]=['role'=>$role,'content'=>$content];
    } $messages=[]; foreach ($raw as $msg) {
        if (empty($msg['content'])||$msg['content']===[]) { continue; }
        $lastIdx=count($messages)-1;
	if ($lastIdx>=0&&$messages[$lastIdx]['role']===$msg['role']) {
            $prev=$messages[$lastIdx]['content'];
            $cur=$msg['content']; if (is_string($prev)&&is_string($cur)) {
                $messages[$lastIdx]['content']=$prev."\n".$cur;
            } elseif (is_array($prev)&&is_array($cur)) {
                $messages[$lastIdx]['content']=array_merge($prev,$cur);
            } else { $messages[]=['role'=>$msg['role'],'content'=>$cur]; }
        } else { $messages[]=$msg; }
    } while (!empty($messages)&&(($messages[0]['role']??'')==='assistant')) {
        array_shift($messages);
    } if (empty($messages)||($messages[0]['role']??'')!=='user') {
        $messages=[['role'=>'user','content'=>[['type'=>'text','text'=>'Hello']]],...$messages];
    } $payload=[
        'model'=>$input['model']??'','messages'=>$messages,
        'max_tokens'=>$input['max_tokens']??16384,
    ]; if ($system!=='') { $payload['system']=$system; } return $payload;
} $builders=[
    'chat'=>'buildChatPayload','responses'=>'buildResponsesPayload',
    'anthropic'=>'buildAnthropicPayload'
]; $payloadArr=($builders[$format]??'buildChatPayload')($input);
$payload=json_encode($payloadArr,JSON_UNESCAPED_UNICODE);
$apiKey=$allEnvVars['AI_API_KEY']??getenv('AI_API_KEY'); if (!$apiKey) {
    http_response_code(500);
    echo json_encode(['error'=>'Server misconfigured: missing AI_API_KEY']);
    error_log('AI_API_KEY not set'); exit;
} $headers=['Content-Type: application/json'];
if ($format==='anthropic') {
    $headers[]='x-api-key: '.$apiKey;
    $headers[]='anthropic-version: 2023-06-01';
} else {
    $headers[]='Authorization: Bearer '.$apiKey;
    $headers[]='HTTP-Referer: '.($_SERVER['HTTP_REFERER']??'');
    $headers[]='X-Title: Eurohouse UX/UI';
} $headers[]='Content-Length: '.strlen($payload); $options=[
    'http'=>[
        'method'=>'POST','header'=>$headers,'content'=>$payload,
        'ignore_errors'=>true,'protocol_version'=>'1.1',
    ],
]; $result=@file_get_contents($apiUrl,false,stream_context_create($options));
$headersResp=$http_response_header??[]; $httpCode=500;
foreach ($headersResp as $header) {
    if (stripos($header,'HTTP/')===0) {
        $parts=explode(' ',$header,3);
        if (count($parts)>=2&&is_numeric($parts[1])) {
            $httpCode=(int)$parts[1]; break;
        }
    }
}

if ($result===false) {
    $error=error_get_last(); http_response_code(502); echo json_encode([
        'error'=>'Upstream request failed',
        'details'=>$error?($error['message']??'Unknown error'):'Unknown error',
    ]); error_log('Stream error to AI: '.($error['message']??'Unknown')); exit;
} if ($httpCode!==200) {
    http_response_code($httpCode); echo $result; exit;
} $data=json_decode($result,true);
function parseChatReply(array $data): string {
    return $data['choices'][0]['message']['content']??'';
}
function parseResponsesReply(array $data): string {
    if (!empty($data['output_text'])) {
        return $data['output_text'];
    } $text=''; foreach (($data['output']??[]) as $item) {
        if (($item['type']??'')==='message') {
            foreach (($item['content']??[]) as $part) {
                if (($part['type']??'')==='output_text') {
                    $text.=$part['text']??'';
                }
            }
        }
    } return $text;
}
function parseAnthropicReply(array $data): string {
    $text=''; foreach (($data['content']??[]) as $part) {
        if (($part['type']??'')==='text') { $text.=$part['text']??''; }
    } return $text;
}
$parsers=['chat'=>'parseChatReply','responses'=>'parseResponsesReply','anthropic'=>'parseAnthropicReply']; $reply=($parsers[$format]??'parseChatReply')($data);
echo json_encode(['reply'=>$reply,'raw'=>$data],JSON_UNESCAPED_UNICODE); exit;