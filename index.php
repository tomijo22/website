<?php
include 'functions.php';
define(last, 0);

if (isset($_GET['p'])) {
  // TODO: implement support for pages
  $mode = 0;
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
        header("Location: " . $config['root_addr'] . "error.php?e=500&c=DB");
        die();
        break;

      default:
        header("Location: " . $config['root_addr'] . "error.php?e=500&c=undefined");
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
    <title>~darkgallium</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="main.css" rel="stylesheet">

  </head>
  <body>

    <?php include ('parts/header.php'); ?>

    <?php

      if ($mode==1) {

        ?>
        <div id="content" class="center_content">
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
        die(); // not yet implemented
      }

    ?>

    <?php include ('parts/footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="menubar.js"></script>
    <script src="extras.js"></script>
    <script>
    <?php
      if (!isset($article_id)) {
        // FIXME
      }
      if ($article_id == 0) {
        printf("$(document).ready(function() { menu('main','last'); });");
      }
      else {
        printf("$(document).ready(function() { menu('main',''); });");
      }
    ?>
    </script>

  </body>
</html>
