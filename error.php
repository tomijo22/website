<?php
include 'config.beta.php';
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
      if (!isset($_GET['e']) OR $_GET['e']=='404') {
        ?>
        <div id="content" class="center_content">
            <div class="error">
                <h2>YOU'RE LOST</h2>
                <p>La page recherchée n'existe pas ou plus sur ce serveur,<br>
                  cliquez <a href="<?php printf($config['root_addr']); ?>">ici</a> pour retrouver votre chemin<br>
                  <br>
                  <span class="err_code">#404</span>
                </p>
            </div>
        </div><?php
      }
      elseif ($_GET['e']=='403') {
       ?>
      <div id="content" class="center_content">
          <div class="error">
              <h2>NOTHING TO SEE HERE !</h2>
              <p>Vous n'êtes pas autorisés à accéder à cette page,<br>
                retournez à la case <a href="<?php printf($config['root_addr']); ?>">départ</a><br>
                <br>
                <span class="err_code">#403</span>
              </p>
          </div>
      </div><?php
    }
    elseif ($_GET['e']=='500') {
      ?>
     <div id="content" class="center_content">
         <div class="error">
             <h2>OH DEAR...</h2>
             <p>Une erreur interne au serveur est survenue,<br>
               si l'administrateur daigne intervenir, merci de réessayer plus tard...<br>
               <br>
               <span class="err_code">#500</span>
             </p>
         </div>
     </div><?php
   }

   elseif ($_GET['e']=='503') {
     ?>
    <div id="content" class="center_content">
        <div class="error">
            <h2>OFFLINE</h2>
            <p>Le serveur subit actuellement une opération de maintenance ou est indisponible pour raisons techniques,<br>
              vous pouvez suivre son avancement sur <a href="">twitter</a>...<br>
              <br>
              <span class="err_code">#503</span>
            </p>
        </div>
    </div><?php
  }

  else {
    ?>
    <div id="content" class="center_content">
        <div class="error">
            <h2>YOU'RE LOST</h2>
            <p>La page recherchée n'existe pas ou plus sur ce serveur,<br>
              cliquez <a href="<?php printf($config['root_addr']); ?>">ici</a> pour retrouver votre chemin<br>
              <br>
              <span class="err_code">#404</span>
            </p>
        </div>
    </div><?php
 }

    ?>
      <?php include ('parts/footer.php'); ?>


      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
      <script src="menubar.js"></script>
      <script src="extras.js"></script>
      <script>
        $(document).ready(function() {
            menu('main',"");
        });
      </script>

  </body>
</html>
