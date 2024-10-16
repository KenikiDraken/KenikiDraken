<?php
require_once("operation_data.php");
require_once('pagination.php');

// Récupérer le nombre total de missions pour la pagination
$totalOperations = $db->query("SELECT COUNT(*) FROM entretien")->fetchColumn();
$totalPages = ceil($totalOperations / $PerPage);
// Récupération des vehicules disponibles
try {
    $vehiculesStmt = $db->query("SELECT matricule FROM VEHICULES");
    $vehicules = $vehiculesStmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIG-parc</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="2style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container">
    <div class="container-2" style="color: white;">
        <form action="page.php" method="POST">
            <div class="form-group">
                <!-- Retour au Menu d'accueil -->
                <button class="go-home-btn" type="submit" name="home">
                    <i class="glyphicon glyphicon-arrow-left"></i>
                </button>
                <!-- Page du Jour -->
                <p class="gest_veh">Gestions des operations et d'entretiens</p>
            </div>
        </form>
    </div>
    <div class="form-group">
        <div class="container-R-1">
            <form action="page.php" method="POST">
                <p class="gest_veh-1">+ Gerer</p>
                <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-responsables" type="submit" name="operations">
                        <i class="fa fa-wrench"></i><br>
                        <span>Gerer les entretiens</span>
                    </button>
                    <button class="btn btn-responsables" type="submit" name="assurances">
                        <i class="fa fa-shield-alt"></i><br>
                        <span>Gerer les Assurances</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="container-R-2">
            <div class="form-group">
                <p class="gest_veh-1">Gestion des entretiens</p>
            </div>
            <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-respon-1" type="button" data-toggle="modal" data-target="#ajoutEntretien">
                        <i class="fa fa-tools">+</i><br>
                        <span>Nouveau Entretien</span>
                    </button>

                <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon">
                        <span>Entretien Total</span><br>
                        <i class="fa fa-cogs"> <?=$totalEntretien?></i>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    <div class="ligne-separation"></div>
    <div class="container-1">
        <form method="POST" action="">
            <div class="form-group">
                <i class="glyphicon glyphicon-tasks"></i>  
            </div>
            <div class="form-group">
                <!-- Matricule Search -->
                <input type="text" name="matricule" placeholder="Rechercher par matricule vehicule" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                 <!-- Carburant search -->
                <select name="etat" class="form-control" style="width: 25%;">
                    <option value="" disabled selected> Recherche par Etat</option>
                    <option value="Prévu">Prévu</option>
                    <option value="Terminé">Terminé</option>
                    <option value="Annulé">Annulé</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- fonction Search -->
                <input type="text" name="fonction" placeholder="Rechercher par fonction" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div><br>
    <!-- Table d'affichage des entretiens -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info">
                <th>Matricule</th>
                <th>Type d'entretien</th>
                <th>Détails</th>
                <th>Date de rappel</th>
                <th>Coût</th>
                <th>État</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $entretien) { ?>
                <tr>
                    <td><?= htmlspecialchars($entretien->matricule) ?></td>
                    <td><?= htmlspecialchars($entretien->type_entretien) ?></td>
                    <td><?= htmlspecialchars($entretien->detaille) ?></td>
                    <td><?= htmlspecialchars($entretien->date_rappel) ?></td>
                    <td><?= htmlspecialchars($entretien->cout) ?> CFA</td>
                    <td><?= htmlspecialchars($entretien->etat) ?></td>
                    <td>
                        <!-- Bouton pour modifier un entretien -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modifEntretien" 
                            data-id="<?= $entretien->ID_entretien; ?>" 
                            data-matricule="<?= htmlspecialchars($entretien->matricule); ?>" 
                            data-type_entretien="<?= htmlspecialchars($entretien->type_entretien); ?>" 
                            data-detaille="<?= htmlspecialchars($entretien->detaille); ?>" 
                            data-date_rappel="<?= htmlspecialchars($entretien->date_rappel); ?>"
                            data-cout="<?= htmlspecialchars($entretien->cout); ?>"
                            data-etat="<?= htmlspecialchars($entretien->etat); ?>">
                            Modifier
                        </button>
                        <!-- Bouton pour supprimer un entretien -->
                        <a href="delete.php?id_entretien=<?= $entretien->ID_entretien ?>">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucun entretien n'est trouvé -->
                <tr>
                    <td colspan="7">Aucun entretien trouvé pour les critères sélectionnés.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
        <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- Bouton Précédent -->
            <?php if ($page > 1) { ?>
                <li><a href="?page=<?= $page - 1 ?>" aria-label="Précédent"><span aria-hidden="true">&laquo;</span></a></li>
            <?php } else { ?>
                <li class="disabled"><span aria-hidden="true">&laquo;</span></span></li>
            <?php } ?>

            <!-- Afficher les numéros de page -->
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li <?= ($i == $page) ? 'class="active"' : '' ?>>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>

            <!-- Bouton Suivant -->
            <?php if ($page < $totalPages) { ?>
                <li><a href="?page=<?= $page + 1 ?>" aria-label="Suivant"><span aria-hidden="true">&raquo;</span></a></li>
            <?php } else { ?>
                <li class="disabled"><span aria-hidden="true">&raquo;</span></li>
            <?php } ?>
        </ul>
    </nav>           
</div>

<!-- Modal d'ajout d'entretien -->
<div class="modal fade" id="ajoutEntretien" tabindex="-1" aria-labelledby="ajoutEntretienLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutEntretienLabel">Ajouter un nouvel entretien</h4>
            </div>
            <div class="modal-body">
                <form action="oper_operation.php" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Fournisseur :</label>
                                <select name="matricule" class="form-control" required>
                                    <option value="" disabled selected>Choisissez un vehicule</option>
                                    <?php foreach ($vehicules as $vehicule): ?>
                                        <option value="<?php echo htmlspecialchars($vehicule->matricule); ?>">
                                            <?php echo htmlspecialchars($vehicule->matricule); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type_entretien" class="form-label">Type d'entretien :</label>
                                <input type="text" class="form-control" name="type_entretien" placeholder="Type d'entretien" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 mb-3">
                                <label for="detaille" class="form-label">Détails :</label>
                                <input type="text" class="form-control" name="detaille" placeholder="Détails de l'entretien" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="etat" class="form-label">État :</label>
                                <select class="form-control" name="etat" required>
                                    <option value="Prévu">Prévu</option>
                                    <option value="Terminé">Terminé</option>
                                    <option value="Annulé">Annulé</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="date_rappel" class="form-label">Date de rappel :</label>
                                <input type="date" class="form-control" name="date_rappel" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cout" class="form-label">Coût :</label>
                                <input type="number" class="form-control" name="cout" placeholder="Coût" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" name="enreg" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modifEntretien" tabindex="-1" aria-labelledby="modifEntretienLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifEntretienLabel">Modification des informations de l'entretien</h4>
            </div>
            <div class="modal-body">
                <form action="oper_operation.php" method="POST">
                    <input type="hidden" name="id_entretien" id="entretienId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule :</label>
                                <input type="text" class="form-control" name="matricule" id="entretienMatricule" placeholder="Entrez le matricule" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type_entretien" class="form-label">Type d'entretien :</label>
                                <input type="text" class="form-control" name="type_entretien" id="entretienType" placeholder="Entrez le type d'entretien" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="detaille" class="form-label">Détail :</label>
                                <input type="text" class="form-control" name="detaille" id="entretienDetaille" placeholder="Entrez les détails" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_rappel" class="form-label">Date de rappel :</label>
                                <input type="date" class="form-control" name="date_rappel" id="entretienDateRappel" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="cout" class="form-label">Coût :</label>
                                <input type="number" class="form-control" name="cout" id="entretienCout" placeholder="Entrez le coût" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="etat" class="form-label">État :</label>
                                <input type="text" class="form-control" name="etat" id="entretienEtat" placeholder="Entrez l'état" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Fermer</button>
                        <button type="submit" name="modif" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#modifEntretien').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
        var id = button.data('id'); // Extraire l'ID depuis les attributs data-*
        var matricule = button.data('matricule');
        var type_entretien = button.data('type_entretien');
        var detaille = button.data('detaille');
        var date_rappel = button.data('date_rappel');
        var cout = button.data('cout');
        var etat = button.data('etat');

        // Mettre à jour le contenu du modal.
        var modal = $(this);
        modal.find('#entretienId').val(id);
        modal.find('#entretienMatricule').val(matricule);
        modal.find('#entretienType').val(type_entretien);
        modal.find('#entretienDetaille').val(detaille);
        modal.find('#entretienDateRappel').val(date_rappel);
        modal.find('#entretienCout').val(cout);
        modal.find('#entretienEtat').val(etat);
    });
</script>

</body>
</html>