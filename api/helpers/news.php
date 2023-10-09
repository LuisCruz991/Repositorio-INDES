<?php
$apiKey = '1748d28b014d44089660a08c1af3f018'; // Reemplaza esto con tu API Key
$category = 'sports'; // Categoria de la noticia
$keyword = 'olympic'; // Palabra clave para buscar noticias relacionadas

$url = "https://newsapi.org/v2/top-headlines?category={$category}&q={$keyword}&apiKey={$apiKey}";

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