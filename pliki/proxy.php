<?php
header('Content-Type: text/plain; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: *');
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(204); exit; }
 $url = $_GET['url'] ?? '';
if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) { http_response_code(400); echo '{"error":"bad url"}'; exit; }
 $ch = curl_init($url);
 $hdrs = ['User-Agent: Mozilla/5.0 (QtEmbedded; U; Linux; C) AppleWebKit/533.3 (KHTML, like Gecko) MAG200 stbapp ver: 4 rev: 2721 Mobile Safari/533.3', 'Accept: application/json,*/*', 'Accept-Encoding: gzip, deflate'];
 $ck = $_GET['cookie'] ?? '';
if ($ck !== '') { curl_setopt($ch, CURLOPT_COOKIE, $ck); }
 $tk = $_GET['auth'] ?? '';
if ($tk !== '') { $hdrs[] = 'Authorization: Bearer ' . $tk; }
curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_MAXREDIRS => 5, CURLOPT_TIMEOUT => 15, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => 0, CURLOPT_ENCODING => '', CURLOPT_HTTPHEADER => $hdrs]);
 $body = curl_exec($ch);
 $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 $err = curl_error($ch);
curl_close($ch);
if ($err) { http_response_code(502); echo '{"error":"' . $err . '"}'; exit; }
http_response_code($code);
echo $body;