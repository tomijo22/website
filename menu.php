<?php
include 'config.beta.php';

$json_root = array();
$json_root['main'] = array();
$json_root['articles'] = array();
$json_root['projects'] = array();

$json_root['main']['last'] = $config['root_addr'];
$json_root['main']['articles'] = '#';
$json_root['main']['projets'] = '#';
$json_root['main']['whoami'] = $config['root_addr'] . '?p=whoami';
$json_root['main']['twitter'] = 'https://twitter.com/darkgallium';
$json_root['main']['github'] = 'https://github.com/darkgallium';

$json_root['articles']['politique'] = $config['root_addr'] . 'list.php?c=1';
$json_root['articles']['tribunes'] = $config['root_addr'] . 'list.php?c=2';
$json_root['articles']['dossiers'] = $config['root_addr'] . 'list.php?c=3';
$json_root['articles']['tutoriels'] = $config['root_addr'] . 'list.php?c=4';
$json_root['articles']['testing'] = $config['root_addr'] . 'list.php?c=5';
$json_root['articles']['inclassables'] = $config['root_addr'] . 'list.php?c=6';
$json_root['articles']['retour'] = '#';

header('Content-type: application/json');
printf(json_encode($json_root));

?>
