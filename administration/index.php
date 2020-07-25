<!DOCTYPE HTML>
<html>
    <head>
        <title>Vue d'ensemble</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
        <style>
        .m-r-1em{ margin-right:1em; }
        .m-b-1em{ margin-bottom:1em; }
        .m-l-1em{ margin-left:1em; }
        .mt0{ margin-top:0; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>Vue d'ensemble</h1>
            </div>
            <?php
                include '../bdd/connexion.php';

                //Pagination
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $records_per_page = 5;                
                $from_record_num = ($records_per_page * $page) - $records_per_page;
                $action = isset($_GET['action']) ? $_GET['action'] : "";
 

                if($action=='deleted'){
                    echo "<div class='alert alert-success'>Le livre a été supprimé.</div>";
                }     
                
                $query = "SELECT id, titre, resume, auteur, image FROM livres LIMIT :from_record_num, :records_per_page";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
                $stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
                $stmt->execute();
                
                $num = $stmt->rowCount();
                
                echo "<a href='create.php' class='btn btn-primary m-b-1em'>Ajouter un nouveau livre</a>";
                                
                if($num>0){
                
                    echo "<table class='table table-hover table-responsive table-bordered'>";
                    echo "<tr>";
                        echo "<th>ID</th>";
                        echo "<th>Titre</th>";
                        echo "<th>Résumé</th>";
                        echo "<th>Auteur</th>";
                        echo "<th>Photo</th>";
                        echo "<th>Action</th>";
                    echo "</tr>";
                    
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                            echo "<tr>";
                            echo "<td>{$id}</td>";
                            echo "<td>{$titre}</td>";
                            echo "<td>{$resume}</td>";
                            echo "<td>{$auteur}</td>";
                            echo "<td>{$image}</td>";
                            echo "<td>";
                                echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em'>Voir</a>";
                                echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em'>Editer</a>";
                                echo "<a href='#' onclick='delete_user({$id});'  class='btn btn-danger'>Supprimer</a>";
                            echo "</td>";
                        echo "</tr>";
                    }
                echo "</table>";
                $query = "SELECT COUNT(*) as total_rows FROM livres";
                $stmt = $con->prepare($query);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $total_rows = $row['total_rows'];

                $page_url="index.php?";
                include_once "paging.php";
                }
                else{
                    echo "<div class='alert alert-danger'>Aucun livre trouvé.</div>";
                }
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>   
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>     
        <script type='text/javascript'>
            function delete_user( id ){
                
                var answer = confirm('Voulez vous vraiment supprimer le livre ?');
                if (answer){
                    window.location = 'delete.php?id=' + id;
                } 
            }
        </script>

    </body>
</html>