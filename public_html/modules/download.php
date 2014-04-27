<?php
/*
 * PDFy is more free software. It is licensed under the WTFPL, which
 * allows you to do pretty much anything with it, without having to
 * ask permission. Commercial use is allowed, and no attribution is
 * required. We do politely request that you share your modifications
 * to benefit other developers, but you are under no enforced
 * obligation to do so :)
 * 
 * Please read the accompanying LICENSE document for the full WTFPL
 * licensing text.
 */

if(!isset($_APP)) { die("Unauthorized."); }

try
{
	$document = Document::CreateFromQuery("SELECT * FROM documents WHERE `SlugId` = :SlugId", array("SlugId" => $router->uParameters[1]), 60, true);
}
catch (NotFoundException $e)
{
	http_status_code(404);
	die("404 Not Found");
}

$source_file = "{$cphp_config->storage_path}/$document->sFilename";
$filesize = filesize($source_file);

header("Content-Type: application/pdf");
header("Content-Length: {$filesize}");
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"{$document->uOriginalFilename}\""); 
readfile($source_file);
die();
