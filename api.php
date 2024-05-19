<?php
$api_key = 'YOUR_API_KEY';
$url = 'https://api.openai.com/v1/engines/davinci/completions';
$prompt = $_POST['ques'];
$data = array(
    'prompt' => $prompt,
    'max_tokens' => 150
);

$ch = curl_init($url);
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
echo $result['choices'][0]['text']; // 출력된 텍스트를 웹사이트에 표시
?>

