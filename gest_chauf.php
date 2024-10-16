<?php
require_once("chauffeur_data.php");
require_once('pagination.php');

// Récupérer le nombre total de missions pour la pagination
$totalChauffeur = $db->query("SELECT COUNT(*) FROM chauffeur")->fetchColumn();
$totalPages = ceil($totalChauffeur / $PerPage);
if (empty($_SESSION['cmp'])) {
    header("location:first_authent.php");
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
                <p class="gest_veh">Gestions des Chauffeurs</p>
            </div>
        </form>

        <div class="form-group my-custom-group"> <!-- Classe unique -->
            <div class="button-container">
                <!-- Bouton Ajouter à gauche -->
                <button class="level-1" data-toggle="modal" data-target="#ajoutChauffeur">
                    <p class="haut-1">Ajouter<br></p>
                    <p class="haut-2">Chauffeur</p>
                    <strong class="strong-1"><i class="glyphicon glyphicon-plus"></i></strong>
                </button>
            </div>

            <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                <div class="level-2">
                    <p class="haut-1">Total de</p>
                    <p class="haut-2">Chauffeur</p>
                    <strong class="strong-2"><?= $totalChauffeurs ?></strong>
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
                <!--  Search for nom -->
                <input type="text" name="nom" placeholder="Rechercher par nom" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
               <!--  Search for prenom -->
               <input type="text" name="prenom" placeholder="Rechercher par prenom" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Marque Search -->
                <input type="text" name="permis" placeholder="Rechercher par permis" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
            </div>

            <div class="form-group">
                <!-- modele search -->
                <input type="date" name="date-debut" placeholder="Rechercher apr date de debut" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- departement search -->
                <input type="text" name="departement" placeholder="Rechercher par département" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <button type="submit" class="btn btn-primary" style="width: 25%;"><i class="fa fa-search"></i> Rechercher</button>
            </div>    
        </form>
    </div><br>
    
    <!-- Table d'affichage des chauffeurs -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info">
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de debut</th>
                <th>Permis</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Département</th>
                <th>Adresse</th>
                <th>Menus</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $chauffeur) { ?>
                <tr>
                    <td><?= htmlspecialchars($chauffeur->ID_chauffeur) ?></td>
                    <td><?= htmlspecialchars($chauffeur->nom) ?></td>
                    <td><?= htmlspecialchars($chauffeur->prenom) ?></td>
                    <td><?= htmlspecialchars($chauffeur->date_debut) ?></td>
                    <td><?= htmlspecialchars($chauffeur->permis) ?></td>
                    <td><?= htmlspecialchars($chauffeur->telephone) ?></td>
                    <td><?= htmlspecialchars($chauffeur->email) ?></td>
                    <td><?= htmlspecialchars($chauffeur->departement) ?></td>
                    <td>
                        <!-- Bouton pour modifier un chauffeur -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modifChauffeur" 
                            data-id="<?= $chauffeur->ID_chauffeur; ?>" 
                            data-nom="<?= htmlspecialchars($chauffeur->nom); ?>" 
                            data-prenom="<?= htmlspecialchars($chauffeur->prenom); ?>" 
                            data-date_debut="<?= htmlspecialchars($chauffeur->date_debut); ?>" 
                            data-permis="<?= htmlspecialchars($chauffeur->permis); ?>" 
                            data-telephone="<?= htmlspecialchars($chauffeur->telephone); ?>" 
                            data-email="<?= htmlspecialchars($chauffeur->email); ?>" 
                            data-departement="<?= htmlspecialchars($chauffeur->departement); ?>">
                            Modifier
                        </button>
                        <!-- Bouton pour supprimer un chauffeur -->
                        <a href="delete.php?id_chauffeur=<?= $chauffeur->ID_chauffeur ?>">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucun chauffeur n'est trouvé -->
                <tr>
                    <td colspan="9">Aucun chauffeur trouvé pour les critères sélectionnés.</td>
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
<!-- The Modal -->
<div class="modal fade" id="ajoutChauffeur" tabindex="-1" aria-labelledby="ajoutChauffeurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="ajoutChauffeurLabel">Nouveau chauffeur</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <form action="oper_chauffeur.php" method="POST">
              <div class="row">
                <div class="form-group">
                    <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" class="form-control" name="nom" placeholder="Entrez le nom">
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" class="form-control" name="prenom" placeholder="Entrez le prénom">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone :</label>
                    <input type="text" class="form-control" name="telephone" placeholder="Entrez le numéro">
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="departement" class="form-label">Département :</label>
                    <input type="text" class="form-control" name="departement" placeholder="Entrez le département">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 mb-3">
                    <label for="permis" class="form-label">Numéro de permis :</label>
                    <input type="text" class="form-control" name="permis" placeholder="Entrez le code permis ">
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="date_debut" class="form-label">Date de bebut Service :</label>
                    <input type="date" class="form-control" name="date_debut" placeholder="Entrez la date">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 mb-3">
                    <label for="adresse" class="form-label">Adresse :</label>
                    <input type="text" class="form-control" name="adresse" placeholder="Entrez l'adresse">
                    </div>
                    <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" class="form-control" name="email" placeholder="Entrez l'email">
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button"class="btn btn-danger" class="close" data-dismiss="modal" aria-hidden="true">Fermer</button>
                    <button type="submit" name="enreg" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
          </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modifChauffeur" tabindex="-1" aria-labelledby="modifChauffeurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifChauffeurLabel">Modification des informations du chauffeur</h4>
            </div>
            <div class="modal-body">
                <form action="oper_chauffeur.php" method="POST">
                    <input type="hidden" name="id_chauffeur" id="chauffeurId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" class="form-control" name="nom" id="chauffeurNom" placeholder="Entrez le nom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom :</label>
                                <input type="text" class="form-control" name="prenom" id="chauffeurPrenom" placeholder="Entrez le prénom" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="date_debut" class="form-label">Date de début :</label>
                                <input type="date" class="form-control" name="date_debut" id="chauffeurDateDebut" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="permis" class="form-label">Permis :</label>
                                <input type="text" class="form-control" name="permis" id="chauffeurPermis" placeholder="Entrez le numéro de permis" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone :</label>
                                <input type="text" class="form-control" name="telephone" id="chauffeurTelephone" placeholder="Entrez le numéro de téléphone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" class="form-control" name="email" id="chauffeurEmail" placeholder="Entrez l'email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="departement" class="form-label">Département :</label>
                                <input type="text" class="form-control" name="departement" id="chauffeurDepartement" placeholder="Entrez le département" required>
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
    $('#modifChauffeur').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
        var id = button.data('id'); // Extraire l'ID depuis les attributs data-*
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var date_debut = button.data('date_debut');
        var permis = button.data('permis');
        var telephone = button.data('telephone');
        var email = button.data('email');
        var departement = button.data('departement');

        // Mettre à jour le contenu du modal.
        var modal = $(this);
        modal.find('#chauffeurId').val(id);
        modal.find('#chauffeurNom').val(nom);
        modal.find('#chauffeurPrenom').val(prenom);
        modal.find('#chauffeurDateDebut').val(date_debut);
        modal.find('#chauffeurPermis').val(permis);
        modal.find('#chauffeurTelephone').val(telephone);
        modal.find('#chauffeurEmail').val(email);
        modal.find('#chauffeurDepartement').val(departement);
    });
</script>

</body>
</html>