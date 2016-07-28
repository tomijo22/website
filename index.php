<?php
include 'functions.php';

$db = db_connect();
$article = get_last_article($db);

if (file_exists($article['path']) AND preg_match("/" . str_replace('/','\/',$config['working_path']) . "art\/\w+\/\w+\.htm/",$article['path'])==1) {
  $article_body = file_get_contents($article['path']);
}
else {
  // TODO: ui error handle
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

    <hr>

    <article>
      <h1><?php printf($article['title']); ?></h1>
      <div class="article_meta">publié le <?php echo strftime("%e %B %Y", strtotime($article['date'])); ?> dans <?php printf($article['cat']); ?></div>
      <div class="article_body">
        <?php printf($article_body); ?>
      </div>
    </article>

    <hr>

    <?php include ('parts/footer.php'); ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="menubar.js"></script>
    <script src="extras.js"></script>

  </body>
</html>
