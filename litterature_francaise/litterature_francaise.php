<html>
    <head>
        <!-- Obligatoire -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Inclure le fichier CSS -->
        <link rel="stylesheet" href="litterature_francaise.css" />
        <!-- A mettre pour utilisé Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>Française</title>
    </head>
    <body>
        <?php
            // Pour lire le fichier connexion.php
            include '../bdd/connexion.php';

            try {
                // Pour lire le fichier connexion.php
                $response = $con->query('SELECT * FROM livres WHERE type="historique"');
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        ?>
        <div class="container">
            <h1 class="title">Livres littérature française</h1>
            <?php
                if($response != null){
            ?>
            <div class="card-deck">
                <?php
                    while ($donnee = $response->fetch())
                    {
                ?>
                <div class="col-sm-12" id="column">
                    <div class="card border-0 mb-12">
                        <div class="row no-gutters">
                            <div class="col-md-4">
                                <?php echo $donnee['image'] ? "<img class='card-img' src='../administration/uploads/{$donnee['image']}' alt='Image de présentation' />" : "No image found.";  ?>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $donnee['titre'] ?></h5>
                                    <p class="card-text"><?php echo $donnee['resume'] ?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo $donnee['auteur'] ?></small></p>
                                    <a href="#" class="btn btn-primary">En savoir plus</a>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
                <?php
                    }
                ?>
            </div>
            <?php
                }
                else{
                    echo 'aucun livre histrorique';
                }
            ?>
        </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>