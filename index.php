<?php

/**
 * Container for Auto deployment script for demo site
 *
 * PHP Version 7
 *
 * @category  Tool
 * @package   DemoAutoDeploy
 * @author    Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @copyright 2017 Matthew "Juniper" Barlett <emeraldinspirations@gmail.com>
 * @license   MIT LICENSE
 * @version   GIT: $Id$
 * @link      https://github.com/emeraldinspirations/tool-autodeploy
 *
 * @link https://gist.github.com/oodavid/1809044
 * @link http://isometriks.com/verify-github-webhooks-with-php
 */

// Sets $Secret
require 'secret.local.php';

$Headers = getallheaders();
$HubSignature = $Headers['X-Hub-Signature'];

// Split signature into algorithm and hash
list($Algo, $Hash) = explode('=', $HubSignature, 2);

// Get payload
$Payload = file_get_contents('php://input');

// Calculate hash based on payload and the secret
$PayloadHash = hash_hmac($Algo, $Payload, $Secret);

// Check if hashes are equivalent
if ($Hash !== $PayloadHash) {
    // Kill the script or do something else here.
    die('Version: ' . trim(exec('git describe --tags')));
}

$DemoDirectory = dir('..');

while (false !== ($Entry = $DemoDirectory->read())) {

    if (in_array(
        $Entry,
        [
            '.',
            '..',
            'index.php',
        ]
    )
    ) {
        continue;
    }

    $Results[$Entry] = exec(
        'git -C '
        . $DemoDirectory->path
        . DIRECTORY_SEPARATOR
        . $Entry
        . ' pull --verify-signatures --tags'
    );

}

print_r($Results);
