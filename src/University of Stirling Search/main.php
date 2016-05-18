<?php

//Requires Workflows by David Ferguson (@jdfwarrior)
require_once('workflows.php');
$w = new Workflows();

if (!isset($query)) {
	$query = $argv[1];
}

$results = $w->request("https://www.stir.ac.uk/s/search.json?collection=stirling&query=".urlencode($query));
$container = json_decode($results);

$total   = $container->response->resultPacket->resultsSummary->totalMatching;
$results = $container->response->resultPacket->results;

if($total > 0) {

	foreach ($results as $result) {
		$w->result(
			null,
			$result->liveUrl,
			$result->title,
			$result->summary,
			'icon.png',
			'yes' );
	}
	echo $w->toxml();
  
} else {
	$w->result(
		null,
		"https://www.stir.ac.uk/s/search.html?collection=stirling&query=".urlencode($query),
		$query,
		"Continue search on www.stir.ac.uk",
		'icon.png',
		'yes' );
	echo $w->toxml();
	return;
}

?>