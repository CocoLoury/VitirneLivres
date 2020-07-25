<html>
    <head>
        <title>Administration</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container">
   
            <div class="page-header">
                <h1>Ajout d'un livre</h1>
            </div>

            <?php
                if($_POST){
                
                    include '../bdd/connexion.php';
                
                    try{
                        $query = "INSERT INTO livres SET titre=:titre, auteur=:auteur, resume=:resume, type=:type, image=:image";
                        $stmt = $con->prepare($query);
                
                        $titre=htmlspecialchars(strip_tags($_POST['titre']));
                        $auteur=htmlspecialchars(strip_tags($_POST['auteur']));
                        $resume=htmlspecialchars(strip_tags($_POST['resume']));
                        $type=htmlspecialchars(strip_tags($_POST['type']));
                        $image=!empty($_FILES["image"]["name"])
                                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                                : "";
                        $image=htmlspecialchars(strip_tags($image));
                
                        $stmt->bindParam(':titre', $titre);
                        $stmt->bindParam(':auteur', $auteur);
                        $stmt->bindParam(':resume', $resume);
                        $stmt->bindParam(':type', $type);
                        $stmt->bindParam(':image', $image);

                        if($image){

                            $target_directory = "uploads/";
                            $target_file = $target_directory . $image;
                            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                            $file_upload_error_messages="";

                            $check = getimagesize($_FILES["image"]["tmp_name"]);
                            if($check!==false){
                                // submitted file is an image
                            }else{
                                $file_upload_error_messages.="<div>Votre fichier n'est pas une image.</div>";
                            }
                            $allowed_file_types=array("jpg", "jpeg", "png", "gif");
                            if(!in_array($file_type, $allowed_file_types)){
                                $file_upload_error_messages.="<div>Seulement les formats JPG, JPEG, PNG, GIF sont acceptés.</div>";
                            }
                            if(file_exists($target_file)){
                                $file_upload_error_messages.="<div>L'image exite déjà, essayer de changer le name.</div>";
                            }
                            if($_FILES['image']['size'] > (1024000)){
                                $file_upload_error_messages.="<div>L'image est trop grande, la taille maximum est de 1 MB.</div>";
                            }
                            if(!is_dir($target_directory)){
                                mkdir($target_directory, 0777, true);
                            }
                            if(empty($file_upload_error_messages)){
                                // it means there are no errors, so try to upload the file
                                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                                    // it means image was uploaded
                                }else{
                                    echo "<div class='alert alert-danger'>";
                                        echo "<div>Unable to upload image.</div>";
                                        echo "<div>Update the record to upload image.</div>";
                                    echo "</div>";
                                }
                            }
                             
                            // if $file_upload_error_messages is NOT empty
                            else{
                                // it means there are some errors, so show them to user
                                echo "<div class='alert alert-danger'>";
                                    echo "<div>{$file_upload_error_messages}</div>";
                                    echo "<div>Update the record to upload image.</div>";
                                echo "</div>";
                            }
                        }
                        
                        if($stmt->execute()){
                            echo "<div class='alert alert-success'>Nouveau livre ajouté.</div>";
                        }else{
                            echo "<div class='alert alert-danger'>Erreur dans la sauvegarde.</div>";
                        }
                        
                    }
                    catch(PDOException $exception){
                        die('ERROR: ' . $exception->getMessage());
                    }
                }
                ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Titre</td>
                    <td><input type='text' name='titre' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Résumé</td>
                    <td><textarea name='resume' class='form-control'></textarea></td>
                </tr>
                <tr>
                    <td>Auteur</td>
                    <td><input type='text' name='auteur' class='form-control' /></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td>
                    <div class="input-group mb-3">
                        <select name='type' class="custom-select form-control" id="inputGroupSelect01">
                            <option selected>Choisir...</option>
                            <option value="historique">Historique</option>
                            <option value="Science fiction">Science fiction</option>
                            <option value="Fantastique">Fantastique</option>
                            <option value="Littérature française">Littérature française</option>
                            <option value="Littérature classique">Littérature classique</option>
                        </select>
                    </div>
                    </td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><input type='file' name='image' class='form-control' /></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type='submit' value='Sauvegarder' class='btn btn-primary' />
                        <a href='index.php' class='btn btn-danger'>Retour à la liste des livres</a>
                    </td>
                </tr>
            </table>
        </form>
        </div> <!-- end .container -->
 
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    </body>
</html>