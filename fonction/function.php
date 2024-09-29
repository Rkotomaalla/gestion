<?php 


//creation fonction insertRubrique

function insertRubrique($conn, $nom_rubrique, $id_unite) {

    $nom = mysqli_real_escape_string($conn, $nom_rubrique);
    $id_unite =$id_unite ? (int)$id_unite : 'NULL'; 
    $sql = "INSERT INTO rubrique (id_rubrique,nom_rubrique,id_unite_oeuvre) VALUES (null,'$nom',$id_unite)";
    if (mysqli_query($conn, $sql)) {
        return true;
    } else {
        return false;
    }
}

//creation fonction insertCharge

function insertCharge($conn,$id_rubrique,$id_nature,$id_type,$unite,$montant,$date_charge) 
{
     // Échapper les valeurs pour éviter les injections SQL
     $id_rubrique = mysqli_real_escape_string($conn, $id_rubrique);
     $id_nature = mysqli_real_escape_string($conn, $id_nature);
     $id_type = mysqli_real_escape_string($conn, $id_type);
     $unite = mysqli_real_escape_string($conn, $unite);
     $montant = mysqli_real_escape_string($conn, $montant);
     $date_charge = mysqli_real_escape_string($conn, $date_charge);
 
     // Requête d'insertion
     $sql = "INSERT INTO charge (id_charge,id_nature, id_rubrique, id_type, unite, montant, date_charge) 
             VALUES (null,'$id_nature', '$id_rubrique', '$id_type', '$unite', '$montant', '$date_charge')";
 
     // Exécution de la requête et vérification des erreurs
     if (mysqli_query($conn, $sql)) {
         return true;
     } else {
         return false;
     }
}

//cretion fonction getAllCharge(dateDebut,dataFin)

function getAllCharge($conn, $dateDebut, $dateFin) 
{
    $dateDebut = mysqli_real_escape_string($conn, $dateDebut);
    $dateFin = mysqli_real_escape_string($conn, $dateFin);
    $sql = "SELECT * FROM charge WHERE date BETWEEN '$dateDebut' AND '$dateFin'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $charges = array();
        while($row = mysqli_fetch_assoc($result)) {
            $charges[] = $row;
        }
        return $charges; 
    } else {
        return array(); 
    }
}































//fonction calcul cout de l unite du jus(quantite du fruit,total coup par repartition)

function calculCoutUnitaire($quantiteFruits, $coutTotal) {
    if ($quantiteFruits <= 0) {
        return "Erreur";
    }
    
    if ($coutTotal < 0) {
        return "Erreur";
    }

    // Calcul du coût unitaire
    $coutUnitaire = $coutTotal / $quantiteFruits;

    return round($coutUnitaire, 2);
}

?>