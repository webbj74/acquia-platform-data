#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$travis = Yaml::parse(file_get_contents(__DIR__ . '/../.travis.yml'));

$errors = array();
$break = "\033[1m" . str_repeat("-", 78) . "\033[0m\n";
foreach ($travis['script'] as $script) {
    $returnVal = null;
    print "\n$break\033[1mRUNNING TEST: $script\033[0m\n$break\n";
    passthru($script, $returnVal);
    if ($returnVal !== 0) {
        $errors[] = array(
            'cmd' => $script,
            'result' => $returnVal,
        );
    }
}

if (count($errors)) {
    print "\n{$break}\033[1mTHERE WERE TEST FAILURES:\033[0m\n\n";
    foreach ($errors as $error) {
        print "\033[1m  - {$error['cmd']} \033[41;37;1m[FAILED]\033[0m\n";
        if (strstr($error['cmd'], 'phpcs')) {
            $error['cmd2'] = preg_replace(
                '/^(.*)phpcs(.*)( --standard=[^ ]+)(.*)( \.\/.*)$/',
                '\1phpcbf\3\5',
                $error['cmd']
            );
            print "\033[32m    HINT: {$error['cmd2']}\033[0m\n";
        }
        print "\n";
    }
    print "{$break}";
    exit(1);
}

print "\n{$break}\033[1mALL TESTS PASSED!\033[0m\n{$break}";
exit(0);
