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
     
// _________________________________________________________________




// for ($i=9445; $i <= 22955; $i++) { 
  // $i=1405;
  sleep(1);
  echo 'start >'.$i;
  // $id = 1;
  $res = $pdo->prepare("SELECT page_link FROM `mydatabase` WHERE id = :id");
  $res->bindParam(':id', $i);
  $res->execute();
  $result = $res->fetch(PDO::FETCH_ASSOC);
  $page_link = $result['page_link'];
  // print_r($page_link)
$crawler = $client->request('GET', $page_link);

    $src = $crawler->filter('div.thumbnail img')->attr('src');

    $img = 'https://imamali.info' . $src;

    $filename = basename(parse_url($img, PHP_URL_PATH));

$arrayinfo = array();
    $crawler->filter('tr.ds-table-row.odd')->each(function ($node) use (&$arrayinfo) {
      $key = $node->filter('td.label-cell')->text();
      $value = $node->filter('td.word-break')->text();
      $arrayinfo[$key] = isset($arrayinfo[$key]) ? $arrayinfo[$key]." / ". $value :$value;
    });
    $crawler->filter('tr.ds-table-row.even')->each(function ($node) use (&$arrayinfo) {
      $key = $node->filter('td.label-cell')->text();
      $value = $node->filter('td.word-break')->text();
      $arrayinfo[$key] = isset($arrayinfo[$key]) ? $arrayinfo[$key]." / ". $value :$value;
    });
    // print_r($arrayinfo['pages']);

    $page_link = $page_link;
    $contributor_author = str_replace("'", '',$arrayinfo['contributor author']);
    // $others1 = $arrayinfo[1];
    $date_accessioned = str_replace("'", '',$arrayinfo['date accessioned']);
    $date_available = str_replace("'", '',$arrayinfo['date available']);
    $date_copyright = str_replace("'", '',$arrayinfo['date copyright']);
    $identifier_uri = str_replace("'", '',$arrayinfo['identifier uri']);
    $format_extent = str_replace("'", '',$arrayinfo['format extent']);
    $format_medium = str_replace("'", '',$arrayinfo['format medium']);
    $language = str_replace("'", '',$arrayinfo['language']);
    $publisher = str_replace("'", '',$arrayinfo['publisher']);
    $title = str_replace("'", '',$arrayinfo['title']);
    $type = str_replace("'", '',$arrayinfo['type']);
    $identifier_libid = str_replace("'", '',$arrayinfo['identifier libid']);
    $publisher_place = str_replace("'", '',$arrayinfo['publisher place']);
    $publisher_country = $arrayinfo['publisher country'];
    $date_issuedqamari = str_replace("'", '',$arrayinfo['date issuedqamari']);
    $date_issuedshamsi = str_replace("'", '',$arrayinfo['date issuedshamsi']);
    $book_edition = str_replace("'", '',$arrayinfo['book edition']);
    $identifier_shelf = str_replace("'", '',$arrayinfo['identifier shelf']);
    $contributor_authorrecord = str_replace("'", '',$arrayinfo['contributor authorrecord']);
    // $others2 = $arrayinfo[19];
    $subject_category = str_replace("'", '',$arrayinfo['subject category']);
    $contenttype = str_replace("'", '',$arrayinfo['contenttype']);
    $pages = str_replace("'", '',$arrayinfo['pages']);
    $img_name = str_replace("'", '',$filename);
    $img_link = str_replace("'", '',$img);



$sql = "UPDATE mydatabase SET  
contributor_author = '".$contributor_author."',
date_accessioned = '".$date_accessioned."',
date_available = '".$date_available."',
title = '".$title."',
date_copyright = '".$date_copyright."',
identifier_uri = '".$identifier_uri."',
format_extent = '".$format_extent."',
format_medium = '".$format_medium."',
language = '".$language."',
publisher = '".$publisher."',
type = '".$type."',
identifier_libid = '".$identifier_libid."',
publisher_place = '".$publisher_place."',
publisher_country = '".$publisher_country."',
date_issuedqamari = '".$date_issuedqamari."',
date_issuedshamsi = '".$date_issuedshamsi."',
book_edition = '".$book_edition."',
identifier_shelf = '".$identifier_shelf."',
contributor_authorrecord = '".$contributor_authorrecord."',
subject_category = '".$subject_category."',
contenttype = '".$contenttype."',
pages = '".$pages."',
img_name = '".$img_name."',
img_link = '".$img_link."',
data = 1 
WHERE page_link = '".$page_link."'";

