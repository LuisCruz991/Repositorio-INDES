<?php
$apiKey = '105ad4b200a74b17b550ebf75983ed01'; // Reemplaza esto con tu API Key
$keyword = 'Olympics AND "Tokyo 2020" AND "Olympic Games" OR "Paris 2024"'; // Palabra clave para buscar noticias relacionadas
$pageSize = '15';
$page = '1';
$sortBy = 'relevancy' ;

$url = "https://newsapi.org/v2/everything?q={$keyword}&pageSize={$pageSize}&page={$page}&sortBy={$sortBy}&apiKey={$apiKey}";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Establece el encabezado User-Agent
curl_setopt($ch, CURLOPT_USERAGENT, 'SINDES'); // Reemplaza 'NombreDeTuAplicacion' con el nombre de tu aplicación o sitio web
$response = curl_exec($ch);

if(curl_errno($ch)){
    echo 'Error:' . curl_error($ch);
}

curl_close($ch);
echo $response;
?>