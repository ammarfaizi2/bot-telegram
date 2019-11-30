<?php
require __DIR__ . "/vendor/autoload.php";
use Telegram\Bot\Client;
try {
    $telegram = new Client('1061xxxxx:AAxxxxx');
}
catch(Exception $e) {
    fprintf(STDERR, "%s break :%s\n", $e->getMessage(), $telegram->__getBreakpoints());
    exit(-1);
}
