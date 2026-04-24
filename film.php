<!doctype HTML>
<html>
<head>
    <title>Jeffrey Stroup</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width">
    <link href="css/styles.css" rel="stylesheet" type="text/css">
    <script src="js/display.js"></script>
</head>
    <body>
      <?php include 'menu.php';?>


    <section id="slideshow">
      <div id="slidewindow">

        <?php
            function rasmname(){
             $dirname = "./images/film/";
            $images = glob($dirname."*.jpg");
            foreach($images as $image) {
             echo '<div><img src="'.$image.'" /></div>';
                  }
            }
            rasmname();
        ?>

      </div>
  <div id="controls">
    <a id="next">
      <div></div>
    </a>
    <ul id="dots"></ul>
    <a id="prev">
      <div></div>
    </a>
  </div>
</section>

<?php include 'footer.php';?>

    </body>
</html>
