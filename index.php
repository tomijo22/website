<?php
include 'functions.php';
define(last, 0);
error_reporting(E_ALL);
ini_set("display_errors", 1);

if (isset($_GET['p'])) {

  $page_id = $_GET['p'];

  $page = get_page($page_id);

  if ($page['error']===true) {
    // TODO: create a dedicated function rather than two switches
    switch ($page['code']) {
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
    }

  }

  elseif (!file_exists($page['path']) || !preg_match("/" . str_replace('/','\/',$config['working_path']) . "pgs\/\w+\.php/",$page['path'])==1) {
      header("Location: " . $config['root_addr'] . "error.php?e=500&c=file");
      die();
  }

  else {
    $mode = 0;
  }

}
else {

  if (isset($_GET['a']) && intval($_GET['a']) > 0) {
    $article_id = $_GET['a'];
  }
  else {
    $article_id = 0;
  }

  $article = get_article($article_id);

  if ($article['error']===true) {

    switch ($article['code']) {
      case 0:
        header("Location: " . $config['root_addr'] . "error.php?e=404");
        die();
        break;

      case 1:
        header("Location: " . $config['root_addr'] . "error.php?e=500&c=db_connect");
        die();
        break;

    }

  }

  elseif (!file_exists($article['path']) || !preg_match("/" . str_replace('/','\/',$config['working_path']) . "art\/\w+\/\w+\.htm/",$article['path'])==1) {
      header("Location: " . $config['root_addr'] . "error.php?e=500&c=file");
      die();
  }

  else {
    $mode = 1;
    $categories_list = get_articles_cat();
  }

}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>~darkgallium</title> <?php // TODO: adapt title w/ page ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="main.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="extras.js"></script>

  </head>
  <body>

    <?php include ('parts/header.php'); ?>

    <?php

      if ($mode==1) {

        ?>
        <div id="content">
          <article class="full">
            <h1><?php printf($article['title']); ?></h1>
            <div class="article_meta">publié le <?php echo strftime("%e %B %Y", strtotime($article['date'])); ?> dans <a href="<?php echo $config['root_addr'] . "list.php?c=" . array_search($article['cat'],$categories_list) ?>"><?php printf($article['cat']); ?></a></div>
            <div class="article_body">
              <?php echo file_get_contents($article['path']); ?>
              </div>
          </article>
        </div>
      <?php
      }

      elseif ($mode==0) {
        ?>
        <div id="content">
          <div class="cat_heading">
            <h2><?php printf($page['title']); ?></h2>
          </div>
          <hr class="plain-sep">
          <article class="page_body">
            <?php include $page['path']; ?>
          </article>
        </div>

        <?php
      }

    ?>

    <?php include ('parts/footer.php'); ?>

    <script src="menubar.js"></script>
    <script>
    <?php
      if ($mode == 1) {
        if ($article_id == 0) {
          printf("$(document).ready(function() { menu('main','last'); });");
        }
        else {
          printf("$(document).ready(function() { menu('main',''); });");
        }
      }
      else {
        // FIXME: temporary
          printf("$(document).ready(function() { menu('main','" . $page_id . "'); });");
        }

    ?>
    </script>

  </body>
</html>
