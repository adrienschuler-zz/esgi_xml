<?php $books = simplexml_load_file(XML_FILE, 'SimpleXMLElement', LIBXML_NOCDATA); ?>

<div class="page-header">
	<h2>Bibliothèque</h1>
</div>

<?php display_messages(); ?>

<p>
	<a href="?p=create">Créer un nouveau livre</a>
</p>

<hr>

<p class="info">Liste des livres disponibles :</p>

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
				<?php 
					$b = new Book();
					$b->read($book['id']);
				?>
				<tr>
					<td><?php echo $book['title']; ?></td>
					<td class="center"><?php echo $book['author']; ?></td>
					<td class="center"><?php echo $book['created']; ?></td>
					<td class="center"><?php echo $book['modified']; ?></td>
					<td class="center">
						<?php if (count($b->ParagUsedNCreated()) == 0) : ?>
							<span class="status-green">0</span>
						<?php else : ?>
							<span class="status-red">1</span>
						<?php endif; ?>
					</td>
					<td class="center">
						<a href="?p=export&choice=consult&id=<?php echo $book['id']; ?>" class="view" title="Consulter"></a>
						<a href="?p=update&id=<?php echo $book['id']; ?>" class="edit" title="Modifier"></a>
						<a href="?p=download&choice=download&id=<?php echo $book['id']; ?>" class="script" title="Exporter le fichier XML" target="_blank"></a>
						<a href="?p=delete&id=<?php echo $book['id']; ?>" class="delete" title="Supprimer" data-id="<?php echo $book['id']; ?>"></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

</table>

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
    <a href="#" class="btn primary delete-button">Supprimer</a>
    <a href="#" class="btn secondary cancel">Annuler</a>
  </div>
</div>

<script >
	$(function() {
		var popup = $('#modal-from-dom').modal({
	        backdrop: true,
	        closeOnEscape: true,
	    	modal: true
	    });

		$('table').tablesorter({ sortList: [[0,0]] });

		$('.delete').click(function() {
			popup.modal('show');
			$.data(popup, 'id', $(this).attr('data-id'));
			$.data(popup, 'url', $(this).attr('href'));
			return false;
		});

		$('.cancel').click(function() {
			popup.modal('hide');
		});

		$('.delete-button').click(function() {
			$(location).attr('href', $.data(popup, 'url'));
		});
	});
</script>
