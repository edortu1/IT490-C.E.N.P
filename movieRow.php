<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
include ('account.php');

$conn = mysqli_connect($hostname, $username, $password, $db);
global $conn;

?>
<table>
        
    <?php foreach ($results as $jspons){   
            
        $poster_paths = $jspons->poster_path;
    
        $poster_paths = strval($poster_paths);
        $poster_url = "https://image.tmdb.org/t/p/w185".$poster_paths;
        $imageData = base64_encode(file_get_contents($poster_url));
      $jid =$jspons->id;
      $jt = $jspons->title;
      $jo = $jspons->overview;
      $rd = $jspons->release_date;
        $query = "SELECT id FROM movies  WHERE id = $jid";
        
        $jt = mysqli_real_escape_string($conn,$jt);
        $jo = mysqli_real_escape_string($conn,$jo); 
        
        $result = mysqli_query($conn, $query);
            
            
            $e = mysqli_fetch_array($result);
            
        if($e == NULL) {
            #echo gettype($jo);
        $q = "INSERT INTO movies (id, title,release_date,overview,poster) VALUES ($jid,'$jt','$rd','$jo','$imageData')";
        mysqli_query($conn, $q);
        }

     
?>
   
            <tr>
                <td>
                <img src="data:image/jpeg;base64,<?php echo $imageData ?>" width="120" >
                </td>

                <td>
                    <b> <?php echo $jspons->title; ?> </b>

                    <p> <?php echo $jspons->overview; ?></p>
                 
                            <br>
                 
                 <b> release date: <?php echo $jspons->release_date; ?></b>
                 
                 
                
                 <form method="post" action="" id="form">
                 <input type ="hidden" id="add" name="add" value="<?php echo $jid; ?>">
                 <button>add to watchlist</button>
                 </form>
                 
                

                </td>

            </tr>

                
  
        
        
<?php   
    }
    
?>
</table>

<?php
$re = $_POST['add'];
if (isset($re)) {
array_push($_SESSION['clicked'],$re);

$mvid = $_SESSION['clicked'][0];
$us = $_SESSION['user'];
echo $mvid;


$a = "INSERT INTO watchlist (user_id, movie_id) VALUES ('$us',$mvid)";

if (mysqli_query($conn, $a)){
        
        }else {
            
             echo "Error:".mysqli_error($conn);
        }


}
             
?>

