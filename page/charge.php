    <!-- php rehetra -->
     <?php
     $natures=get_all($connexion,"nature");
     $rubriques=get_all($connexion,"rubrique");
     $types=get_all($connexion,"type_charge");
     $repartitions=get_all($connexion,"repartition");
     ?>
<div class="form-container">    
        <!-- Formulaire d'insertion Charge -->
    <form id="chargeForm" class="form" method="post" action="traitement/traitement_insertion.php">
        <h2>Formulaire d'insertion Charge</h2>
        <label for="idRubrique">Rubrique :</label>
        <select id="idRubrique" name="idRubrique" required>
            <option value="" hidden selected></option>
<!-- list of rubrique -->
            <?php foreach($rubriques as $rubrique){?>
                <option value="<?php echo $rubrique['id_rubrique'];?>"><?php echo $rubrique['nom_rubrique'];?></option>
            <?php }?>
<!-- :: -->
        </select>

        <label>Nature :</label>
        <div class="radio-group">            
<!-- list of nature -->
            <?php foreach($natures as $nature){?>
                <label for="<?php echo $nature['id_nature'];?>">
                    <input type="radio" id="<?php echo $nature['id_nature'];?>" name="nature" value="<?php echo $nature['id_nature'];?>">
                    <?php echo $nature['nom_nature'];?>
                </label>
            <?php }?>
<!-- :: -->             
        </div>

        <label>Type :</label>
        <div class="radio-group">            
<!-- list of nature -->
            <?php foreach($types as $type){?>
                <label for="<?php echo $type['id_type_charge'];?>">
                    <input type="radio" id="<?php echo $type['id_type_charge'];?>" name="type" value="<?php echo $type['id_type_charge'];?>">
                    <?php echo $type['nom_type_charge'];?>
                </label>
            <?php }?>
<!-- :: -->             
        </div>

        <label for="unite">Unité :</label>
        <input type="number" id="unite" name="unite" step="0.01" required>

        <label for="montant">Montant :</label>
        <input type="number" step="0.01" id="montant" name="montant" step="0.01" required>

        <label for="date">Date :</label>
        <input type="date" id="date" name="date" required>
            
        <label for="repartition">Repartition (en %):</label>
        <?php if(isset($_GET["message"]) && $_GET["message"]==-1){ ?>
        <p style="color:red">La somme des totals des % doit être égale à 100%</p>
        <?php }?>
<!-- insert repartition -->
        <?php foreach($repartitions as $repartition){?>
            <label for="<?php  echo $repartition["id_repartition"]?>"><?php  echo $repartition["nom_repartition"]?></label>
            <input  type="number" step="0.01" id="repartition" name="repartition[<?php echo $repartition["id_repartition"]?>]"required >
        <?php  } ?>
<!-- :: -->
        <input type="hidden" name="action" value="insert_charge">
        <button type="submit">Enregistrer</button>
    </form>
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
</div>