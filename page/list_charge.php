<?php 
// include("../inc/function.php");
$dateDebut=$_POST["dateDebut"];
$dateFin=$_POST["dateFin"];
$charges = get_charge($connexion,$dateDebut,$dateFin);
$total=get_total($connexion);
$total_row=get_total_row($connexion);

$total_by_repart=get_total_by_repart($connexion);

$t_cout_direct=$total_by_repart[0]["s_matiere_premiere"]+$total_by_repart[0]["s_transformation"];
$cle_mp=($total_by_repart[0]["s_matiere_premiere"]/$t_cout_direct)*100;
$cle_t=($total_by_repart[0]["s_transformation"]/$t_cout_direct)*100;
 

// % admin
$admin_mp=($total_by_repart[0]["s_administration"]*$cle_mp)/100;
$admin_t=($total_by_repart[0]["s_administration"]*$cle_t)/100;

// % distribution
$dist_mp=($total_by_repart[0]["s_distribution"]*$cle_mp)/100;
$dist_t=($total_by_repart[0]["s_distribution"]*$cle_t)/100;

// % magasin
$magasin_mp=($total_by_repart[0]["s_magasin"]*$cle_mp)/100;
$magasin_t=($total_by_repart[0]["s_magasin"]*$cle_t)/100;

$total_mp=$magasin_mp+$dist_mp+$admin_mp+$total_by_repart[0]["s_matiere_premiere"];
$total_t=$magasin_t+$dist_t+$admin_t+$total_by_repart[0]["s_transformation"];


$nombre_fruit=100;

?>
<style>
    table {
    width: 100%; /* Prend toute la largeur disponible */
    border-collapse: collapse; /* Supprime les espaces entre les bordures */
    margin: 25px 0; /* Espacement autour du tableau */
    font-size: 18px; /* Taille de la police */
    font-family: 'Arial', sans-serif; /* Police de caractères */
    text-align: left; /* Aligne le texte à gauche */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Ombre autour du tableau */
}

th, td {
    padding: 12px 15px; /* Espacement interne des cellules */
    border: 1px solid #ddd; /* Bordure légère des cellules */
}

th {
    background-color: #f2f2f2; /* Fond léger pour les en-têtes */
    font-weight: bold; /* Texte en gras pour les en-têtes */
    text-transform: uppercase; /* Transforme le texte en majuscule */
}

tr {
    background-color: #ffffff; /* Fond blanc pour les lignes */
}

tr:nth-child(even) {
    background-color: #f9f9f9; /* Fond gris clair pour les lignes paires */
}

tr:hover {
    background-color: #f1f1f1; /* Changement de couleur lors du survol */
}

td {
    font-weight: normal; /* Texte normal dans les cellules */
}

tfoot td {
    font-weight: bold; /* Texte en gras dans les pieds de table */
    background-color: #f2f2f2; /* Fond gris clair pour les pieds de table */
}

table caption {
    caption-side: bottom; /* Met le titre du tableau en bas */
    font-size: 1.2em;
    padding-top: 10px;
    color: #666;
}

/* Alignement pour des colonnes spécifiques */
.right-align {
    text-align: right; /* Alignement à droite pour les nombres */
}

.center-align {
    text-align: center; /* Alignement au centre */
}

</style>
<div class="form-container ">
    <h2>Du <?php echo $dateDebut?> au <?php echo $dateFin?></h2>
    <table>
        <tr>
            <th rowspan="2">rubrique</th>
            <th rowspan="2">total</th>
            <th rowspan="2">unite d'oeuvre</th>
            <th rowspan="2">nature</th>
            <th colspan="3">Matiere Premiere</th>
            <th colspan="3">Transformation</th>
            <th colspan="3">Administration</th>
            <th colspan="3">Distribution</th>
            <th colspan="3">Magasin</th>
            <th colspan="2">total</th>
        </tr>
        <tr>
            <th>%</th>
            <th>Variable</th>
            <th>Fixe</th>
            <th>%</th>
            <th>Variable</th>
            <th>Fixe</th>
            <th>%</th>
            <th>Variable</th>
            <th>Fixe</th>
            <th>%</th>
            <th>Variable</th>
            <th>Fixe</th>
            <th>%</th>
            <th>Variable</th>
            <th>Fixe</th>
            <th>Variable</th>
            <th>Fixe</th>
        </tr>
