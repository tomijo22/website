<?php
include 'config.beta.php';
setlocale(LC_TIME, "fr_FR.UTF-8");

function db_connect()
{
  global $config;
  try
  {
    $db = new PDO('mysql:host='.$config['db']['host'].';dbname='.$config['db']['name'].';charset='.$config['db']['charset'], $config['db']['username'], $config['db']['password']);
  }
  catch (Exception $e)
  {
    die('Erreur : ' . $e->getMessage()); // TODO: ui error handling
  }
  if (!isset($e)) { return $db; }
  else { return false; }

}

function get_last_article($db)
{
  $response = $db->query('SELECT * FROM `articles` ORDER BY id DESC');
  $data = $response->fetch();
  return $data;
}
?>
