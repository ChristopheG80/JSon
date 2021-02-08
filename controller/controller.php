<?php
$show = false;
function convertImage($source, $dst, $width, $height, $quality){
   // voir pour que cela fonctionne pour tous les formats d'image
   $imageSize = getimagesize($source) ;
   $imageRessource= imagecreatefromjpeg($source) ;
   $imageFinal = imagecreatetruecolor($width, $height) ;
   $final = imagecopyresampled($imageFinal, $imageRessource, 0,0,0,0, $width, $height, $imageSize[0], $imageSize[1]) ;
   imagejpeg($imageFinal, $dst, $quality) ;
 }


if($_SERVER['REQUEST_METHOD'] == 'POST'){
   //var_dump('Method POST');
   $a = '';
   //var_dump($_FILES);
   // Chargement des images
   if(isset($_FILES)){
      
      $a = array();
      //var_dump($_FILES);
      foreach($_FILES as $img){
         if(($img['error'] == 0) && ($img['type'] == 'image/jpeg')){
            $uploaddir = 'assets/images/';
            $date = date_create();
            $uploadname = date_timestamp_get($date) . substr(microtime(),2,6) . '.' . substr($img['name'],-3);
            $uploadfile = $uploaddir . $uploadname;
            //var_dump($uploadfile);
            if (move_uploaded_file($img['tmp_name'], $uploadfile)) {
               $x = 500; //# largeur a redimensionner
               $y = 150; //# hauteur a redimensionner
               $quality = 100; // qualité de l'image
               $before = $uploadfile; // répertoire avant
               $after = $uploadfile; // essai avec le même nom
               convertImage($before, $after, $x, $y, $quality);
               //var_dump($after);
               $a[] = $after;
               //echo 'Le fichier' . ' ' . 'est valide, et a été téléchargé avec succès.';
            } else {
               echo "Attaque potentielle par téléchargement de fichiers. Voici plus d'informations :";
            }
         }
      }
      //var_dump($a);
//création du fichier JSON
$fileJson = 'assets/js/galerieJson.json';

if(file_exists($fileJson)){
   $json = file_get_contents($fileJson);
   //Décoder le fichier JSon
   $tablo = json_decode($json);
   // var_dump($tablo);
   // die();
   //Ajouter le dernier nom de fichier dans le tableau
   $tablo = array_merge($tablo, $a);
   //Encoder le fichier JSon
   $dataJSon = json_encode($tablo);
   //Ecraser le fichier JSon
   file_put_contents($fileJson,$dataJSon);
}
else{
   //Le fichier JSon n'existe pas il faut encoder puis créer le fichier

   $dataJSon = json_encode($a);
   file_put_contents($fileJson,$dataJSon);


}

$show = true;

  }
  



  
  
  //création ou modification du fichier JSON



}


?>