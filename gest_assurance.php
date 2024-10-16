<?php
require_once("assurance_data.php");
require_once('pagination.php');

$totalAssurances = $db->query("SELECT COUNT(*) FROM assurance")->fetchColumn();
$totalPages = ceil($totalAssurances / $PerPage);
if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
}
try {
    $fournisseursStmt = $db->query("SELECT  nom_fournisseur FROM fournisseur");
    $fournisseurs = $fournisseursStmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
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
        <div class="ligne-separation"></div>
        <div class="container-R-2">
            <div class="form-group">
                <p class="gest_veh-1">Gestion des Assurances</p>
            </div>
            <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-respon-1" type="button" data-toggle="modal" data-target="#ajoutAssurance">
                        <i class="fa fa-list-alt"> +</i><br>
                        <span>Nouvelle Assurance</span>
                    </button>

                <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon">
                        <span>Assurance Total</span><br>
                        <i class="fa fa-book"> <?=$totalAssurance?></i>
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
                <th>ID Assurance</th>
                <th>Matricule</th>
                <th>Fournisseur</th>
                <th>Date de début</th>
                <th>Date d'expiration</th>
                <th>Prime</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $assurance) { ?>
                <tr>
                    <td><?= htmlspecialchars($assurance->ID_assurance) ?></td>
                    <td><?= htmlspecialchars($assurance->matricule) ?></td>
                    <td><?= htmlspecialchars($assurance->fournisseur) ?></td>
                    <td><?= htmlspecialchars($assurance->date_debut) ?></td>
                    <td><?= htmlspecialchars($assurance->date_expiration) ?></td>
                    <td><?= htmlspecialchars($assurance->prime) ?> CFA</td>
                    <td>
                        <!-- Bouton pour modifier une assurance -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modifAssurance" 
                            data-id="<?= $assurance->ID_assurance; ?>" 
                            data-matricule="<?= htmlspecialchars($assurance->matricule); ?>" 
                            data-fournisseur="<?= htmlspecialchars($assurance->fournisseur); ?>" 
                            data-date_debut="<?= htmlspecialchars($assurance->date_debut); ?>" 
                            data-date_expiration="<?= htmlspecialchars($assurance->date_expiration); ?>"
                            data-prime="<?= htmlspecialchars($assurance->prime); ?>">
                            Modifier
                        </button>
                        <!-- Bouton pour supprimer une assurance -->
                        <a href="delete.php?id_assurance=<?= $assurance->ID_assurance ?>">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucune assurance n'est trouvée -->
                <tr>
                    <td colspan="6">Aucune assurance trouvée pour les critères sélectionnés.</td>
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

<!-- Modal d'ajout d'assurance -->
<div class="modal fade" id="ajoutAssurance" tabindex="-1" aria-labelledby="ajoutAssuranceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutAssuranceLabel">Ajouter une nouvelle assurance</h4>
            </div>
            <div class="modal-body">
                <form action="oper_assurance.php" method="POST">
                    <div class="row">
                        <!-- Matricule du véhicule -->
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule :</label>
                                <input type="text" class="form-control" name="matricule" placeholder="Matricule" maxlength="10" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fournisseur" class="form-label">Nom du fournisseur :</label>
                                <select name="nom_chauffeur" class="form-control" required>
                                    <option value="" disabled selected>Choisissez un fournisseur</option>
                                    <?php foreach ($fournisseurs as $fournisseur): ?>
                                        <option value="<?php echo htmlspecialchars($fournisseur->nom_fournisseur); ?>">
                                            <?php echo htmlspecialchars($fournisseur->nom_fournisseur); ?>
                                        </option>
                                        <?php endforeach; ?>
                                </select>
                            </div>   
                        </div>
                        <!-- Date de début de l'assurance -->
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début :</label>
                                <input type="date" class="form-control" name="date_debut" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_expiration" class="form-label">Date d'expiration :</label>
                                <input type="date" class="form-control" name="date_expiration" required>
                            </div>
                        </div>
                        <!-- Prime d'assurance -->
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="prime" class="form-label">Prime d'assurance :</label>
                                <input type="number" class="form-control" name="prime" placeholder="Montant de la prime" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" name="enregistrer_assurance" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modifAssurance" tabindex="-1" aria-labelledby="modifAssuranceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifAssuranceLabel">Modification des informations de l'assurance</h4>
            </div>
            <div class="modal-body">
                <form action="oper_assurance.php" method="POST">
                    <input type="hidden" name="id_assurance" id="assuranceId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule :</label>
                                <input type="text" class="form-control" name="matricule" id="assuranceMatricule" placeholder="Entrez le matricule" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fournisseur" class="form-label">Nom du fournisseur :</label>
                                <select name="nom_chauffeur" id="assuranceFournisseur" class="form-control" required>
                                    <option value="" disabled selected>Choisissez un fournisseur</option>
                                    <?php foreach ($fournisseurs as $fournisseur): ?>
                                        <option value="<?php echo htmlspecialchars($fournisseur->nom_fournisseur); ?>">
                                            <?php echo htmlspecialchars($fournisseur->nom_fournisseur); ?>
                                        </option>
                                        <?php endforeach; ?>
                                </select>
                            </div>   
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début :</label>
                                <input type="date" class="form-control" name="date_debut" id="assuranceDateDebut" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_expiration" class="form-label">Date d'expiration :</label>
                                <input type="date" class="form-control" name="date_expiration" id="assuranceDateExpiration" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="prime" class="form-label">Prime :</label>
                                <input type="number" class="form-control" name="prime" id="assurancePrime" placeholder="Entrez le montant de la prime" required>
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
    $('#modifAssurance').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
        var id = button.data('id');
        var matricule = button.data('matricule');
        var fournisseur = button.data('fournisseur');
        var date_debut = button.data('date_debut');
        var date_expiration = button.data('date_expiration');
        var prime = button.data('prime');

        var modal = $(this);
        modal.find('#assuranceId').val(id);
        modal.find('#assuranceMatricule').val(matricule);
        modal.find('#assuranceFournisseur').val(fournisseur);
        modal.find('#assuranceDateDebut').val(date_debut);
        modal.find('#assuranceDateExpiration').val(date_expiration);
        modal.find('#assurancePrime').val(prime);
    });
</script>

</body>
</html>