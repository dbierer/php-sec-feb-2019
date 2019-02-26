<?php
/* This is the code file you need to modify */

if (!array_key_exists('name', $_POST) || $_POST['name'] == NULL || $_POST['name'] == '') {
    $isempty = true;
} else {
    // Fix 1: Wash input
    // TODO: Apply limits, warn if exceeded
    $washedName = htmlspecialchars(strip_tags($_POST['name']));
    $html .= "<pre>Hello $washedName, welcome!</pre>";
}
