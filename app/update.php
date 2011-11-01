<?php  
	$B = new Book();
	$book = $B->read($_GET['id']);
	$chapters = $B->getChapters();
	$chapters_to_do = $B->ParagUsedNCreated();
?>

<div class="page-header">
	<h2>Modification du livre <u><?php echo $book['title']; ?></u></h2>
	Créé par <i class="book-author"><?php echo $book['author']; ?></i>.
</div>

<?php display_messages(); ?>

<p>
	<a href="?p=update_intro&id=<?php echo $book['id']; ?>" class="update-intro">Modifier l'introduction</a> &nbsp;|&nbsp;
	<a href="?p=create_chapter&id=<?php echo $book['id']; ?>">Créer un nouveau chapitre</a>
</p>

<hr>

<p class="info">Liste des chapitres :</p>

<table class="zebra-striped">
	
	<thead>
		<tr>
			<th>N°</th>
			<th>Auteur</th>
			<th>Chapitres référencés</th>
			<th>Création</th>
			<th>Modification</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php if (count($chapters) === 0) : ?>
			<tr>
				<td colspan="6" class="info">Aucun chapitre</td>
			</tr>
		<?php else : ?>
			<?php foreach ($chapters as $chapter) : ?>
				<tr>
					<td class="center">#<?php echo $chapter['code']; ?></td>
					<td class="center"><?php echo $chapter['author']; ?></td>
					<td class="center">
						<?php 
							foreach ($chapter->choice->answer as $answer) {
								echo ' #' . $answer['ref'];
							}
						?>
					</td>
					<td class="center"><?php echo $chapter['created']; ?></td>
					<td class="center"><?php echo $chapter['modified']; ?></td>
					<td class="center">
						<a href="?p=export_chapter&id=<?php echo $chapter['id']; ?>" class="view" title="Consulter" target="_blank"></a>
						<a href="?p=update_chapter&id=<?php echo $chapter['id']; ?>&book_id=<?php echo $_GET['id']; ?>" class="edit" title="Modifier" data-chapter-author="<?php echo $chapter['author']; ?>"></a>						
						<a href="?p=delete_chapter&chapter_id=<?php echo $chapter['id']; ?>&book_id=<?php echo $book['id']; ?>" class="delete" title="Supprimer" data-book-id="<?php echo $book['id']; ?>" data-chapter-id="<?php echo $chapter['id']; ?>" data-chapter-author="<?php echo $chapter['author']; ?>"></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

</table>

<hr>

<p class="info">Ces chapitres sont actuellement référencés par d'autres chapitres mais n'existent pas :</p>

<table class="zebra-striped">
	
	<thead>
		<tr>
			<th>N°</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php if (count($chapters_to_do) === 0) : ?>
			<tr>
				<td colspan="6" class="info">Aucun chapitre à créer</td>
			</tr>
		<?php else : ?>
			 <?php foreach ($chapters_to_do as $id) : ?>
				<tr>
					<td class="center"><?php echo $id; ?></td>
					<td class="center">
						<a href="?p=create_chapter&id=<?php echo $book['id']; ?>&chap=<?php echo $id; ?>" class="create" title="Créer"></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

</table>

<hr>

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

			if (
				$('.book-author').html() !== "<?php echo $_SESSION['user']['login']; ?>" &&
				$(this).attr('data-chapter-author') !== "<?php echo $_SESSION['user']['login']; ?>"
			) {
				$('.alert-message')
					.removeClass('success')
					.addClass('error')
					.html('<p><strong>Erreur de permission !</strong> La suppression d\'un chapitre ne peut être effectué que par l\'auteur du livre ou du chapitre.</p><a class="close" href="#">×</a>')
					.show();

				return false;
			}

			popup.modal('show');
			$.data(popup, 'book-id', $(this).attr('data-book-id'));
			$.data(popup, 'chapter-id', $(this).attr('data-chapter-id'));
			$.data(popup, 'url', $(this).attr('href'));
			return false;
		});

		$('.cancel').click(function() {
			popup.modal('hide');
		});

		$('.delete-button').click(function() {
			$(location).attr('href', $.data(popup, 'url'));
		});

		$('.update-intro').click(function() {
			if ($('.book-author').html() !== "<?php echo $_SESSION['user']['login']; ?>") {
				$('.alert-message')
					.removeClass('success')
					.addClass('error')
					.html('<p><strong>Erreur de permission !</strong> La modification de l\'introduction ne peut être effectué que par l\'auteur du livre.</p><a class="close" href="#">×</a>')
					.show();

				return false;
			}
		});

		$('.edit').click(function() {
			if (
				$('.book-author').html() !== "<?php echo $_SESSION['user']['login']; ?>" &&
				$(this).attr('data-chapter-author') !== "<?php echo $_SESSION['user']['login']; ?>"
			) {
				$('.alert-message')
					.removeClass('success')
					.addClass('error')
					.html('<p><strong>Erreur de permission !</strong> La modification d\'un chapitre ne peut être effectué que par l\'auteur du livre ou du chapitre.</p><a class="close" href="#">×</a>')
					.show();

				return false;
			}
		});
	});
</script>

