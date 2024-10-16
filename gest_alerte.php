<?php
require_once('cn.php');
session_start();
if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
} 
require_once("alertes_data.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIG-parc</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="2style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

</head>
<style>
.gest_veh-1{
font-size: 28px;
margin: -9px px 0px 0px;
font-weight: bold;
color: #003366;
left: 20%; /* Décale le texte vers le centre */
}
</style>
<body>
<?php
include('navbar.php');
?>
<div class="container">
    <div class="container-2">
        <form action="page.php" method="POST">
            <div class="form-group">
                <!-- Retour au Menu d'accueil -->
                <button class="go-home-btn" type="submit" name="home">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                </button>
                <!-- Page du Jour -->
                <p class="gest_veh">Gestions des Alertes</p>
            </div>
        </form>
        <div class="form-group">
        <div class="container-R-1">
            <form action="page.php" method="POST">
                <p class="gest_veh-1">+ Presque expirer</p>
                <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-responsables">
                        <span>Assurance</span><br>
                        <i class="fa fa-shield-alt"> <?= $totalPresqueAssurance?></i>
                    </div>
                    <div class="btn btn-responsables">
                        <span>Entretien</span><br>
                        <i class="fa fa-tools"> <?= $totalPresqueEntretien?></i>                        
                    </div>
                </div>
            </form>
        </div>
        <div class="container-R-1">
            <form action="page.php" method="POST">
                <p class="gest_veh-1">+ Presque expirer</p>
                <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-responsables">
                        <span>Assurance</span><br>
                        <i class="fa fa-shield-alt"> <?= $totalExpirAssurance?></i>
                    </div>
                    <div class="btn btn-responsables">
                        <span>Entretien</span><br>
                        <i class="fa fa-tools"> <?= $totalExpirEntretien?></i>                        
                    </div>
                </div>
            </form>
        </div>
    </div><br>
    <!-- Table des Entretiens -->
        <h3 style="font-weight: bold;">Entretiens à venir (moins d'une semaine)</h3>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-info">
                <tr>
                    <th>Matricule</th>
                    <th>Type Entretien</th>
                    <th>Détails</th>
                    <th>Date Rappel</th>
                    <th>Coût (CFA)</th>
                    <th>État</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($entretiens_semaine && $entretiens_semaine->rowCount() > 0) { ?>
                    <?php foreach ($entretiens_semaine as $entretien) { ?>
                        <tr>
                            <td><?= htmlspecialchars($entretien['matricule']) ?></td>
                            <td><?= htmlspecialchars($entretien['type_entretien']) ?></td>
                            <td><?= htmlspecialchars($entretien['detaille']) ?></td>
                            <td><?= htmlspecialchars($entretien['date_rappel']) ?></td>
                            <td><?= htmlspecialchars($entretien['cout']) ?></td>
                            <td><?= htmlspecialchars($entretien['etat']) ?></td>
                            <td>
                                <!-- Bouton pour modifier l'entretien -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifEntretien" 
                                    data-id_entretien="<?= $entretien['ID_entretien']; ?>" 
                                    data-matricule="<?= htmlspecialchars($entretien['matricule']); ?>" 
                                    data-type_entretien="<?= htmlspecialchars($entretien['type_entretien']); ?>" 
                                    data-detaille="<?= htmlspecialchars($entretien['detaille']); ?>" 
                                    data-date_rappel="<?= htmlspecialchars($entretien['date_rappel']); ?>" 
                                    data-cout="<?= htmlspecialchars($entretien['cout']); ?>"
                                    data-etat="<?= htmlspecialchars($entretien['etat']); ?>">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                                <!-- Bouton pour supprimer l'entretien -->
                                <a href="delete_entretien.php?id_entretien=<?= $entretien['ID_entretien'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet entretien ?');">
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="8" class="text-center">Aucun entretien trouvé pour les critères sélectionnés.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Table des Assurances -->
        <h3 style="font-weight: bold;">Assurances proches de l'expiration (moins d'une semaine)</h3>
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-info">
                    <tr>
                        <th>Matricule</th>
                        <th>Fournisseur</th>
                        <th>Date Début</th>
                        <th>Date Expiration</th>
                        <th>Prime (CFA)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($assurances_semaine && $assurances_semaine->rowCount() > 0) { ?>
                    <?php foreach ($assurances_semaine as $entretien) { ?>
                            <tr>
                                <td><?= htmlspecialchars($assurance['matricule']) ?></td>
                                <td><?= htmlspecialchars($assurance['fournisseur']) ?></td>
                                <td><?= htmlspecialchars($assurance['date_debut']) ?></td>
                                <td><?= htmlspecialchars($assurance['date_expiration']) ?></td>
                                <td><?= htmlspecialchars($assurance['prime']) ?></td>
                                <td>
                                    <!-- Bouton pour modifier l'assurance -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifAssurance" 
                                        data-id_assurance="<?= $assurance['ID_assurance']; ?>" 
                                        data-matricule="<?= htmlspecialchars($assurance['matricule']); ?>" 
                                        data-fournisseur="<?= htmlspecialchars($assurance['fournisseur']); ?>" 
                                        data-date_debut="<?= htmlspecialchars($assurance['date_debut']); ?>" 
                                        data-date_expiration="<?= htmlspecialchars($assurance['date_expiration']); ?>" 
                                        data-prime="<?= htmlspecialchars($assurance['prime']); ?>">
                                        <i class="fas fa-edit"></i> Modifier
                                    </button>
                                    <!-- Bouton pour supprimer l'assurance -->
                                    <a href="delete_assurance.php?id_assurance=<?= $assurance['ID_assurance'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette assurance ?');">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="7" class="text-center">Aucune assurance trouvée pour les critères sélectionnés.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

    <!-- Modals pour la modification (À implémenter) -->
    <!-- Exemple de Modal pour modifier un entretien -->
    <div class="modal fade" id="modifEntretien" tabindex="-1" role="dialog" aria-labelledby="modifEntretienLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Contenu du modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modifEntretienLabel">Modifier l'Entretien</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="update_entretien.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="ID_entretien" id="ID_entretien">
                        <div class="form-group">
                            <label for="matricule">Matricule</label>
                            <input type="text" class="form-control" name="matricule" id="matricule" required>
                        </div>
                        <div class="form-group">
                            <label for="type_entretien">Type d'Entretien</label>
                            <input type="text" class="form-control" name="type_entretien" id="type_entretien" required>
                        </div>
                        <div class="form-group">
                            <label for="detaille">Détails</label>
                            <input type="text" class="form-control" name="detaille" id="detaille" required>
                        </div>
                        <div class="form-group">
                            <label for="date_rappel">Date de Rappel</label>
                            <input type="date" class="form-control" name="date_rappel" id="date_rappel" required>
                        </div>
                        <div class="form-group">
                            <label for="cout">Coût (€)</label>
                            <input type="number" class="form-control" name="cout" id="cout" required>
                        </div>
                        <div class="form-group">
                            <label for="etat">État</label>
                            <input type="text" class="form-control" name="etat" id="etat" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Exemple de Modal pour modifier une assurance -->
    <div class="modal fade" id="modifAssurance" tabindex="-1" role="dialog" aria-labelledby="modifAssuranceLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Contenu du modal -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modifAssuranceLabel">Modifier l'Assurance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="update_assurance.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="ID_assurance" id="ID_assurance">
                        <div class="form-group">
                            <label for="matricule_assurance">Matricule</label>
                            <input type="text" class="form-control" name="matricule" id="matricule_assurance" required>
                        </div>
                        <div class="form-group">
                            <label for="fournisseur">Fournisseur</label>
                            <input type="text" class="form-control" name="fournisseur" id="fournisseur" required>
                        </div>
                        <div class="form-group">
                            <label for="date_debut">Date de Début</label>
                            <input type="date" class="form-control" name="date_debut" id="date_debut" required>
                        </div>
                        <div class="form-group">
                            <label for="date_expiration">Date d'Expiration</label>
                            <input type="date" class="form-control" name="date_expiration" id="date_expiration" required>
                        </div>
                        <div class="form-group">
                            <label for="prime">Prime (€)</label>
                            <input type="number" class="form-control" name="prime" id="prime" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Inclusion des scripts JS de Bootstrap et jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Script pour remplir les modals avec les données du bouton cliqué -->
    <script>
        // Script pour le modal de modification des entretiens
        $('#modifEntretien').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
            var modal = $(this);
            
            // Extraire les données des attributs data-*
            var id_entretien = button.data('id_entretien');
            var matricule = button.data('matricule');
            var type_entretien = button.data('type_entretien');
            var detaille = button.data('detaille');
            var date_rappel = button.data('date_rappel');
            var cout = button.data('cout');
            var etat = button.data('etat');
            
            // Remplir les champs du modal
            modal.find('#ID_entretien').val(id_entretien);
            modal.find('#matricule').val(matricule);
            modal.find('#type_entretien').val(type_entretien);
            modal.find('#detaille').val(detaille);
            modal.find('#date_rappel').val(date_rappel);
            modal.find('#cout').val(cout);
            modal.find('#etat').val(etat);
        });

        // Script pour le modal de modification des assurances
        $('#modifAssurance').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
            var modal = $(this);
            
            // Extraire les données des attributs data-*
            var id_assurance = button.data('id_assurance');
            var matricule = button.data('matricule');
            var fournisseur = button.data('fournisseur');
            var date_debut = button.data('date_debut');
            var date_expiration = button.data('date_expiration');
            var prime = button.data('prime');
            
            // Remplir les champs du modal
            modal.find('#ID_assurance').val(id_assurance);
            modal.find('#matricule_assurance').val(matricule);
            modal.find('#fournisseur').val(fournisseur);
            modal.find('#date_debut').val(date_debut);
            modal.find('#date_expiration').val(date_expiration);
            modal.find('#prime').val(prime);
        });
    </script>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-responsables').on('click', function() {
            // Retirer la classe active de tous les boutons
            $('.btn-responsables').removeClass('btn-active');
            // Ajouter la classe active au bouton cliqué
            $(this).addClass('btn-active');
        });
    });
</script>

</body>
</html>