// print_r($sql);
$sqlQuery = str_replace('?', '', $sql);
// $sqlQuery = str_replace("'", '', $sqlQuery);

// die();
$updateStmt = $pdo->prepare($sqlQuery);
// die();
$updateStmt->execute();
// print_r($updateStmt);
echo ('done'. $i);
// _____________________________________________________________
        $i++;
    } catch (Exception $e) {
      echo 'error happens > '.$i;
        continue;
    }
} while ($i <= 438);
//___________________________________________________________





  // }







// print_r($updateStmt);


// print_r($crawler);
// $div_tags = $crawler->filter('table.ds-includeSet-table.detailtable.table.table-striped.table-hover')->each(function ($node) {
//   $a_tag = $node->filter('tr')->each(function($dataTable){
    // $sh = $dataTable->filter('td.label-cell');
    // $rowData = $dataTable->filter('td.word-break');


  // $others2 = null;
  // $others1 = null;
    // print_r($dataofeverybook[1]);
      
    // using the each() method
    // $rowData->each(function ($node) {
    //     $content = $node->textContent;
    //     echo $content . '<br>';
    // });
//     });

//  });
// $tableName = 'mydatabase';
// $stmt = $pdo->prepare("INSERT INTO $tableName (page_link) VALUES (:href)");
// foreach ($links as $tag) {
//   $stmt->bindParam(':href', $tag);
//   $stmt->execute();
// }
// }





    // 'UPDATE mydatabase SET  
    // contributor_author = '.$contributor_author.',
    // date_accessioned = '.$date_accessioned.',
    // date_available = '.$date_available.',
    // title = '.$title.',
    // date_copyright = '.$date_copyright.',
    // identifier_uri = '.$identifier_uri.',
    // format_extent = '.$format_extent.',
    // format_medium = '.$format_medium.',
    // language = '.$language.',
    // publisher = '.$publisher.',
    // type = '.$type.',
    // identifier_libid = '.$identifier_libid.',
    // publisher_place = '.$publisher_place.',
    // publisher_country = '.$publisher_country.',
    // date_issuedqamari = '.$date_issuedqamari.',
    // book_edition = '.$book_edition.',
    // identifier_shelf = '.$identifier_shelf.',
    // contributor_authorrecord = '.$contributor_authorrecord.',
    // subject_category = '.$subject_category.',
    // contenttype = '.$contenttype.',
    // pages = '.$pages.',
    // img_name = '.$img_name.',
    // others2 = '.$others2.',
    // others1 = '.$others1.',
    // img_link = '.$img_link.' 
    // WHERE page_link = '.$page_link

// $updateStmt->bindParam(':contributor_author', $contributor_author);
// $updateStmt->bindParam(':date_accessioned', $date_accessioned);
// $updateStmt->bindParam(':date_available', $date_available);
// $updateStmt->bindParam(':title', $title);
// $updateStmt->bindParam(':date_copyright', $date_copyright);
// $updateStmt->bindParam(':identifier_uri', $identifier_uri);
// $updateStmt->bindParam(':format_extent', $format_extent);
// $updateStmt->bindParam(':format_medium', $format_medium);
// $updateStmt->bindParam(':language', $language);
// $updateStmt->bindParam(':publisher', $publisher);
// $updateStmt->bindParam(':type', $type);
// $updateStmt->bindParam(':identifier_libid', $identifier_libid);
// $updateStmt->bindParam(':publisher_place', $publisher_place);
// $updateStmt->bindParam(':publisher_country', $publisher_country);
// $updateStmt->bindParam(':date_issuedqamari', $date_issuedqamari);
// $updateStmt->bindParam(':book_edition', $book_edition);
// $updateStmt->bindParam(':identifier_shelf', $identifier_shelf);
// $updateStmt->bindParam(':contributor_authorrecord', $contributor_authorrecord);
// $updateStmt->bindParam(':subject_category', $subject_category);
// $updateStmt->bindParam(':contenttype', $contenttype);
// $updateStmt->bindParam(':pages', $pages);
// $updateStmt->bindParam(':img_name', $img_name);
// $updateStmt->bindParam(':others2', $others2);
// $updateStmt->bindParam(':others1', $others1);
// $updateStmt->bindParam(':img_link', $img_link);
?>