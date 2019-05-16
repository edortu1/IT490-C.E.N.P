<form method="post" action="" id="form">
                 <input type ="hidden" id="kaplunk" name="kaplunk" value="kaplunk">
                 <button>KAPLUNK</button>
		<p align="right"><input type="button" onclick="location.href = 'movieSearch.php';" value="Home"/></p>
	        <center><input type="button" onclick="location.href = 'https://www.fandango.com/';" value="Buy Tickets"/></center>
                 </form>
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include('account.php');
$user = $_GET['user'];

global $user;

$conn = mysqli_connect($hostname,$username,$password,$db);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 $query = "SELECT movies.id,movies.title, movies.release_date, movies.overview, movies.poster
  FROM movies join watchlist
  ON  movies.id=watchlist.movie_id
  where watchlist.user_id ='$user'";
  $res = mysqli_query($conn, $query);
   
$rows = array();

while($row = mysqli_fetch_array($res)) $rows[] = $row;
 

foreach ($rows as $row){
    
?>
    <table>
        <tr>
        
            <td>
                <img src="data:image/jpeg;base64,<?php echo $row['poster']  ?>" width="120" >
            </td>
            
            
            <td>
                <b><?php echo $row['title'] ?></b>
                <br>
                <br>
                <?php echo $row['overview'] ?>
            </td>
        
        </tr>
    
    </table>

<?php
}

$re = $_POST['kaplunk'];
if (isset($re)) {


$q = "SELECT * FROM watchlist where user_id ='$user' ORDER BY RAND() LIMIT 1";
    

$r = mysqli_query($conn, $q);
  $row = mysqli_fetch_array($r);
  $movie = $row['movie_id'];
  
  $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.themoviedb.org/3/movie/$movie/videos?api_key=7ccdb5d63255684fcdd0634087e88578&language=en-US",
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
        
        $jResponse = json_decode($response, true);
        if (empty($jResponse['results'])) {
?>
                <scripti>
                   alert("Couldn't find a Trailer for movie");
		</script>
<?php
	//	print_r($jResponse);
        }else{
            $keys = ($jResponse['results'][0]['key']);
?>
                <script>
                 var movie= "<?php echo $movie ?>"
                 console.log(movie);
                 
                 var keys = "<?php echo $keys ?>"
                    window.open("https://www.themoviedb.org/movie/"+movie+"#play="+keys)
                    
                </script>    
<?php
            

            
        }
    }

}
    
?>

