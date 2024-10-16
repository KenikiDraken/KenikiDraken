<?php
require_once("fournisseur_data.php");
require_once('pagination.php');

$totalFournisseurs = $db->query("SELECT COUNT(*) FROM fournisseur")->fetchColumn();
$totalPages = ceil($totalFournisseurs / $PerPage);

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
                <p class="gest_veh">Gestions des Fournisseurs et pièces</p>
            </div>
        </form>
    </div>
    <div class="form-group">
        <div class="container-R-1">
            <form action="page.php" method="POST">
                <p class="gest_veh-1">+ Gerer</p>
                <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-responsables" type="submit" name="fournisseurs">
                        <i class="fa fa-users"></i><br>
                        <span>Gerer les Fournisseurs</span>
                    </button>
                    <button class="btn btn-responsables" type="submit" name="pieces">
                        <i class="fa fa-cogs"></i><br>
                        <span>Gerer Pieces</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="ligne-separation"></div>
        <div class="container-R-2">
            <div class="form-group">
                <p class="gest_veh-1">Gestion des Fournisseurs</p>
            </div>
            <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-respon-1" type="button" data-toggle="modal" data-target="#ajoutFournisseur">
                        <i class="fa fa-user-tie">+</i><br>
                        <span>Nouveau Fournisseur</span>
                    </button>

                <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon">
                        <span>Total Fournisseur</span><br>
                        <i class="fa fa-list"> <?=$totalFournisseur?></i>
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
                <!-- Nom Fournisseur Search -->
                <input type="text" name="nom_fournisseur" placeholder="Rechercher par nom du Fournisseur" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Type fourniture Search -->
                <input type="text" name="type_fourniture" placeholder="Rechercher par Type de fourniture" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Adresse Search -->
                <input type="text" name="adresse" placeholder="Rechercher par Adresse" class="form-control" style="width: 25%;">
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
                <th>ID Fournisseur</th>
                <th>Nom du Fournisseur</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Type de Fourniture</th>
                <th>Adresse</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $fournisseur) { ?>
                <tr>
                    <td><?= htmlspecialchars($fournisseur->ID_fournisseur) ?></td>
                    <td><?= htmlspecialchars($fournisseur->nom_fournisseur) ?></td>
                    <td><?= htmlspecialchars($fournisseur->contact) ?></td>
                    <td><?= htmlspecialchars($fournisseur->email) ?></td>
                    <td><?= htmlspecialchars($fournisseur->type_fourniture) ?></td>
                    <td><?= htmlspecialchars($fournisseur->adresse) ?></td>
                    <td>
                        <!-- Bouton pour modifier un fournisseur -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modifFournisseur" 
                            data-id="<?= $fournisseur->ID_fournisseur; ?>" 
                            data-nom_fournisseur="<?= htmlspecialchars($fournisseur->nom_fournisseur); ?>" 
                            data-contact="<?= htmlspecialchars($fournisseur->contact); ?>" 
                            data-email="<?= htmlspecialchars($fournisseur->email); ?>" 
                            data-type_fourniture="<?= htmlspecialchars($fournisseur->type_fourniture); ?>"
                            data-adresse="<?= htmlspecialchars($fournisseur->adresse); ?>">
                            Modifier
                        </button>
                        <!-- Bouton pour supprimer un fournisseur -->
                        <a href="delete.php?id_fournisseur=<?= $fournisseur->ID_fournisseur ?>">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucun fournisseur n'est trouvé -->
                <tr>
                    <td colspan="7">Aucun fournisseur trouvé pour les critères sélectionnés.</td>
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

<!-- Modal pour ajouter un fournisseur -->
<div class="modal fade" id="ajoutFournisseur" tabindex="-1" aria-labelledby="ajoutFournisseurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutFournisseurLabel">Ajouter un nouveau fournisseur</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="oper_fournisseur.php" method="POST">
                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="nom_fournisseur" class="form-label">Nom du fournisseur :</label>
                            <input type="text" class="form-control" name="nom_fournisseur" placeholder="Nom du fournisseur" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Contact :</label>
                            <input type="text" class="form-control" name="contact" placeholder="Contact" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email :</label>
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type_fourniture" class="form-label">Type de Fourniture :</label>
                            <input type="text" class="form-control" name="type_fourniture" placeholder="Type de fourniture" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-12 mb-3">
                            <label for="adresse" class="form-label">Adresse :</label>
                            <input type="text" class="form-control" name="adresse" placeholder="Adresse" required>
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

<div class="modal fade" id="modifFournisseur" tabindex="-1" aria-labelledby="modifFournisseurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifFournisseurLabel">Modification des informations du fournisseur</h4>
            </div>
            <div class="modal-body">
                <form action="oper_fournisseur.php" method="POST">
                    <input type="hidden" name="id_fournisseur" id="fournisseurId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="nom_fournisseur" class="form-label">Nom du fournisseur :</label>
                                <input type="text" class="form-control" name="nom_fournisseur" id="fournisseurNom" placeholder="Entrez le nom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact :</label>
                                <input type="text" class="form-control" name="contact" id="fournisseurContact" placeholder="Entrez le contact" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" class="form-control" name="email" id="fournisseurEmail" placeholder="Entrez l'email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="type_fourniture" class="form-label">Type de fourniture :</label>
                                <input type="text" class="form-control" name="type_fourniture" id="fournisseurType" placeholder="Entrez le type de fourniture" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 mb-3">
                                <label for="adresse" class="form-label">Adresse :</label>
                                <input type="text" class="form-control" name="adresse" id="fournisseurAdresse" placeholder="Entrez l'adresse" required>
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
    $('#modifFournisseur').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
    var id = button.data('id'); // Extraire l'ID depuis les attributs data-*
    var nom_fournisseur = button.data('nom_fournisseur');
    var contact = button.data('contact');
    var email = button.data('email');
    var type_fourniture = button.data('type_fourniture');
    var adresse = button.data('adresse');

    // Mettre à jour le contenu du modal.
    var modal = $(this);
    modal.find('#fournisseurId').val(id);
    modal.find('#fournisseurNom').val(nom_fournisseur);
    modal.find('#fournisseurContact').val(contact);
    modal.find('#fournisseurEmail').val(email);
    modal.find('#fournisseurType').val(type_fourniture);
    modal.find('#fournisseurAdresse').val(adresse);
    });
</script>

</body>
</html>