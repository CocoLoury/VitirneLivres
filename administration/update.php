<!DOCTYPE HTML>
<html>
    <head>
        <title>Edit</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Modification du livre</h1>
            </div>
        
            <?php
            $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Livre non trouvé.');
            include '../bdd/connexion.php';
            
            try {
                $query = "SELECT id, titre, resume, auteur, image FROM livres WHERE id = ?";
                $stmt = $con->prepare( $query );
                
                $stmt->bindParam(1, $id);
                
                $stmt->execute();
                
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $titre = $row['titre'];
                $resume = $row['resume'];
                $auteur = $row['auteur'];
                $image = $row['image'];
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
            ?>

            <?php
                if($_POST){            
                
                    try{
                        $query = "UPDATE livres SET titre=:titre, auteur=:auteur, resume=:resume, image=:image WHERE id = :id";
                        $stmt = $con->prepare($query);
                        
                        $titre=htmlspecialchars(strip_tags($_POST['titre']));
                        $auteur=htmlspecialchars(strip_tags($_POST['auteur']));
                        $resume=htmlspecialchars(strip_tags($_POST['resume']));
                        $image=!empty($_FILES["image"]["name"])
                                ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
                                : "";
                        $image=htmlspecialchars(strip_tags($image));
                
                        $stmt->bindParam(':titre', $titre);
                        $stmt->bindParam(':auteur', $auteur);
                        $stmt->bindParam(':resume', $resume);
                        $stmt->bindParam(':image', $image);
                        $stmt->bindParam(':id', $id);

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
                            echo "<div class='alert alert-success'>Mise à jour sauvegardée.</div>";
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
                        <td><input type='text' name='titre' value="<?php echo htmlspecialchars($titre, ENT_QUOTES);?>" class='form-control'/></td>
                    </tr>
                    <tr>
                        <td>Résumé</td>
                        <td><textarea name='resume' class='form-control'><?php echo htmlspecialchars($resume, ENT_QUOTES);?></textarea></td>
                    </tr>
                    <tr>
                        <td>Auteur</td>
                        <td><input type='text' name='auteur' value="<?php echo htmlspecialchars($auteur, ENT_QUOTES);?>" class='form-control'/></td>
                    </tr>
                    <tr>
                        <td>Photo</td>
                        <td><input type='file' name='image' class='form-control'><?php echo htmlspecialchars($image, ENT_QUOTES);?></td>
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
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    </body>
</html>