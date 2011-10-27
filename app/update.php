<?php  
	$B = new Book();
	$book = $B->read($_GET['id']);
	$chapters = $B->getChapters();
?>

<h1 class="center">Modification du livre "<?php echo $book['title']; ?>"</h1>

<p>
	<a href="?p=update_intro">Modifier l'introduction</a>
</p>

<p>Chapitres :</p>


<?php 

// ################################ A mettre dans la classe BOOK
function ParagUsedNCreated($xml)
{
	//Recupere le tableau des paragraphes[references] utilisés
	$id =$_GET['id'];
	$parags= $xml->xpath("//book[@id='".$id."']//answer/@ref");
	$paragUsed = array_unique($parags);
	//Recupere le tableau des paragraphes[codes] créés
	$paragCreated = $xml->xpath("//book[@id='".$id."']//chapter/@code");
	$parUsedNCreated = Array();

	foreach($paragUsed as $pused)
	{
		$create=false;
		foreach($paragCreated as $pcreated)
		{
			if(trim($pused)==trim($pcreated)) 
				$create=true;			
		}
		if(!$create) 
		{	
			array_push($parUsedNCreated, $pused);					
		}
	}	
	$idUsedNCreated=array_unique($parUsedNCreated);
	return $idUsedNCreated;	
}
		
?>
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
		<?php if (count($chapters) === 0) : ?>
			<tr>
				<td colspan="6" class="info">Aucun chapitre</td>
			</tr>
		<?php else : ?>
			<?php foreach ($chapters as $chapter) : ?>
				<tr>
					<td class="center"><?php echo $chapter['code']; ?></td>
					<td class="center"><?php echo $chapter['created']; ?></td>
					<td class="center"><?php echo $chapter['modified']; ?></td>
					<td class="center">
						<a href="?p=read_chapter&id=<?php echo $chapter['id']; ?>" class="view" title="Consulter"></a>
						<a href="?p=update_chapter&id=<?php echo $chapter['id']; ?>" class="edit" title="Modifier"></a>
						<a href="?p=export_chapter&id=<?php echo $chapter['id']; ?>" class="script" title="Exporter le fichier XML" target="_blank"></a>
						<a href="?p=delete_chapter&id=<?php echo $chapter['id']; ?>" class="delete" title="Supprimer" data-controls-modal="modal-from-dom" data-backdrop="true" data-keyboard="true"></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
	</tbody>

</table>


<p>Chapitres à créer :</p>
<table class="zebra-striped">
	
	<thead>
		<tr>
			<th>N°</th>
			<th>Actions</th>
		</tr>
	</thead>

	<tbody>
		<?php $chapters = ParagUsedNCreated($book->file); ?>
			<?php if (count($chapters) === 0) : ?>
				<tr>
					<td colspan="6" class="info">Aucun chapitre à créer</td>
				</tr>
			<?php else : ?>
				 <?php foreach ($chapters as $id) : ?>
					<tr>
						<td class="center"><?php echo $id; ?></td>
						<td class="center">
							<a href="?p=create_chapter&id=<?php echo $book['id']; ?>&chap=<?php echo $id;?>" class="create" title="Créer" target="_blank"></a>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
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

<script >
	$(function() {
		$("table").tablesorter({ sortList: [[0,0]] });
	});
</script>

