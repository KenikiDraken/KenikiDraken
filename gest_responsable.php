<?php
require_once("responsable_data.php");
require_once('pagination.php');

$totalResponsables = $db->query("SELECT COUNT(*) FROM user")->fetchColumn();
$totalPages = ceil($totalResponsables / $PerPage);

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
                <p class="gest_veh">Gestions des Responsables</p>
            </div>
        </form>
        <div class ="form-group">
             <!-- Bouton pour ouvrir le modal -->
            <button class="btn btn-responsables" type="button" data-toggle="modal" data-target="#ajoutUtilisateur">
                <i class="fa fa-user-tie">+</i><br>
                <span>Nouveau administrateur</span>
            </button>
             <!-- Bouton pour ouvrir le modal -->
            <div class="btn btn-respon">
                <span>Administrateur Total</span><br>
                <i class="fa fa-users"> <?=$totalUsers?></i>
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
                <!--  Search for compte user -->
                <input type="text" name="compte" placeholder="Rechercher par nom de compte" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                 <!--  Search for prenom -->
                 <input type="text" name="prenom" placeholder="Rechercher par prenom" class="form-control" style="width: 25%;">
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
    <!-- Table d'affichage des utilisateurs -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info">
                <th>Compte</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Fonction</th>
                <th>Email</th>
                <th>Adresse</th>
                <th>En Ligne</th> <!-- Nouveau champ -->
                <th>Menus</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $user) { ?>
                <tr>
                    <td><?= htmlspecialchars($user->compte) ?></td>
                    <td><?= htmlspecialchars($user->nom) ?></td>
                    <td><?= htmlspecialchars($user->prenom) ?></td>
                    <td><?= htmlspecialchars($user->fonction) ?></td>
                    <td><?= htmlspecialchars($user->email) ?></td>
                    <td><?= htmlspecialchars($user->adresse) ?></td>
                    <td>
                        <?php
                        if (isset($_SESSION['logged_in_users'][$user->compte])) { // Suppose que les sessions pour les utilisateurs connectés sont stockées dans $_SESSION['logged_in_users']
                            echo '<span class="badge badge-success">En ligne</span>';
                        } else {
                            echo '<span class="badge badge-danger">Hors ligne</span>';
                        }?>
                    </td>
                    <td>
                        <!-- Bouton pour modifier un utilisateur -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modifUtilisateur" 
                            data-id="<?= $user->idp; ?>" 
                            data-compte="<?= htmlspecialchars($user->compte); ?>" 
                            data-nom="<?= htmlspecialchars($user->nom); ?>" 
                            data-prenom="<?= htmlspecialchars($user->prenom); ?>" 
                            data-fonction="<?= htmlspecialchars($user->fonction); ?>" 
                            data-email="<?= htmlspecialchars($user->email); ?>"
                            data-adresse="<?= htmlspecialchars($user->adresse); ?>">
                            Modifier
                        </button>
                        <!-- Bouton pour supprimer un utilisateur -->
                        <a href="delete.php?id_user=<?= $user->idp ?>">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucun utilisateur n'est trouvé -->
                <tr>
                    <td colspan="9">Aucun utilisateur trouvé pour les critères sélectionnés.</td>
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
<!-- Modal pour ajouter un nouvel utilisateur -->
<div class="modal fade" id="ajoutUtilisateur" tabindex="-1" aria-labelledby="ajoutUtilisateurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutUtilisateurLabel">Ajouter un nouvel utilisateur</h4>
            </div>
            <div class="modal-body">
                <form action="oper_responsable.php" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="compte" class="form-label">Nom d'utilisateur :</label>
                                <input type="text" class="form-control" name="compte" placeholder="Nom d'utilisateur" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom :</label>
                                <input type="text" class="form-control" name="prenom" placeholder="Prénom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fonction" class="form-label">Fonction :</label>
                                <input type="text" class="form-control" name="fonction" placeholder="Fonction" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="adresse" class="form-label">Adresse (ville-quartier) :</label>
                                <input type="text" class="form-control" name="adresse" placeholder="Adresse (ville-quartier)" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="motpasse" class="form-label">Mot de Passe :</label>
                                <input type="password" class="form-control" name="motpasse" placeholder="Mot de Passe" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="motpasse1" class="form-label">Confirmer Mot de Passe :</label>
                                <input type="password" class="form-control" name="motpasse1" placeholder="Confirmer Mot de Passe" required>
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
<div class="modal fade" id="modifUtilisateur" tabindex="-1" aria-labelledby="modifUtilisateurLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifUtilisateurLabel">Modification des informations de l'utilisateur</h4>
            </div>
            <div class="modal-body">
                <form action="oper_responsable.php" method="POST">
                    <input type="hidden" name="id_user" id="userId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="compte" class="form-label">Compte :</label>
                                <input type="text" class="form-control" name="compte" id="userCompte" placeholder="Entrez le nom du compte" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom :</label>
                                <input type="text" class="form-control" name="nom" id="userNom" placeholder="Entrez le nom" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="prenom" class="form-label">Prénom :</label>
                                <input type="text" class="form-control" name="prenom" id="userPrenom" placeholder="Entrez le prénom" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fonction" class="form-label">Fonction :</label>
                                <input type="text" class="form-control" name="fonction" id="userFonction" placeholder="Entrez la fonction" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email :</label>
                                <input type="email" class="form-control" name="email" id="userEmail" placeholder="Entrez l'email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="adresse" class="form-label">Adresse :</label>
                                <input type="text" class="form-control" name="adresse" id="userAdresse" placeholder="Entrez l'adresse" required>
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
    $('#modifUtilisateur').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var compte = button.data('compte');
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var fonction = button.data('fonction');
        var email = button.data('email');
        var adresse = button.data('adresse');

        // Update the modal's content.
        var modal = $(this);
        modal.find('#userId').val(id);
        modal.find('#userCompte').val(compte);
        modal.find('#userNom').val(nom);
        modal.find('#userPrenom').val(prenom);
        modal.find('#userFonction').val(fonction);
        modal.find('#userEmail').val(email);
        modal.find('#userAdresse').val(adresse);
    });
</script>

</body>
</html>