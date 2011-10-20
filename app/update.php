<?php  
	$book = new Book();
	$book = $book->read($_GET['id']);
	$book = $book[0];
?>

<h1 class="center">Modification du livre "<?php echo $book['title']; ?>"</h1>

<p>
	<a href="?p=update_intro">Modifier l'introduction</a>
</p>

<p>Chapitres :</p>

<table class="zebra-striped">
	
	<thead>
		<tr>
			<th>N°</th>
			<th>Création</th>
			<th>Modification</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<?php if (count($book->chapters) === 0) : ?>
					<td colspan="6" class="info">Aucun chapitre</td>
			<?php else : ?>
				<?php foreach ($book->chapters as $chapter) : ?>
						<td><?php echo $chapter['id']; ?></td>
						<td><?php echo $chapter['created']; ?></td>
						<td><?php echo $chapter['modified']; ?></td>
						<td class="center">
							<a href="?p=read_chapter&id=<?php echo $chapter['id']; ?>" class="view" title="Consulter"></a>
							<a href="?p=update_chapter&id=<?php echo $chapter['id']; ?>" class="edit" title="Modifier"></a>
							<a href="?p=export_chapter&id=<?php echo $chapter['id']; ?>" class="script" title="Exporter le fichier XML" target="_blank"></a>
							<a href="?p=delete_chapter&id=<?php echo $chapter['id']; ?>" class="delete" title="Supprimer" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true"></a>
						</td>
				<?php endforeach; ?>
			<?php endif; ?>
		</tr>
	</tbody>

</table>

<p>
	<a href="?p=create_chapter&id=<?php echo $book['id']; ?>">Créer un nouveau chapitre</a>
</p>

<a href="?p=admin" class="btn">Retour</a>

<!-- confirmation popup -->
<div id="modal-from-dom" class="modal hide fade">
  <div class="modal-header">
    <a href="#" class="close">×</a>
    <h3>Suppression d'un chapitre</h3>
  </div>
  <div class="modal-body">
    <p>Confirmer la suppression du chapitre</p>
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
		$("table").tablesorter({ sortList: [[0,0]] });
	});

</script>

