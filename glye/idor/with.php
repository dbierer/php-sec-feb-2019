<?php
/* This is the code file you need to modify */

// Fix 1: No direct object reference. (Static table for simplicity.)
// This is in effect also a whitelist.
// MD5 (bad!) but NOT of the image name, so cracking it doesn't help the attacker
$resources = [
    'acbd18db4cc2f85cedef654fccc4a4d8' => 'img00011.png',
    '37b51d194a7513e45b56f6524f2d51f2' => 'img00012.png',
];

// Fix 2: Don't show specific errors
$html = "Invalid resource";

// Fix 3: TODO: ACL
/*
$acl = new Acl();
$user = new Role('User');
$siteFrontend = new Resource('SiteFrontend');

$view = new Rule('View');
$view->setRole($user);
$view->setResource(new Resource('Image'));
$view->setAction(true);

$acl->addRule($user, $siteFrontend, $view, true);
*/

if(isset($_GET['img'])) {
    $resourceID = $_GET['img'];
    if(isset($resources[$resourceID])) {
	$image = $resources[$resourceID];
	$html = "<img src='vulnerabilities/idor/source/img/$image'>";
    }
}
