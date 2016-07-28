<?php
include 'functions.php';
setlocale(LC_TIME, "fr_FR.UTF-8");

$db = db_connect();
$article = get_last_article($db);

if (file_exists($article['path']) AND preg_match("/\/var\/www\/darkgallium\.beta\/art\/\w+\/\w+\.htm/",$article['path'])==1) {
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

    <link href="main.css" rel="stylesheet">

  </head>
  <body>

    <header>
      <h1 id="site_title">~darkgallium</h1>
      <h2>the greyscale blog</h2>
    </header>

    <nav id="main_navbar">
      <ul>
        <li></li>
      </ul>
    </nav>

    <hr>

    <article>
      <h1><?php printf($article['title']); ?></h1>
      <div class="article_meta">publié le <?php echo strftime("%e %B %Y", strtotime($article['date'])); ?> dans <?php printf($article['cat']); ?></div>
      <div class="article_body">
        <?php printf($article_body); ?>
      </div>
    </article>

    <hr>

    <footer>
      <span class="octicon octicon-code"></span> avec <span class="octicon octicon-heart"></span>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="menubar.js"></script>
    <script src="extras.js"></script>

  </body>
</html>
