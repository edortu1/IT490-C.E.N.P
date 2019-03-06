<?php
$results = shell_exec('GET https://api.themoviedb.org/3/movie/550?api_key=7ccdb5d63255684fcdd0634087e88578');
$arrayCode = json_decode($results);
var_dump($arrayCode);
?>
