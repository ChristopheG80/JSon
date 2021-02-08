<?php

//Boucle pour compter les images à afficher
$cpt = 0;
if (file_exists('assets/js/galerieJson.json')) {
   $fileJson = 'assets/js/galerieJson.json';
   $a = file_get_contents($fileJson);
   
   $tablo = json_decode($a, true);

      ?>
      <div class="container-fluid">
         <div class="row">
      <?php
   foreach ($tablo as $jcase) {
      ?>
      <div class="col-3 p-2"><img src="<?=$jcase;?>" alt="" class="img-fluid rounded-lg"></div>
      <?php
      //$cpt ++;
   }
   ?>
      </div></div>
      <?php

?>



<?php
}
else{
   echo 'Choisir un fichier';
}
?>
