<?php  
	$book = new Book();
	$book = $book->read($_GET['id']);
?>

<div class="page-header">
	<h2>Création d'un chapitre</h2>
</div>

<?php display_messages(); ?>

<div class="box-center">

	<form method="post" action="?p=create_chapter&id=<?php echo $book['id']; ?>" enctype="multipart/form-data" value="8000000">

		<div class="alert-message error" style="display:none;"></div>

		<p>
			<label for="number">Numéro du chapitre</label>
			<input type="text"  onchange="checkNChapter();" name="chap[number]" id="number" value="<?php if (isset($_GET['chap'])) echo $_GET['chap']; ?>">

			<?php if(isset($_GET['chap'])) : ?>
				<input type="hidden" name="chap[number]" value="<?php if (isset($_GET['chap'])) echo $_GET['chap']; ?>">
			<?php endif; ?>

			<span id="number_error" class=""></span>
		</p>
		<p>
			<label for="image">Image</label>
			<input type="file" name="chap[image]" id="image">
			<span id="image_error" class=""></span>
		</p>

		<p>
			<label for="texte">Texte</label>
			<textarea name="chap[text]" id="texte"></textarea>
			<span id="texte_error" class=""></span>
		</p>

		<p>
			<label for="question">Question à poser</label>
			<input type="text" name="chap[question]" id="question">
			<span id="question_error" class=""></span>
		</p>

		<p>
			<label>Nombre de choix</label>
			<select onchange='createFormChoice(this.value);' disabled="disabled" id="choixcb">
				<option value="">-</option>
				<?php
					for($i=1;$i<=10;$i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select>
			<div id="formChoiceDiv"></div
		</p>

		<hr>

		<div class="well">
			<a href="?p=update&id=<?php echo $book['id']; ?>" class="btn">Retour</a>
			<input type="submit" name="submit" value="Créer" disabled="disabled" class="btn primary" id="create_but">
		</div>

	</form>

</div>

<?php
	if (isset($_POST['submit'])) {
		new Chapter($book['id'], $_POST['chap']);
	}
?>

<script>
function createFormChoice(nbForm) {
	var div = $('#formChoiceDiv'),
		nbFormHere = $("#formChoiceDiv > div").size();

	for(var i = nbFormHere; i < nbForm; i++) {
		var divFormElement = 	$('<div></div>'),
			lRef = 				$('<hr><label>Chapitre référencé :</label>'),
			inputRef = 			$('<input type=text name=chap[choixRef]['+i+'] class="choixRef" id=choixRef'+i+'>'),
			valid_chapter_ref = $('<span id="choixRef'+i+'_error" class=""></span>'),
			lLibelle = 			$('<label>Libellé du choix :</label>'),
			inputLibelle = 		$('<input type=text name=chap[choixLib]['+i+'] class="choixLib" id=choixLib'+i+'>'),
			valid_ref_lib = 	$('<span id="choixLib'+i+'_error" class=""></span>');

		div.append(
			divFormElement.append(lRef, inputRef,valid_chapter_ref, lLibelle, inputLibelle, valid_ref_lib)
		);
	}
}

function check($elem, bool) {
	var container = $('#' + $elem.prop('id') + '_error');
	if (bool) {
		container.removeClass('form_ok');
		container.addClass('form_error');
		return false;
	} else {
		container.removeClass('form_error');
		container.addClass('form_ok');
		return true;
	}
}

function unlockCreation() {

	if($("#number_error").attr("class").indexOf("form_ok") != -1 &&
		$("#image_error").attr("class").indexOf("form_error") == -1 &&
		$("#texte_error").attr("class").indexOf("form_ok") != -1){
		
		var allValid=true;
		var nbFormChoice = $("#formChoiceDiv > div").size();
		
		for(var i = 0 ; i < nbFormChoice ; i++){
			if($("#choixRef"+i+"_error").attr("class").indexOf("form_ok") == -1 ||
				$("#choixLib"+i+"_error").attr("class").indexOf("form_ok") == -1){
				allValid=false;
			}
		}
		if(allValid){
			$("#create_but").removeAttr("disabled");
		}
		else{
			$("#create_but").attr("disabled","disabled");
		}
	}
	else{
		$("#create_but").attr("disabled","disabled");
	}
}

$('#texte, .choixLib').live('change', function() {
	check($(this), $.trim($(this).val()).length == 0);
	unlockCreation();
});

$('#question').live('change', function() {
	if(check($(this), $.trim($(this).val()).length == 0)){
		$('#choixcb').removeAttr("disabled");
	}else{
		$('#choixcb').attr("disabled","disabled");
		if($("#formChoiceDiv > div").size() > 0){
			$("#create_but").attr("disabled","disabled");
			return;
		}
	}
	unlockCreation();
});

$('#number, .choixRef').live('change', function() {
	check($(this), !((parseFloat($(this).val()) == parseInt($(this).val())) && !isNaN($(this).val())));
	unlockCreation();
});

$('#image').bind('change', function() {
	var extension_valide = ['jpeg','jpg','bmp','gif','png'],
		fileName = $(this).val().match(/[-_\w]+[.][\w]+$/i)[0],
		extension = fileName.substring(fileName.indexOf(".") + 1);

	check($(this), $.inArray(extension, extension_valide) == -1);
	unlockCreation();
});

function checkNChapter()
{
		$.get("?p=export&id="+getUrlParameter('id'), function(xml){
			$(xml).find('chapter').each( function(){ 
				var code = $(this).attr('code');
				if(code==$('#number').val())
				{
					$('.alert-message').html('<p><strong>Erreur !</strong> Le chapitre numéro '+code+' est déjà créé.</p><a class="close" href="#">×</a>');
					$('.alert-message').show();

					$('#number_error').removeClass('form_ok');
					$('#number_error').addClass('form_error');
					unlockCreation();
					return true;
				}
				else
				{
					
					return false;
				}
		});			
	});
}

function getUrlParameter(name) {

    var searchString = location.search.substring(1).split('&');

    for (var i = 0; i < searchString.length; i++) {

        var parameter = searchString[i].split('=');
        if(name == parameter[0])    return parameter[1];
    }
    return false;
}

<?php if(isset($_GET['chap'])) : ?>
	$('#number').trigger('change');
	$('#number').attr('disabled', 'disabled');
<?php endif; ?>

</script>
