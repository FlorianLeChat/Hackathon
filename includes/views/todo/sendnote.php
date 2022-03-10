<?php
    include("BDD.php");

    $creator = 1;
    $titrenote = $_POST["titre"];
    $note = $_POST["description"];
    $action = $_POST["action"];
    $note = $_POST["description"];
    

    $ajout = $pdo->prepare("INSERT INTO `notes`(`creator_id`, `title`, `description`, `state`) VALUES (?,?,?,?)");
    $recupinfouser = $pdo->prepare("SELECT avatar_url FROM users JOIN notes ON client_id = creator_id WHERE creator_id = ?;")->fetch();
    $deletenote = $pdo->prepare("DELETE FROM `notes` WHERE `note_id` = ?;");


    if($action == "Ajouter"){
        $ajout->execute([$creator,$titrenote,$note,"A faire"]);
        $avatar = $pdo->query("SELECT avatar_url,note_id FROM users JOIN notes ON client_id = creator_id WHERE creator_id = $creator;")->fetch();
        echo json_encode([ 'creator' => $creator, 'titre' => $titrenote, 'note' => $note, 'avatar' => $avatar["avatar_url"], 'note-id' => $avatar["note_id"]]);
    }
    else if($action == "Supprimer"){
        $note_id = $_POST["note_id"];
        $deletenote->execute([$note_id]);
    }
    else if($action == "Sauvegarder"){
        $note_id = $_POST["note_id"];
        $pdo->query("UPDATE `notes` SET `title`='$titrenote',`description`='$note' WHERE `note_id` = $note_id");
    }
    else if($action == "Terminer"){
        $note_id = $_POST["note_id"];
        $do = $_POST["do"];
        $pdo->query("UPDATE `notes` SET `state`='$do' WHERE `note_id` = $note_id");
    }
?>