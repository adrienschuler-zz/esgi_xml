<?php
$book = new Book();
$book = $book->read($_GET['id']);
$file = 'tmp/' . $book['title'] . '_' . $book['id'] . '.xml';
$book->asXML($file);
$fileTXT = 'tmp/' . $book['title'] . '_' . $book['id'] . '.txt';

$fp = fopen($file, 'r');
$fTxt = fopen($fileTXT, 'w+');
while ($ligneXML = fgets($fp, 1024)) {
	fputs($fTxt, $ligneXML);
	echo $ligneXML . '<br />';
}
fclose($fp);
fclose($fTxt);

if($_GET['choice']== "download")
{
	if($_GET['file'] =="")
	{
		telecharger($fileTXT);
	}else
	{
		telecharger($_GET['file']);
	}
}
else if ($_GET['choice']== "consult")
{
	if($_GET['file'] =="")
	{
		header("Location: $fileTXT");
	}else
	{
		header("Location: ".$_GET['file']);
	}
}
	
function telecharger($filename)
{
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.basename($filename));
	header('Content-Transfer-Encoding: text/plain');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Content-Length: ' . filesize($filename));
	ob_clean();
	flush();
	readfile($filename);
}