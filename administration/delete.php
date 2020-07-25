<?php

    include '../bdd/connexion.php';
    
    try {
        $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Aucun livre trouvé.');
    
        // delete query
        $query = "DELETE FROM livres WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bindParam(1, $id);
        
        if($stmt->execute()){
            header('Location: index.php?action=deleted');
        }else{
            die('Suppression échoué.');
        }
    }
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
?>