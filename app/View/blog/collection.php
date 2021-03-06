<?php

use App\App;

$title = "Liste des galeries";
$extraCss = "home";
?>

<div class="homePageContainer">

    <div class="titleContainer">
        <h1>Voici les differentes galeries composant la collection '<?= $collection->NAME_COLL; ?>'</h1>
    </div>

    <?php foreach ($galleries as $gallery) :
        $picture = App::getInstance()->getTable('PICTURES')->findFirstPic($gallery->ID_GALL);
    ?>
        <a class="collectionContainer" href="index.php?p=gallery&id=<?= $gallery->ID_GALL; ?>">
            <img class="imgCollection" src="<?= $picture->LINK_PIC; ?>" alt="<?= $picture->NAME_PIC; ?>">
            <p class="nameCollection">Galerie : '<?= $gallery->NAME_GALL; ?>'</p>
        </a>
        <hr>

    <?php endforeach; ?>
</div>