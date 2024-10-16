<?php
include('mission_data.php');
require_once('pagination.php');

try {
    $nomChauffeursStmt = $db->query("SELECT  nom FROM chauffeur");
    $chauffeurs = $nomChauffeursStmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}
try {
    $voituresStmt = $db->query("SELECT  matricule FROM vehicules");
    $voitures = $voituresStmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Erreur: " . $e->getMessage());
}

$totalMissions = $db->query("SELECT COUNT(*) FROM mission")->fetchColumn();
$totalPages = ceil($totalMissions / $PerPage);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIG-parc</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="3style.css">
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
                <p class="gest_veh">Gestions des Missions</p>
            </div>
        </form>
        <div class ="form-group">
             <!-- Bouton pour ouvrir le modal -->
            <button class="btn btn-responsables" type="button" data-toggle="modal" data-target="#ajoutMission">
                <i class="fa fa-bullseye">+</i><br>
                <span>Nouvelle Mission</span>
            </button>
             <!-- Bouton pour ouvrir le modal -->
            <div class="btn btn-respon">
                <span>Missions Total</span><br>
                <i class="fa fa-tasks"> <?=$totalMission?></i>
            </div>
            <!-- Mot 'dont' -->
             <style>
                .dont-text{
                    font-weight: bold; /* Met le texte en gras */
                    font-size: 20px; /* Ajuste la taille de police */
                    align-self: center; /* Centre verticalement dans le conteneur */
                }
             </style>
            <div class="dont-text">dont</div>

             <!-- Bouton pour ouvrir le modal -->
             <div class="btn btn-respon">
                <span> Mission en Cours</span><br>
                <i class="fa fa-clipboard-list"> <?= $totalCours?></i>
            </div>
             <!-- Bouton pour ouvrir le modal -->
            <div class="btn btn-respon">
                <span>Missions Terminées</span><br>
                <i class="fa fa-flag-checkered"> <?=$totalTerminer?></i>
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
                <!--  Search for lieu mission -->
                <input type="text" name="lieu_mission" placeholder="Rechercher par lieu de la mission" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                 <!--  Search for Statut -->
                 <input type="text" name="statut" placeholder="Rechercher par statut" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Annee  Search -->
                <input type="date" name="date_debut" placeholder="Rechercher par annee de deroulement" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
            </div>
        </form>
    </div><br>
    <!-- Table d'affichage des Missions -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info">
                <th>ID Mission</th>
                <th>Nom Chauffeur</th>
                <th>Matricule</th>
                <th>Date Début</th>
                <th>Date Fin</th>
                <th>Coût Carburant</th>
                <th>Lieu Mission</th>
                <th>Statut</th>
                <th>Menus</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $mission) { ?>
                    <tr>
                        <td><?= htmlspecialchars($mission->ID_mission) ?></td>
                        <td><?= htmlspecialchars($mission->nom_chauffeur) ?></td>
                        <td><?= htmlspecialchars($mission->matricule) ?></td>
                        <td><?= htmlspecialchars($mission->date_debut) ?></td>
                        <td><?= htmlspecialchars($mission->date_fin) ?></td>
                        <td><?= htmlspecialchars($mission->cout_carburant) ?> €</td>
                        <td><?= htmlspecialchars($mission->lieu_mission) ?></td>
                        <td><?= htmlspecialchars($mission->statut) ?></td>
                        <td>
                            <!-- Bouton pour modifier une mission -->
                            <button class="btn btn-warning" data-toggle="modal" data-target="#modifMission" 
                                data-id_mission="<?= $mission->ID_mission; ?>" 
                                data-nom_chauffeur="<?= htmlspecialchars($mission->nom_chauffeur); ?>" 
                                data-matricule="<?= htmlspecialchars($mission->matricule); ?>" 
                                data-date_debut="<?= htmlspecialchars($mission->date_debut); ?>" 
                                data-date_fin="<?= htmlspecialchars($mission->date_fin); ?>" 
                                data-cout_carburant="<?= htmlspecialchars($mission->cout_carburant); ?>"
                                data-lieu_mission="<?= htmlspecialchars($mission->lieu_mission); ?>"
                                data-statut="<?= htmlspecialchars($mission->statut); ?>">
                                Modifier
                            </button>
                            <!-- Bouton pour supprimer une mission -->
                            <a href="delete.php?id_mission=<?= $mission->ID_mission ?>">
                                <button class="btn btn-danger">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucune mission n'est trouvée -->
                <tr>
                    <td colspan="9">Aucune mission trouvée pour les critères sélectionnés.</td>
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
<!-- Modal pour ajouter une nouvelle mission -->
<div class="modal fade" id="ajoutMission" tabindex="-1" aria-labelledby="ajoutMissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutMissionLabel">Ajouter une nouvelle mission</h4>
            </div>
            <div class="modal-body">
                <form action="oper_mission.php" method="POST">
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="nom_chauffeur" class="form-label">Nom du Chauffeur :</label>
                            <select name="nom_chauffeur" class="form-control" required>
                                <option value="" disabled selected>Choisissez un Chauffeur</option>
                                <?php foreach ($chauffeurs as $chauffeur): ?>
                                    <option value="<?php echo htmlspecialchars($chauffeur->nom); ?>">
                                        <?php echo htmlspecialchars($chauffeur->nom); ?>
                                    </option>
                                    <?php endforeach; ?>
                            </select>
                        </div>               
                        <div class="col-md-6 mb-3">
                            <label for="matricule" class="form-label">Matricule de la vehicule :</label>
                            <select name="matricule" class="form-control" required>
                                <option value="" disabled selected>Choisissez le matricule</option>
                                <?php foreach ($voitures as $voiture): ?>
                                    <option value="<?php echo htmlspecialchars($voiture->matricule); ?>">
                                        <?php echo htmlspecialchars($voiture->matricule); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="date_debut" class="form-label">Date de début :</label>
                            <input type="date" class="form-control" name="date_debut" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_fin" class="form-label">Date de fin :</label>
                            <input type="date" class="form-control" name="date_fin" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="cout_carburant" class="form-label">Coût du carburant :</label>
                            <input type="number" class="form-control" name="cout_carburant" placeholder="Coût en FCFA" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lieu_mission" class="form-label">Lieu de la mission :</label>
                            <input type="text" class="form-control" name="lieu_mission" placeholder="Lieu de la mission" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut :</label>
                            <input type="text" class="form-control" name="statut" placeholder="Lieu de la mission" required>
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
<!-- Modal pour modifier une mission -->
<div class="modal fade" id="modifMission" tabindex="-1" aria-labelledby="modifMissionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifMissionLabel">Modification des informations de la mission</h4>
            </div>
            <div class="modal-body">
                <form action="oper_mission.php" method="POST">
                    <input type="hidden" name="id_mission" id="missionId" value="">                   
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                                <label for="nom_chauffeur" class="form-label">Nom du Chauffeur :</label>
                                <select name="nom_chauffeur" class="form-control" required>
                                    <option value="" disabled selected>Choisissez un Chauffeur</option>
                                    <?php foreach ($chauffeurs as $chauffeur): ?>
                                        <option value="<?php echo htmlspecialchars($chauffeur->nom); ?>">
                                            <?php echo htmlspecialchars($chauffeur->nom); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>               
                        <div class="col-md-6 mb-3">
                            <label for="matricule" class="form-label">Matricule de la vehicule :</label>
                            <select name="matricule" class="form-control" required>
                                <option value="" disabled selected>Choisissez le matricule</option>
                                    <?php foreach ($voitures as $voiture): ?>
                                        <option value="<?php echo htmlspecialchars($voiture->matricule); ?>">
                                            <?php echo htmlspecialchars($voiture->matricule); ?>
                                        </option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="date_debut" class="form-label">Date de début :</label>
                            <input type="date" class="form-control" name="date_debut" id="missionDateDebut" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_fin" class="form-label">Date de fin :</label>
                            <input type="date" class="form-control" name="date_fin" id="missionDateFin" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="cout_carburant" class="form-label">Coût du carburant :</label>
                            <input type="number" class="form-control" name="cout_carburant" id="missionCoutCarburant" placeholder="Coût en FCFA" required>
                        </div>
                    
                        <div class="col-md-6 mb-3">
                            <label for="lieu_mission" class="form-label">Lieu de la mission :</label>
                            <input type="text" class="form-control" name="lieu_mission" id="missionLieu" placeholder="Lieu de la mission" required>                  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="statut" class="form-label">Statut de la mission :</label>
                            <input type="text" class="form-control" name="statut" id="missionStatut" placeholder="Coût en FCFA" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" name="modif_mission" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$('#modifMission').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id_mission = button.data('id_mission');
    var nom_chauffeur = button.data('nom_chauffeur');
    var matricule = button.data('matricule');
    var date_debut = button.data('date_debut');
    var date_fin = button.data('date_fin');
    var cout_carburant = button.data('cout_carburant');
    var lieu_mission = button.data('lieu_mission');
    var statut = button.data('statut');

    // AJAX pour stocker l'ID de mission dans la session
    $.ajax({
        url: 'mission_data.php',
        method: 'POST',
        data: { id_mission: id_mission },
        success: function(response) {
            console.log('ID de mission stocké dans la session.');
        }
    });

    // Mettre à jour les champs du modal avec les données de la mission
    var modal = $(this);
    modal.find('#missionId').val(id_mission);
    modal.find('#missionNomChauffeur').val(nom_chauffeur);
    modal.find('#missionMatricule').val(matricule);
    modal.find('#missionDateDebut').val(date_debut);
    modal.find('#missionDateFin').val(date_fin);
    modal.find('#missionCoutCarburant').val(cout_carburant);
    modal.find('#missionLieu').val(lieu_mission);
    modal.find('#missionStatut').val(statut);
});

</script>

</body>
</html>