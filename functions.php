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
?>