<!-- affichage tableau -->
            <?php 
                foreach($charges as $charge){?>
                $total
                    <tr>
                    <td><?php echo $charge['rubrique'];?></td>
                    <td><?php echo $charge['montant']?></td>
                    <td><?php echo $charge['abreviation_unite_oeuvre']?></td>
                    <td><?php echo $charge['nom_nature']?></td>
                    <td><?php echo $charge['Matiere_Premiere']?></td>
                    <?php
                        $m=$charge['montant'];
                        $mp=$charge['Matiere_Premiere'];
                        if($charge['id_nature']==1){ ?>
                                <td><?php echo ($m*$mp)/100?></td>
                                <td>-</td>
                        <?php }
                        else{ ?>
                                <td>-</td>
                                <td><?php echo ($m*$mp)/100?></td>
                       <?php }
                     ?>
<!-- ============ -->
                    <td><?php echo $charge['transformation']?></td>
                    <?php
                        $m=$charge['montant'];
                        $t=$charge['transformation'];
                        if($charge['id_nature']==1){ ?>
                                <td><?php echo ($m*$t)/100?></td>
                                <td>-</td>
                        <?php }
                        else{ ?>
                                <td>-</td>
                                <td><?php echo ($m*$t)/100?></td>
                       <?php }
                     ?>
<!-- ============ -->
                    <td><?php echo $charge['administration']?></td>
                    <?php
                        $m=$charge['montant'];
                        $a=$charge['administration'];
                        if($charge['id_nature']==1){ ?>
                                <td><?php echo ($m*$a)/100?></td>
                                <td>-</td>
                        <?php }
                        else{ ?>
                                <td>-</td>
                                <td><?php echo ($m*$a)/100?></td>
                       <?php }
                     ?>
<!-- ============ -->
                    <td><?php echo $charge['distribution']?></td>
                    <?php
                        $m=$charge['montant'];
                        $d=$charge['distribution'];
                        if($charge['id_nature']==1){ ?>
                                <td><?php echo ($m*$d)/100?></td>
                                <td>-</td>
                        <?php }
                        else{ ?>
                                <td>-</td>
                                <td><?php echo ($m*$d)/100?></td>
                       <?php }
                     ?>
<!-- ============ -->
                    <td><?php echo $charge['magasin']?></td>
                    <?php
                        $m=$charge['montant'];
                        $mg=$charge['magasin'];
                        if($charge['id_nature']==1){ ?>
                                <td><?php echo ($m*$mg)/100?></td>
                                <td>-</td>
                        <?php }
                        else{ ?>
                                <td>-</td>
                                <td><?php echo ($m*$mg)/100?></td>
                       <?php }
                     ?>
                      <?php
                        $m=$charge['montant'];
                        if($charge['id_nature']==1){ ?>
                                <td><?php echo $m ?></td>
                                <td>-</td>
                        <?php }
                        else{ ?>
                                <td>-</td>
                                <td><?php echo  $m ?></td>
                       <?php }
                     ?>

                    </tr>
            <?php } ?>
<!-- creation ===================================================================== -->
                    <tr>
                        <td>TOTAL</td>
                        <td><?php echo $total_row[0]["montant"]+$total_row[1]["montant"] ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                     
                        <td><?php echo $total_row[0]["t_Matiere_premiere"]?></td>  
                        <td><?php echo $total_row[1]["t_Matiere_premiere"]?></td>
                        <td></td>
                        <td><?php echo $total_row[0]["t_transformation"]?></td>  
                        <td><?php echo $total_row[1]["t_transformation"]?></td>
                        <td></td>
                        <td><?php echo $total_row[0]["t_administration"]?></td>  
                        <td><?php echo $total_row[1]["t_administration"]?></td>
                        <td></td>
                        <td><?php echo $total_row[0]["t_distribution"]?></td>  
                        <td><?php echo $total_row[1]["t_distribution"]?></td>
                        <td></td>
                        <td><?php echo $total_row[0]["t_magasin"]?></td>  
                        <td><?php echo $total_row[1]["t_magasin"]?></td>


                        <td><?php echo $total[0]["total"]?></td>  
                        <td><?php echo $total[1]["total"]?></td>
                    </tr>
    </table>


    <table>
        <tr>
            <th>repartition</th>
            <th>cout direct</th>
            <th>cles</th>
            <th>administration</th>
            <th>distribution</th>
            <th>magasin</th>
            <th>cout total</th>
        </tr>
        <tr>
            <td>Matiere Premiere</td>
            <td><?php echo $total_by_repart[0]["s_matiere_premiere"];?></td>
            <td><?php echo $cle_mp?></td>
            <td><?php  echo $admin_mp?></td>
            <td><?php echo $dist_mp?></td>
            <td><?php echo $magasin_mp?></td>
            <td><?php echo $total_mp?></td>
        </tr>
        <tr>
            <td>Transformation</td>
            <td><?php echo $total_by_repart[0]["s_transformation"];?></td>
            <td><?php echo $cle_t?></td>
            <td><?php  echo $admin_t?></td>
            <td><?php echo $dist_t?></td>
            <td><?php echo $magasin_t?></td>
            <td><?php echo $total_t?></td>
        </tr>
        <tr>
            <td>Total general</td>
            <td><?php echo $t_cout_direct?></td>
            <td></td>
            <td><?php echo $admin_mp+$admin_t?></td>
            <td><?php echo $dist_t+$dist_mp?></td>
            <td><?php echo $magasin_mp+$magasin_t?></td>
            <td><?php echo $total_t+$total_mp?></td>
        </tr>
    </table>
    <table>
        <tr>
            <th colspan="2">Cout de l'unite du jus</th>
        </tr>
        <tr>
            <td>unite d'oeuvre</td>
            <td>kg de fruit</td>
        </tr>
        <tr>
            <td>nombre</td>
            <td><?php echo $nombre_fruit?></td>
        </tr>
        <tr>
            <td>cout matiere premiere</td>
            <td><?php echo $total_mp?></td>

        </tr>
            <tr>
                <td>cout transformation</td>
                <td><?php echo $total_t?></td>
            </tr>
            <tr>
                <td>COUT TOTAUX</td>
                <td><?php echo  $total_t+$total_mp?></td>
            </tr>
            <tr>
                <td>cout de l'unite de jus</td>
                <td><?php echo ($total_t+$total_mp)/$nombre_fruit?></td>
            </tr>
    </table>
</div>