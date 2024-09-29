<!-- fonction php -->
 <?php
     $unites=get_all($connexion,"unite_oeuvre");
 ?>
<!-- Conteneur principal pour les formulaires -->
    <div class="form-container">
<!-- Formulaire d'insertion Rubrique -->
        <form id="rubriqueForm" class="form hidden" method="post" action="traitement/traitement_insertion.php"  >
            <h2>Formulaire d'insertion Rubrique</h2>
<!-- nom de la rubrique -->
            <label for="nom_rubrique">Nom de la rubrique:</label>
            <input type="text" id="nom_rubrique" name="nom_rubrique" required><br><br>
<!-- unite d'oeuvre de la rubrique -->
            <label>Unité d'œuvre :</label>
                <select name="unite" id="" required>
                        <option value="" selected hidden></option>
                        <?php foreach($unites as $unite){?>
                            <option value="<?php echo $unite['id_unite_oeuvre'];?>"><?php echo $unite['nom_unite_oeuvre'];?></option>
                        <?php }?>
                </select>
            <br><br>
            <input type="hidden" name="action" value="insert_rubrique">
            <button type="submit">Ajouter</button>

<!-- affichage message erreur ou succes -->
<?php
        if(isset($_GET['message'])){
            $message = $_GET['message'];
            if($message==1){
?>
                    <h3 style="color: green;">ajout rubrique avec succes</h3>
<?php                 
            }
            else if($message==0){
?>
                    <h3 style="color: red;">ajout rubrique a rencontrer un erreur</h3>
<?php 
            }
        }
?>
        </form>
    </div>
