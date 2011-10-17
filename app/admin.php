<?php $livres = simplexml_load_file(XML_FILE, 'SimpleXMLElement', LIBXML_NOCDATA); ?>
<?php var_dump($livres); ?>

<h1 class="center">Bibliothèque</h1>

<p>Liste des livres disponibles :</p>

<table class="zebra-striped">
	
	<thead>
		<tr>
			<th>Titre</th>
			<th>Auteur</th>
			<th>Création</th>
			<th>Modification</th>
			<th>Statut</th>
			<th class="table-actions">Actions</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>Les fourmis</td>
			<td>Bernard Werber</td>
			<td></td>
			<td></td>
			<td class="center"><span class="status-green">0</span></td>
			<td class="center">
				<a href="?p=view&id=1338" class="view" title="Consulter"></a>
				<a href="?p=edit&id=1338" class="edit" title="Modifier"></a>
				<a href="?p=export&id=1338" class="script" title="Exporter le fichier XML"></a>
				<a href="?p=delete&id=1338" class="delete" title="Supprimer" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true"></a>
			</td>
		</tr>
		<?php foreach ($livres as $livre) : ?>
			<tr>
				<td><?php echo $livre->titre; ?></td>
				<td></td>
				<td><?php echo $livre->created; ?></td>
				<td><?php echo $livre->modified; ?></td>
				<td class="center"><span class="status-yellow">1</span></td>
				<td class="center">
					<a href="?p=view&id=<?php echo $livre->id; ?>" class="view" title="Consulter"></a>
					<a href="?p=edit&id=<?php echo $livre->id; ?>" class="edit" title="Modifier"></a>
					<a href="?p=export&id=<?php echo $livre->id; ?>" class="script" title="Exporter le fichier XML"></a>
					<a href="?p=delete&id=<?php echo $livre->id; ?>" class="delete" title="Supprimer" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true"></a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>

</table>

<p>
	<a href="?p=new">Créer un nouveau livre</a>
</p>

<!-- confirmation popup -->
<div id="modal-from-dom" class="modal hide fade">
  <div class="modal-header">
    <a href="#" class="close">×</a>
    <h3>Suppression d'un livre</h3>
  </div>
  <div class="modal-body">
    <p>Confirmer la suppression du livre</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn primary">Supprimer</a>
    <a href="#" class="btn secondary">Annuler</a>
  </div>
</div>

<script src="javascripts/plugins/jquery.tablesorter.min.js"></script>
<script src="javascripts/plugins/twitter-bootstrap-1.3/bootstrap-modal.js"></script>
<script >
	
	$(function() {
		$("table").tablesorter({ sortList: [[1,0]] });
	});

</script>
