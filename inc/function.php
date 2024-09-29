<?php 
include("connexion.php");

// fonction get all 
function get_all($connexion,$table_name){
    $table_name = mysqli_real_escape_string($connexion, $table_name);
    $sql="SELECT * FROM $table_name";
    $resultat=mysqli_query($connexion,$sql);
    $data=[];
// en cas d'erreur
    if(!$resultat){

    }
    while($row=mysqli_fetch_array($resultat, MYSQLI_ASSOC)){
        $data[]=$row;
    } 
    mysqli_free_result($resultat);
    return $data;
} 

function get_charge($connexion,$date_debut,$date_fin){
    $date_debut = mysqli_real_escape_string($connexion, $date_debut);
    $date_fin = mysqli_real_escape_string($connexion, $date_fin);
    $sql="SELECT * FROM v_all_charge WHERE date_charge >= '".$date_debut."' AND date_charge <= '".$date_fin."'";
    $result = mysqli_query($connexion, $sql);
    if (mysqli_num_rows($result) > 0) {
        $charges = array();
        while($row = mysqli_fetch_array ($result)) {
            $charges[] = $row;
        }
        mysqli_free_result($result);
        return $charges; 
    } else {
        mysqli_free_result($result);
        return false;
    }
}

function get_total($connexion){
    $sql="SELECT * FROM total_nature";
    $resultat=mysqli_query ($connexion,$sql);
    $data=array();
    while($row=mysqli_fetch_array($resultat)){
        $data[]=$row;
    }
    mysqli_free_result($resultat);
    return $data;
}

function get_total_row($connexion){
    $sql="SELECT * FROM v_total_join";
    $resultat=mysqli_query ($connexion,$sql);
    $data=array();
    while($row=mysqli_fetch_array($resultat)){
        $data[]=$row;
    }
    mysqli_free_result($resultat);
    return $data;
}
function get_total_by_repart($connexion){
    $sql="SELECT * FROM total_repart";
    $resultat=mysqli_query ($connexion,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($resultat)){
        $data[]=$row;
    }
    mysqli_free_result($resultat);
    return $data;
}
// fonction insert rehetra=================================
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

function insertCharge($conn,$id_rubrique,$id_nature,$id_type,$unite,$montant,$date_charge,$repartitions) 
{
     // Échapper les valeurs pour éviter les injections SQL
     $id_rubrique = (int)$id_rubrique;
     $id_nature = (int)$id_nature;
     $id_type = (int)$id_type;
     $unite = mysqli_real_escape_string($conn, $unite);
     $montant = mysqli_real_escape_string($conn, $montant);
     $date_charge = mysqli_real_escape_string($conn, $date_charge);
 
     $id_c=verify_isset_charge($conn,$id_rubrique);
     if($id_c===-1){
            // Requête d'insertion
            $sql = "INSERT INTO charge (id_charge,id_nature, id_rubrique, id_type, unite, montant, date_charge) 
            VALUES (null,$id_nature, $id_rubrique,$id_type,$unite,$montant,'$date_charge')";

            // Exécution de la requête et vérification des erreurs
            if (mysqli_query($conn, $sql)) {
            $idCharge=mysqli_insert_id($conn);
            foreach ($repartitions as $id_repartition => $value) {
                // Appel d'une fonction pour enregistrer dans la base de données
                if(insertChargeRepartition($conn,$idCharge,$id_repartition,$value)){
                }
                else{
                    return false;
                }

            }
            return true;
            } else {
            return false;
            }
     }else{
        $repartitions=get_cle($conn,$id_c[0]['id_charge']);
        $sql = "INSERT INTO charge (id_charge,id_nature, id_rubrique, id_type, unite, montant, date_charge) 
        VALUES (null,$id_nature, $id_rubrique,$id_type,$unite,$montant,'$date_charge')";
        
      if (mysqli_query($conn, $sql)) {
        $idCharge=mysqli_insert_id($conn);
        insertChargeRepartition($conn,$idCharge,1,$repartitions[0]['Matiere_Premiere']);
        insertChargeRepartition($conn,$idCharge,2,$repartitions[0]['transformation']);
        insertChargeRepartition($conn,$idCharge,3,$repartitions[0]['administration']);
        insertChargeRepartition($conn,$idCharge,4,$repartitions[0]['distribution']);
        insertChargeRepartition($conn,$idCharge,5,$repartitions[0]['magasin']);
       
        return true;
      }
      else{
        return false;
      }


     }
     
}

function insertChargeRepartition($conn,$id_Charge,$id_repartition,$taux){
    $id_repartition=(int)$id_repartition;
    $id_Charge=(int)$id_Charge;
    $taux=mysqli_real_escape_string($conn, $taux);

    $sql="INSERT INTO charge_repartition (id_charge_repartition,id_charge,id_repartition,taux) VALUES (null,$id_Charge,$id_repartition,$taux)";
    if (mysqli_query($conn, $sql)) {
        return true;
    }
    else{
        return false;
    }

}

// funciton de verififcation 
function setRepartition($repartitions){
    $total=0;
    foreach ($repartitions as $id_repartition => $value) {
        // Appel d'une fonction pour enregistrer dans la base de données
        $total+=$value;
    }
    if($total==100){
        return true;
    }
    else{
        return false;
    }
}

// fonction de verification rehetra 
function verify_isset_charge($connexion,$idRubrique){
    $sql="SELECT id_charge FROM charge WHERE id_rubrique =".$idRubrique;
    // retourn l id sinon -1
    $data=array();
    $result=mysqli_query($connexion, $sql);
    if(mysqli_num_rows($result)> 0){
        while($row=mysqli_fetch_array($result)){
            $data[]=$row;
        }
    }
    else{
        return -1;
    }
    mysqli_free_result($result);
    return $data;
   
}
function get_cle($connexion,$idcharge){
    $sql="SELECT *  FROM v_repartition  WHERE id_charge =".$idcharge;
    $data=[];
    // retourn l id sinon -1
    $result=mysqli_query($connexion, $sql);
        while($row=mysqli_fetch_array($result)){
            $data[]=$row;
        }
        mysqli_free_result($result);
        return $data;
   
}
?>