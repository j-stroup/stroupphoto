<!doctype HTML>
<html>
  <?php include 'head.php';?>

    <body>
      <?php include 'menu.php';?>


    <section id="slideshow">
      <div id="slidewindow">

        <?php
            function rasmname(){
             $dirname = "./images/people/";
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
