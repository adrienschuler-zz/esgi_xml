<?php $books = simplexml_load_file(XML_FILE, 'SimpleXMLElement', LIBXML_NOCDATA); ?>

<h1 class="center">Bibliothèque</h1>

<p>Liste des livres disponibles :</p>

<table class="zebra-striped">
	
	<thead>
		<tr>
			<th class="table-title">Titre</th>
			<th>Auteur</th>
			<th class="table-date">Création</th>
			<th class="table-date">Modification</th>
			<th class="table-status">Statut</th>
			<th class="table-actions">Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php if (count($books) === 0) : ?>
			<tr>
				<td colspan="6" class="info">Aucun livre</td>
			</tr>
		<?php else : ?>
			<?php foreach ($books as $book) : ?>
				<tr>
					<td><?php echo $book['title']; ?></td>
					<td class="center"><?php echo $book->author; ?></td>
					<td class="center"><?php echo $book['created']; ?></td>
					<td class="center"><?php echo $book['modified']; ?></td>
					<td class="center">
						<?php 
							switch ($book['status']) {
								case 0:
									echo '<span class="status-green">0</span>';
									break;
								case 1:
									echo '<span class="status-yellow">1</span>';
									break;
								case 2:
									echo '<span class="status-red">2</span>';
									break;
							}
						?>
					</td>
					<td class="center">
						<a href="?p=read&id=<?php echo $book['id']; ?>" class="view" title="Consulter"></a>
						<a href="?p=update&id=<?php echo $book['id']; ?>" class="edit" title="Modifier"></a>
						<a href="?p=export&id=<?php echo $book['id']; ?>" class="script" title="Exporter le fichier XML"></a>
						<a href="?p=delete&id=<?php echo $book['id']; ?>" class="delete" title="Supprimer" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true"></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

</table>

<p>
	<a href="?p=create">Créer un nouveau livre</a>
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

<script >
	$(function() {
		$("table").tablesorter({ sortList: [[0,0]] });
	});
</script>
