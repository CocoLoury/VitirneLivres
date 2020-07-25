<?php

$host = "localhost";
$db_name = "clem";
$username = "root";
$password = "";

try
{
    $con = new PDO("mysql:host={$host};dbname={$db_name}", $username, $password);
}

catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

//$response = $bdd->query('SELECT * FROM livres');

/*while ($donnee = $response->fetch())
{
    echo $donnee['auteur'] . ' à écrit le livre ' . '<i>' . $donnee['titre'] . '</i>' . '<br/>';
}
$response->closeCursor();*/

?>