        <!-- Formulaire d'insertion Charge -->
        <form id="chargeForm" class="form hidden">
            <h2>Formulaire d'insertion Charge</h2>
            <label for="idRubrique">Rubrique :</label>
            <select id="idRubrique" name="idRubrique" required>
                <option value="rubrique1">Rubrique 1</option>
                <option value="rubrique2">Rubrique 2</option>
            </select>

            <label>Nature :</label>
            <div class="radio-group">       
                <label for="fixe">
                    <input type="radio" id="fixe" name="nature" value="fixe">
                    Fixe
                </label>        
                <label for="variable">
                    <input type="radio" id="variable" name="nature" value="variable">
                    Variable
                </label>
            </div>

            <label for="unite">Unité :</label>
            <input type="number" id="unite" name="unite" required>

            <label for="montant">Montant :</label>
            <input type="number" step="0.01" id="montant" name="montant" required>

            <label for="date">Date :</label>
            <input type="date" id="date" name="date" required>
            
            <label for="repartition">Repartition :</label>
            <input type="number" id="repartition" name="repartition" required><br><br>
            <button type="submit">Soumettre</button>
        </form>