<?php 

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//TODO: Actually download the HTML from the live US site.
//TODO: Clean up code
//TODO: Save the JSON to a file

require __DIR__ . '/vendor/autoload.php';
use Sunra\PhpSimple\HtmlDomParser;

$html = HtmlDomParser::file_get_html('sources/us-mods.html');

$mods = $html->find('td[id=Toggle Color]'); //Get every single mod
//$mods = $html->find('td[bgcolor=#000000]'); //Get required mods
//$mods = $html->find('td[bgcolor=#E4A4FF]'); //Get optional mods

try {
	for($i=0; $i<count($mods);)
	{	
		$requiredMods[$i] = [
			'name' => trim($mods[$i]->parent()->children(2)->first_child()->plaintext),
			'url' => substr($mods[$i]->parent()->children(2)->first_child()->first_child()->next_sibling()->href, 0, strrpos($mods[$i]->parent()->children(2)->first_child()->first_child()->next_sibling()->href, '/')),
			'author' => trim(str_replace(' by: ', '', $mods[$i]->parent()->children(2)->first_child()->next_sibling()->plaintext))
		]; 
		$i++; 
	}
} catch(Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}
echo json_encode($requiredMods);
