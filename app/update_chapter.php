<h1>Modification d'un chapitre</h1>
<?php  
	$chapObject = new Chapter();
	$chap = $chapObject->read($_GET['id']);
?>

<?php display_messages(); ?>

<div class="box-center">

	<form method="post" action="#" enctype="multipart/form-data" value="8000000">

		<p>
			<label for="number">Numéro du chapitre</label>
			<input type="text"  onchange="checkNChapter();" name="chap[number]" id="number" value="<?php  echo $chap['code']; ?>">
			<span id="number_error" class=""></span>
		</p>
		<p>
			<label for="image">Image (image actuellement utilisée : <?php echo $chap->imageURL;?>) Pensez à l'uploader de nouveau pour la conserver.</label>
			<input type="file" name="chap[image]" id="image">
			<span id="image_error" class=""></span>
		</p>

		<p>
			<label for="texte">Texte</label>
			<textarea name="chap[text]" id="texte"><?php echo $chap->text;?></textarea>
			<span id="texte_error" class=""></span>
		</p>

		<p>
			<label for="question">Question à poser</label>
			<input type="text" name="chap[question]" id="question" value="<?php echo $chap->question;?>">
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
			<div id="formChoiceDiv">
			<?php
				$choice = $chap->choice;
				for($i=0;$i<count($choice->answer);$i++){
					echo '<div>
							<hr><label>Chapitre référencé :</label>
							<input type=text name=chap[choixRef]['.$i.'] class="choixRef" id=choixRef'.$i.' value="'.$choice->answer[$i]["ref"].'">
							<span id="choixRef'.$i.'_error" class=""></span>
							<label>Libellé du choix :</label>
							<input type=text name=chap[choixLib]['.$i.'] class="choixLib" id=choixLib'.$i.' value="'.$choice->answer[$i].'">
							<span id="choixLib'.$i.'_error" class=""></span>
						</div>';
				}
			?>
			</div
		</p>

		<hr>

		<div class="well">
			<a href="?p=update&id=<?php echo $_GET['book_id']; ?>" class="btn">Retour</a>
			<input type="submit" name="submit" value="Modifier" disabled="disabled" class="btn primary" id="create_but">
		</div>

	</form>

</div>

<?php
	if (isset($_POST['submit'])) {
		$chapObject->update($_POST['chap']);
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

$('#number,#texte, #question').trigger('change');
$('#number').attr("disabled","disabled");
$('#choixcb').val(<?php echo count($chap->choice->answer); ?>);
var nbFormChoice = $("#formChoiceDiv > div").size();		
for(var i = 0 ; i < nbFormChoice ; i++){
	$('.choixRef, .choixLib').trigger('change');
}


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
					alert('Erreur : Le chapitre numéro '+code+' est déjà créé !');
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
</script>
