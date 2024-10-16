<?php 
require_once("piece_data.php");

require_once('pagination.php');

$totalPieces = $db->query("SELECT COUNT(*) FROM piece")->fetchColumn();
$totalPages = ceil($totalPieces / $PerPage);
// Récupération des fournisseurs disponibles
try {
    $fournisseursStmt = $db->query("SELECT ID_fournisseur, nom_fournisseur FROM fournisseur");
    $fournisseurs = $fournisseursStmt->fetchAll(PDO::FETCH_OBJ);
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
                <p class="gest_veh-1">Gestion des Pieces</p>
            </div>
            <div class ="form-group">
                    <!-- Bouton pour ouvrir le modal -->
                    <button class="btn btn-respon-1" type="button" data-toggle="modal" data-target="#ajoutPiece">
                        <i class="fa fa-cog">+</i><br>
                        <span>Nouvelle Piece</span>
                    </button>

                <div class="button-container right-buttons"> <!-- Conteneur pour les boutons à droite -->
                    <!-- Bouton pour ouvrir le modal -->
                    <div class="btn btn-respon">
                        <span>Total Pieces</span><br>
                        <i class="fa fa-layer-group"> <?=$totalPiece?></i>
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
                <input type="text" name="type_piece" placeholder="Rechercher par type de Piece" class="form-control" style="width: 25%;">
                <button type="submit" class="btn btn-primary" style="padding: 4px 10px; margin-left:-10px">
                    <i class="fa fa-search"></i>
                </button>
                <!-- Type fourniture Search -->
                <select name="nom_founisseur" class="form-control" style="width: 25%;">
                    <option value="" disabled selected>Choisissez un fournisseur</option>
                    <?php foreach ($fournisseurs as $fournisseur): ?>
                        <option value="<?php echo htmlspecialchars($fournisseur->nom_fournisseur); ?>">
                            <?php echo htmlspecialchars($fournisseur->nom_fournisseur); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
    <!-- Table HTML pour afficher les résultats -->
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="info">
                <th>ID Pièce</th>
                <th>Type de pièce</th>
                <th>Nom du fournisseur</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Date de livraison</th>
                <th>Prix total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($searchResults) > 0) { ?>
                <?php foreach ($searchResults as $piece) { ?>
                <tr>
                    <td><?= htmlspecialchars($piece->ID_piece) ?></td>
                    <td><?= htmlspecialchars($piece->type_piece) ?></td>
                    <td><?= htmlspecialchars($piece->nom_fournisseur) ?></td>
                    <td><?= htmlspecialchars($piece->prix_unitaire) ?></td>
                    <td><?= htmlspecialchars($piece->quantite) ?></td>
                    <td><?= htmlspecialchars($piece->date_livraison) ?></td>
                    <td><?= htmlspecialchars($piece->prix_total) ?></td>
                    <td>
                        <!-- Bouton pour modifier une pièce -->
                        <button class="btn btn-warning" data-toggle="modal" data-target="#modifPiece" 
                            data-id="<?= $piece->ID_piece; ?>" 
                            data-type_piece="<?= htmlspecialchars($piece->type_piece); ?>" 
                            data-nom_fournisseur="<?= htmlspecialchars($piece->nom_fournisseur); ?>" 
                            data-prix_unitaire="<?= htmlspecialchars($piece->prix_unitaire); ?>" 
                            data-quantite="<?= htmlspecialchars($piece->quantite); ?>" 
                            data-date_livraison="<?= htmlspecialchars($piece->date_livraison); ?>" 
                            data-prix_total="<?= htmlspecialchars($piece->prix_total); ?>">
                            Modifier
                        </button>
                        <!-- Bouton pour supprimer une pièce -->
                        <a href="delete.php?id_piece=<?= $piece->ID_piece ?>">
                            <button class="btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                        </a>
                    </td>
                </tr>
                <?php } ?>
            <?php } else { ?>
                <!-- Si aucune pièce n'est trouvée -->
                <tr>
                    <td colspan="8">Aucune pièce trouvée pour les critères sélectionnés.</td>
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

<!-- Modal d'ajout de pièce -->
<div class="modal fade" id="ajoutPiece" tabindex="-1" aria-labelledby="ajoutPieceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajoutPieceLabel">Ajouter une nouvelle pièce</h4>
            </div>
            <div class="modal-body">
                <form action="oper_piece.php" method="POST">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="type_piece" class="form-label">Type de pièce :</label>
                                <input type="text" class="form-control" name="type_piece" placeholder="Type de pièce" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nom_fournisseur" class="form-label">Fournisseur :</label>
                                <select name="nom_fournisseur" class="form-control" required>
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
                                <label for="prix_unitaire" class="form-label">Prix unitaire :</label>
                                <input type="number" class="form-control" name="prix_unitaire" placeholder="Prix unitaire" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantite" class="form-label">Quantité :</label>
                                <input type="number" class="form-control" name="quantite" placeholder="Quantité" required>
                            </div>
                        </div>

                        <div class="from-group">
                            <div class="col-md-12 mb-3">
                                <label for="date_livraison" class="form-label">Date de livraison :</label>
                                <input type="date" class="form-control" name="date_livraison" required>
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

<div class="modal fade" id="modifPiece" tabindex="-1" aria-labelledby="modifPieceLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modifPieceLabel">Modification des informations de la pièce</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="oper_piece.php" method="POST">
                    <input type="hidden" name="id_piece" id="pieceId" value="">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="type_piece" class="form-label">Type de pièce :</label>
                                <input type="text" class="form-control" name="type_piece" id="pieceType" placeholder="Entrez le type de pièce" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nom_fournisseur" class="form-label">Fournisseur :</label>
                                <select name="nom_fournisseur" class="form-control" required>
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
                                <label for="prix_unitaire" class="form-label">Prix unitaire :</label>
                                <input type="number" class="form-control" name="prix_unitaire" id="piecePrixUnitaire" placeholder="Entrez le prix unitaire" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="quantite" class="form-label">Quantité :</label>
                                <input type="number" class="form-control" name="quantite" id="pieceQuantite" placeholder="Entrez la quantité" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 mb-3">
                                <label for="date_livraison" class="form-label">Date de livraison :</label>
                                <input type="date" class="form-control" name="date_livraison" id="pieceDateLivraison" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="prix_total" class="form-label">Prix total :</label>
                                <input type="number" class="form-control" name="prix_total" id="piecePrixTotal" placeholder="Prix total calculé" readonly>
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
    $('#modifPiece').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Bouton qui a déclenché le modal
        var id = button.data('id'); // Extraire l'ID depuis les attributs data-*
        var type_piece = button.data('type_piece');
        var fournisseur = button.data('nom_fournisseur');
        var prix_unitaire = button.data('prix_unitaire');
        var quantite = button.data('quantite');
        var date_livraison = button.data('date_livraison');

        // Mettre à jour le contenu du modal.
        var modal = $(this);
        modal.find('#pieceId').val(id);
        modal.find('#pieceType').val(type_piece);
        modal.find('#pieceFournisseur').val(fournisseur);
        modal.find('#piecePrixUnitaire').val(prix_unitaire);
        modal.find('#pieceQuantite').val(quantite);
        modal.find('#pieceDateLivraison').val(date_livraison);
    });
</script>

</body>
</html>