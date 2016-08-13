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

function get_article($id)
{
  $db = db_connect();
  if ($db == false) {
    $return = array('error' => true,
                    'code' => 1);
    return $return;
  }
  else {
    if (intval($id) > 0)
    {
      $response = $db->query('SELECT * FROM `articles` WHERE ID = ' . $db->quote($id));
      $data=$response->fetchAll();

      if ($response==false OR count($data)==0) {
        $return = array('error' => true,
                        'code' => 0);
        return $return;
      }
      else {
        $return = array_merge(array('error' => false), $data[0]);
        return $return;
      }
    }
    else {
      $response = $db->query('SELECT * FROM `articles` ORDER BY id DESC');
      $data = $response->fetch();

      if ($data==false) {
        $return = array('error' => true,
                        'code' => 0);
        return $return;
      }
      else {
        $return = array_merge(array('error' => false), $data);
        return $return;
      }

    }

  }

}

function get_page($id)
{
  $db = db_connect();
  if ($db == false) {
    $return = array('error' => true,
                    'code' => 1);
    return $return;
  }
  else {
    $pages_list = array('whoami','contact');

    if (in_array($id, $pages_list)) {

      $response = $db->query('SELECT * FROM `pages` WHERE `key` LIKE ' . $db->quote($id));
      $data=$response->fetchAll();

      if ($response==false OR count($data)==0) {
        $return = array('error' => true,
                        'code' => 2);
        return $return;
      }
      else {
        $return = array_merge(array('error' => false), $data[0]);
        return $return;
      }

    }

    else {
      $return = array('error' => true,
                      'code' => 0);
      return $return;
    }

  }

}

function get_articles_cat()
{
  global $config;
  $file = file_get_contents($config['root_addr'] . "menu.php");
  $list = json_decode($file,true)["articles"];
  unset($list["retour"]);
  $result = array(0 => null);
  foreach ($list as $key => $unused) {
    array_push($result,$key);
  }
  return $result;
}

function redir_to_err_page($err_code)
{
  switch ($err_code) {
    case 0:
      header("Location: " . $config['root_addr'] . "error.php?e=404");
      die();
      break;

    case 1:
      header("Location: " . $config['root_addr'] . "error.php?e=500&c=db_connect");
      die();
      break;

    case 2:
      header("Location: " . $config['root_addr'] . "error.php?e=500&c=not_found_db");
      die();
      break;

    case 3:
      header("Location: " . $config['root_addr'] . "error.php?e=500&c=file");
      die();
      break;

    default:
      header("Location: " . $config['root_addr'] . "error.php?e=500&c=undefined");
      die();
      break;
  }
}
?>
