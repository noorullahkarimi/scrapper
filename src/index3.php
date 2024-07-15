<?php
require __DIR__ . '/../vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

// Set database credentials
$host = 'localhost';
$dbname = 'scrapper';
$username = 'root';
$password = '';

try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  die();
}

$client = new Client();
// _________________________________________________________________
$i = 1;
do {
    try {
     
//   sleep(1);
  echo 'start >'.$i;
  // $id = 1;
  $res = $pdo->prepare("SELECT img_link FROM `mydatabase` WHERE id = :id");
  $res->bindParam(':id', $i);
  $res->execute();
  $result = $res->fetch(PDO::FETCH_ASSOC);
  $url = $result['img_link'];



//   $url = "https://imamali.info/iadl/bitstream/handle/110/20817/37110.jpgsequence=1&isAllowed=y";
  $new_url = strstr($url, "sequence=1&isAllowed=y", true); // find the substring and exclude it
  echo $new_url; // print the new URL without the substring
// die();
//   https://imamali.info/iadl/bitstream/handle/110/20817/37110.jpgsequence=1&isAllowed=y
$sql = "UPDATE mydatabase SET  
img_link = '".$new_url."'
WHERE id = '".$i."'";


// die();
$updateStmt = $pdo->prepare($sql);
// print_r($updateStmt);
// die();
$updateStmt->execute();
echo ('done'. $i);
// die();
// _____________________________________________________________
        $i++;
    } catch (Exception $e) {
      echo 'error happens > '.$i;
        continue;
    }
} while ($i <= 438);
//___________________________________________________________




?>