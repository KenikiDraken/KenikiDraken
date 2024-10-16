<?php
require_once("vehicule_data.php");
require_once('pagination.php');

$totalVehicule = $db->query("SELECT COUNT(*) FROM vehicules")->fetchColumn();
$totalPages = ceil($totalVehicule / $PerPage);

if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
}
// Récupération des fournisseurs disponibles
try {
    $chauffeursStmt = $db->query("SELECT nom, prenom FROM chauffeur");
    $chauffeurs = $chauffeursStmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIG-parc</title>

        <!-- Ajouter Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="1style.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>
<?php
include('navbar.php');
?>
<div class="container">
<div class="container-1">
    <form action="page.php" method="POST">
        <div class="form-group">
            <!-- Retour au Menu d'accueil -->
            <button class="go-home-btn" type="submit" name="home">
                <i class="glyphicon glyphicon-arrow-left"></i>
            </button>
            <!-- Page du Jour -->
            <p class="gest_veh">Gestions des Véhicules</p>
        </div>
    </form>
    <div class="form-group my-custom-group"> <!-- Classe unique -->
        <div class="button-container">
            <!-- Bouton Ajouter à gauche -->
            <div class="level-1" data-toggle="modal" data-target="#ajoutVehicule">
                <p class="haut-1">Ajouter<br></p>
                <p class="haut-2">Véhicule</p>
                <strong class="strong-1"><i class="glyphicon glyphicon-plus"></i></strong>
            </div>
        </div>

        <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
            <div class="level-2">
                <p class="haut-1">Véhicule<br>en</p>
                <p class="haut-2">Ligne</p>
                <strong class="strong-2"><?= $totalVehicules ?></strong>
            </div>

            <!-- Mot 'dont' -->
            <div class="dont-text">dont</div>

            <div class="level-1">
                <p class="haut-1">Véhicule<br>à</p>
                <p class="haut-2">Essence</p>
                <strong class="strong-1"><?= $totalEssence ?></strong>
            </div>

            <div class="level-2">
                <p class="haut-1">Véhicule<br>à</p>
                <p class="haut-2">Gasoil</p>
                <strong class="strong-2"><?= $totalGasoil ?></strong>
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
                <button type="submit" class="btn btn-primary" style="width: 25%;"><i class="fa fa-search"></i> Rechercher</button>
            </div>
            <div class="form-group">
                <!--  Search for matricule -->
                <input type="text" name="matricule" placeholder="Rechercher par matricule" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Carburant search -->
                <select name="carburant" class="form-control" style="width: 25%;">
                    <option value="">--- Type de Carburant ---</option>
                    <option value="essence">Essence</option>
                    <option value="gassoil">Gasoil</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Marque Search -->
                <input type="text" name="marque" placeholder="Rechercher par marque" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
            </div>

            <div class="form-group">
                <!-- modele search -->
                <input type="text" name="modele" placeholder="Rechercher par modèle" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- categorie search -->
                <select name="categorie" class="form-control" style="width: 25%;">
                    <option value="">--- Catégorie véhicule ---</option>
                    <option value="vehicule">Véhicule</option>
                    <option value="camion">Camion</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- departement search -->
                <input type="text" name="departement" placeholder="Rechercher par département" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
            </div>    
        </form>
    </div><br>
    
 <!-- Table d'affichage des vehicules -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info">
                <th>Matricule</th>
                <th>Marque</th>
                <th>Catégorie</th>
                <th>Modèle</th>
                <th>Mise en Circulation</th>
                <th>Carburant</th>
                <th>Département</th>
                <th>Etat</th>
                <th>nom Chauffeur</th>
                <th>Menus</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
            <?php foreach ($searchResults as $vehicule) { ?>
            <tr>
                <td><?= htmlspecialchars($vehicule->matricule) ?></td>
                <td><?= htmlspecialchars($vehicule->marque) ?></td>
                <td><?= htmlspecialchars($vehicule->modele) ?></td>
                <td><?= htmlspecialchars($vehicule->categorie) ?></td>
                <td><?= htmlspecialchars($vehicule->mise_circulation) ?></td>
                <td><?= htmlspecialchars($vehicule->carburant) ?></td>
                <td><?= htmlspecialchars($vehicule->departement) ?></td>
                <td><?= htmlspecialchars($vehicule->etat) ?></td>
                <td><?= htmlspecialchars($vehicule->nom_chauffeur) ?></td>
                <td>
                    <!-- Bouton pour modifier un véhicule -->
                    <button class="btn btn-warning" data-toggle="modal" data-target="#modifVehicule" 
                        data-id_vehicule="<?= $vehicule->ID_vehicule; ?>" 
                        data-matricule="<?= htmlspecialchars($vehicule->matricule); ?>" 
                        data-marque="<?= htmlspecialchars($vehicule->marque); ?>" 
                        data-modele="<?= htmlspecialchars($vehicule->modele); ?>" 
                        data-categorie="<?= htmlspecialchars($vehicule->categorie); ?>" 
                        data-mise_circulation="<?= htmlspecialchars($vehicule->mise_circulation); ?>" 
                        data-carburant="<?= htmlspecialchars($vehicule->carburant); ?>" 
                        data-departement="<?= htmlspecialchars($vehicule->departement); ?>" 
                        data-etat="<?= htmlspecialchars($vehicule->etat); ?>"
                        data-nom_chauffeur="<?= htmlspecialchars($vehicule->nom_chauffeur); ?>">
                        Modifier
                    </button>
                    <!-- Bouton pour supprimer un véhicule -->
                    <a href="delete.php?id_vehicule=<?= $vehicule->ID_vehicule ?>">
                        <button class="btn btn-danger">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </a>
                </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <!-- Si aucun véhicule n'est trouvé -->
            <tr>
                <td colspan="9">Aucun véhicule trouvé pour les critères sélectionnés.</td>
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

<!-- Modal pour Ajouter nouveau Véhicule -->
<div class="modal fade" id="ajoutVehicule" tabindex="-1" aria-labelledby="ajoutVehiculeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutVehiculeLabel">Enregistrement d'un Véhicule</h4>
            </div>
            <div class="modal-body">
                <form action="oper_vehicule.php" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule :</label>
                                <input type="text" class="form-control" name="matricule" placeholder="Entrer le matricule" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marque" class="form-label">Marque :</label>
                                <input type="text" class="form-control" name="marque" placeholder="Marque du véhicule" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="categorie" class="form-label">Catégorie :</label>
                                <select class="form-control" name="categorie" required>
                                    <option value="" disabled selected>--- Catégorie du véhicule ---</option>
                                    <option value="vehicule">Véhicule</option>
                                    <option value="camion">Camion</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label">Modèle :</label>
                                <input type="text" class="form-control" name="modele" placeholder="Saisir le modèle" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="mise_circulation" class="form-label">Date de mise en circulation :</label>
                                <input type="date" class="form-control" name="mise_circulation" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="carburant" class="form-label">Type de carburant :</label>
                                <select class="form-control" name="carburant" required>
                                    <option value="" disabled selected>--- Type de Carburant ---</option>
                                    <option value="Essence">Essence</option>
                                    <option value="Gasoil">Gasoil</option>
                                    <option value="Électrique">Électrique</option>
                                    <option value="Hybride">Hybride</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="departement" class="form-label">Département :</label>
                                <input type="text" class="form-control" name="departement" placeholder="Département" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="etat" class="form-label">État du véhicule :</label>
                                <select class="form-control" name="etat" required>
                                    <option value="" disabled selected>--- État du Véhicule ---</option>
                                    <option value="Neuf">Neuf</option>
                                    <option value="Presque Neuf">Presque Neuf</option>
                                    <option value="En bon état">En bon état</option>
                                    <option value="Presque Vieux">Presque Vieux</option>
                                    <option value="Vieux">Vieux</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="ID_chauffeur" class="form-label">Nom du Chauffeur :</label>
                                <select name="nom_chauffeur" class="form-control" required>
                                    <option value="" disabled selected>Choisissez un chauffeur</option>
                                    <?php foreach ($chauffeurs as $chauffeur): ?>
                                        <option value="<?php echo htmlspecialchars($chauffeur->nom); ?>">
                                            <?php echo htmlspecialchars($chauffeur->nom); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
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

<!-- Modal pour Modifier Véhicule -->
<div class="modal fade" id="modifVehicule" tabindex="-1" aria-labelledby="modifVehiculeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifVehiculeLabel">Modification des informations du véhicule</h4>
            </div>
            <div class="modal-body">
                <form action="oper_vehicule.php" method="POST">
                    <input type="hidden" name="id_vehicule" id="vehiculeId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="matricule" class="form-label">Matricule :</label>
                                <input type="text" class="form-control" name="matricule" id="vehiculeMatricule" placeholder="Entrez le matricule" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="marque" class="form-label">Marque :</label>
                                <input type="text" class="form-control" name="marque" id="vehiculeMarque" placeholder="Entrez la marque" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="categorie" class="form-label">Catégorie :</label>
                                <select class="form-control" name="categorie" id="vehiculeCategorie" required>
                                    <option value="" disabled selected>Choisissez une catégorie</option>
                                    <option value="vehicule">Véhicule</option>
                                    <option value="camion">Camion</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label">Modèle :</label>
                                <input type="text" class="form-control" name="modele" id="vehiculeModele" placeholder="Entrez le modèle" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="mise_circulation" class="form-label">Mise en circulation :</label>
                                <input type="date" class="form-control" name="mise_circulation" id="vehiculeMiseCirculation" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="carburant" class="form-label">Carburant :</label>
                                <select class="form-control" name="carburant" required>
                                    <option value="" disabled selected>Choisissez un carburant</option>
                                    <option value="Essence">Essence</option>
                                    <option value="Gasoil">Gasoil</option>
                                    <option value="Électrique">Électrique</option>
                                    <option value="Hybride">Hybride</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="departement" class="form-label">Département :</label>
                                <input type="text" class="form-control" name="departement" id="vehiculeDepartement" placeholder="Entrez le département" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="etat" class="form-label">État du véhicule :</label>
                                <select class="form-control" name="etat" required>
                                    <option value="" disabled selected>--- État du Véhicule ---</option>
                                    <option value="Neuf">Neuf</option>
                                    <option value="Presque Neuf">Presque Neuf</option>
                                    <option value="En bon état">En bon état</option>
                                    <option value="Presque Vieux">Presque Vieux</option>
                                    <option value="Vieux">Vieux</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="ID_chauffeur" class="form-label">Nom du Chauffeur :</label>
                                <select name="nom_chauffeur" class="form-control" required>
                                    <option value="" disabled selected>Choisissez un chauffeur</option>
                                    <?php foreach ($chauffeurs as $chauffeur): ?>
                                        <option value="<?php echo htmlspecialchars($chauffeur->nom); ?>">
                                            <?php echo htmlspecialchars($chauffeur->nom); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
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
    $('#modifVehicule').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché l'ouverture du modal
        var id_vehicule = button.data('id_vehicule'); // Extraire l'id du véhicule
        var matricule = button.data('matricule');
        var marque = button.data('marque');
        var categorie = button.data('categorie');
        var modele = button.data('modele');
        var mise_circulation = button.data('mise_circulation');
        var carburant = button.data('carburant');
        var departement = button.data('departement');
        var etat = button.data('etat');
        var nom_chauffeur = button.data('nom_chauffeur');

        // Mettre à jour le contenu du modal avec les données du véhicule
        var modal = $(this);
        modal.find('input[name="id_vehicule"]').val(id_vehicule); // Mettre à jour l'id du véhicule
        modal.find('input[name="matricule"]').val(matricule);
        modal.find('input[name="marque"]').val(marque);
        modal.find('select[name="categorie"]').val(categorie);
        modal.find('input[name="modele"]').val(modele);
        modal.find('input[name="mise_circulation"]').val(mise_circulation);
        modal.find('select[name="carburant"]').val(carburant);
        modal.find('input[name="departement"]').val(departement);
        modal.find('select[name="etat"]').val(etat);
        modal.find('select[name="nom_chauffeur"]').val(nom_chauffeur); // Mettre à jour le nom du chauffeur
    });
</script>

</body>
</html>