<?php

//TODO: Actually download the HTML from the live US site.
//TODO: Clean up code

require __DIR__ . '/vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

$html = HtmlDomParser::file_get_html('sources/us-mods.html');

$mods = $html->find('td[bgcolor=#000000]');

for($i=0; $i<count($mods);)
{	
	$requiredMods[$i] = [
		'name' => trim($mods[$i]->parent()->children(2)->first_child()->plaintext),
		'url' => substr($mods[$i]->parent()->children(2)->first_child()->first_child()->next_sibling()->href, 0, strrpos($mods[$i]->parent()->children(2)->first_child()->first_child()->next_sibling()->href, '/')),
		'author' => trim(str_replace(' by: ', '', $mods[$i]->parent()->children(2)->first_child()->next_sibling()->plaintext))
	]; 
    $i++; 
}

echo json_encode($requiredMods);
