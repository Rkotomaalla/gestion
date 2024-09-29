<?php 
include("../../inc/function.php");
if(isset($_POST["action"])){
    $action = $_POST["action"];
    if($action == "insert_rubrique"){
        $nom_rubrique=$_POST["nom_rubrique"];
        $id_unite=$_POST["unite"];
        if(insertRubrique($connexion,$nom_rubrique,$id_unite)){
            $message=1;
        }
        else{
            $message= 0;
        }
        header("location:../model.php?page=rubrique.php&&message=".$message);
    }
    else if($action == "insert_charge"){
        $id_rubrique=$_POST["idRubrique"];
        $id_nature=$_POST["nature"];
        $id_type=$_POST["type"];
        $unite=$_POST["unite"];
        $montant=$_POST["montant"];
        $date_charge=$_POST["date"];
        $repartitions=$_POST["repartition"];
        
        if(setRepartition($repartitions)){
            if(insertCharge($connexion,$id_rubrique,$id_nature,$id_type,$unite,$montant,$date_charge,$repartitions)){
                $message=1;
            }   
            else{
                $message= 0;
                header("location:../model.php?page=charge.php&&message=".$message);
            }
            header("location:../model.php?page=charge.php&&message=".$message);
        }
        else{
            $message=-1;
            header("location:../model.php?page=charge'.php&&message=".$message);
        }

    }
}
?>