<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include('account.php');
session_start();
$_SESSION['user']= $_GET['user'];
$_SESSION['clicked'] = array();
$user= $_SESSION['user'];

$conn = mysqli_connect($hostname, $username, $password, $db);
?>
<table>
	<tr>
		<td>
		<form method="post" action="movieSearch.php?user=<?php echo $user?>">
				<p align="center"> hello <?php echo $_GET['user']; ?><br>

    				<input type="text" name="search" placeholder="Search Movie" />
    				<input type="submit" value="search" >
</form>
		</td>

		<td>
		<form method="post" action="watchlist.php?user=<?php echo $user ?>">
			<input type="submit" value="view watch list">
		</form>
		</td>
	</tr>
</table>
<?php

$sterm = filter_input(INPUT_POST,'search');
if ($sterm == NULL){
    
$sterm = "A";
}

$sTermR = str_replace(" ", "-",$sterm);
$curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.themoviedb.org/3/search/movie?api_key=7ccdb5d63255684fcdd0634087e88578&query=$sTermR",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "{}",
        ));
    $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);      
        if ($err) {
                echo "cURL Error #:" . $err;
    } else {
        


        $jResponse = json_decode($response);
     
     $results = $jResponse->results;
     include 'movieRow.php';
     
    }
?>

