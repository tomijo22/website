<?php
include 'functions.php';
define('nb_articles_per_page', 3);
error_reporting(E_ALL);
ini_set("display_errors", 1);

$db = db_connect();

$categories_list = get_articles_cat();

if (isset($_GET['c']) == false || $categories_list[ intval($_GET['c']) ] == null) {
  exit(-1); // TODO: UI improvements
}

if (!isset($_GET['p']) || intval($_GET['p'])==0)
{
  $num_page = 1;
}
else {
  $num_page = intval($_GET['p']);
}


$cat_num = intval($_GET['c']);
$cat_name = $categories_list[$cat_num];

$response = $db->query('SELECT * FROM articles WHERE cat=\''. $cat_name .'\'');
$data = $response->fetchAll();

$nb_articles_in_cat = count($data);
$nb_pages_for_cat = ceil($nb_articles_in_cat/nb_articles_per_page);

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

      <div id="content">

      <div class="cat_heading">
        <h2><?php printf(ucfirst($cat_name)); ?></h1>
        <div class="sub">
          <?php
          switch ($nb_articles_in_cat) {
            case 0:
              echo "";
              break;
            case 1:
              echo "1 article dans cette catégorie";
              break;
            default:
              echo $nb_articles_in_cat . " articles dans cette catégorie";
              break;
          }
          ?>
        </div>
      </div>
      <hr class="plain-sep">

      <?php

      if ($nb_articles_in_cat == 0) {
        echo "<div class=\"cat_error\"><p>Aucun article dans cette catégorie...</p></div>";
      }
      else if ($num_page < 1 || $num_page > $nb_pages_for_cat) {
        header("Location: " . $config['root_addr'] . "error.php?e=404");
      }
      else {

        for ($j=0+3*($num_page-1); $j < 3+3*($num_page-1); $j++) { // three articles shown by page

          if (isset($data[$j])) {
            ?>

              <article class="preview">
                <h1><?php printf($data[$j]['title']); ?></h1>
                <div class="article_meta">publié le <abbr title="<?php echo "à " . strftime("%H:%M", strtotime($data[$j]['time'])) . ' (UTC)'; ?>"><?php echo strftime("%e %B %Y", strtotime($data[$j]['date'])); ?></abbr></div>
                <div class="article_body">
                  <p><?php printf($data[$j]['short_desc']); ?></p>
                  <p class="article_read_more"><a href="<?php printf($config['root_addr'] . "?a=" .$data[$j]['id']); ?>">lire en entier...</a></p>
                </div>
              </article>
              <hr class="plain-sep">

            <?php
          }
        }

      if ($nb_pages_for_cat > 1 && $num_page == 1) {
        printf('<div class="cat_footer">page ' . $num_page . ' sur ' . $nb_pages_for_cat . ' - <a href="articles.php?c=' . $cat_num . '&p=' . ($num_page+1) . '">suivant</a></div>');
      }
      elseif ($nb_pages_for_cat > 1 && $num_page == $nb_pages_for_cat) {
        printf('<div class="cat_footer"><a href="articles.php?c=' . $cat_num . '&p=' . ($num_page-1) . '">précédent</a> - page ' . $num_page . ' sur ' . $nb_pages_for_cat . '</div>');
      }
      else if ($nb_pages_for_cat > 1 && $num_page > 1) {
        printf('<div class="cat_footer"><a href="articles.php?c=' . $cat_num . '&p=' . ($num_page-1) . '">précédent</a> - page ' . $num_page . ' sur ' . $nb_pages_for_cat . ' - <a href="articles.php?c=' . $cat_num . '&p=' . ($num_page+1) . '">suivant</a></div>');
      }
      else {
        printf("<div class=\"cat_footer\"></div>");
      }

    }

  ?>
      <!--<div class="push"></div>-->
    </div>

    <?php include ('parts/footer.php'); ?>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="menubar.js"></script>
    <script src="extras.js"></script>
    <script>
      $(document).ready(function() {
          menu('articles',<?php printf('\'' . $cat_name . '\''); ?>);
      });
    </script>

  </body>
</html>
