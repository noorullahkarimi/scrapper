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
for ($i=230; $i <= 231; $i++) { 

  sleep(1);
$crawler = $client->request('GET',
 'https://imamali.info/iadl/discover?rpp=100&page='.$i.'&query=type%3A%28%22%D9%83%D8%AA%D8%A7%D8%A8+%DA%86%D8%A7%D9%BE%D9%8A%22%29&group_by=none&etal=0');
 $links = array(); // create an empty array to store the links
 $div_tags = $crawler->filter('div.col-sm-10.artifact-description')->each(function ($node) use (&$links) {
   $a_tag = $node->filter('a')->first();
   $href = $a_tag->attr('href');
   $links[] = "https://imamali.info/" .$href; // add the link to the array
 });

$tableName = 'mydatabase';
$stmt = $pdo->prepare("INSERT INTO $tableName (page_link) VALUES (:href)");
foreach ($links as $tag) {
  $stmt->bindParam(':href', $tag);
  $stmt->execute();
}
}//for loop

?>