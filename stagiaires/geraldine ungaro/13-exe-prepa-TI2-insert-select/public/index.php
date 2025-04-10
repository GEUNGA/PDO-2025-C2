<?php
# public/index.php

/*
 * Contrôleur frontal
 */

# chargement des constantes de connexion en mode prod
require_once "../config.php";
# chargement du modèle (fonctions)
require_once "../model/MessagesModel.php";

# connexion à PDO

try{
    $db = new PDO(DB_DSN, DB_CONNECT_USER, DB_CONNECT_PWD,
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]
    );
}catch(Exception $e){
    die("Code : {$e->getCode()} <br> Message : {$e->getMessage()}");
}

# ici notre code de traitement de la page

// si on a envoyé le formulaire avec les bons champs

if(isset($_POST['name'],$_POST['email'],$_POST['message'])){

    // on va tenter l'insertion, car on a protégé addMessage()
    $insert = addMessage($db,$_POST['name'],$_POST['email'],$_POST['message']);

    if($insert===true){
        $thanks = "Merci pour votre nouveau message";
    }else{
        $error = $insert;
    }

}

// on veut récupérer tous les messages de la table `article`



$messages = getAllMessagesOrderByDateDesc($db);



# chargement de la vue
require_once "../view/homepage.view.php";

# bonne pratique
# fermeture de connexion
$db = null;