<!DOCTYPE HTML>
<html>
    <head>
        <title>Vue détaillée</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    
    </head>
    <body>
    
    
        <!-- container -->
        <div class="container">
    
            <div class="page-header">
                <h1>Read Product</h1>
            </div>
            
            <?php
                $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Livre non trouvé.');
                include '../bdd/connexion.php';
                
                try {
                    $query = "SELECT id, titre, resume, auteur, image FROM livres WHERE id = ?";
                    $stmt = $con->prepare($query);
                
                    $stmt->bindParam(1, $id);
                
                    $stmt->execute();
                
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // values to fill up our form
                    $titre = $row['titre'];
                    $resume = $row['resume'];
                    $auteur = $row['auteur'];
                    $image = $row['image'];
                }
                
                // show error
                catch(PDOException $exception){
                    die('ERROR: ' . $exception->getMessage());
                }
            ?>
            <table class='table table-hover table-responsive table-bordered'>
                <tr>
                    <td>Titre</td>
                    <td><?php echo htmlspecialchars($titre, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Résumé</td>
                    <td><?php echo htmlspecialchars($resume, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Auteur</td>
                    <td><?php echo htmlspecialchars($auteur, ENT_QUOTES);  ?></td>
                </tr>
                <tr>
                    <td>Photo</td>
                    <td><?php echo $image ? "<img src='uploads/{$image}' style='width:300px;' />" : "No image found.";  ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href='index.php' class='btn btn-danger'>Retour à la liste des livres</a>
                    </td>
                </tr>
            </table>
    
        </div> <!-- end .container -->
        
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
    </body>
</html>