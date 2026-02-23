<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

if (!is_writable(__DIR__ . '/../logs/error.log')) {
die("Le fichier error.log n'est pas accessible en écriture.");
}