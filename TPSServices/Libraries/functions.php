<?php

function createFile($txt, $filename) {
    if (file_exists($filename)) {
        unlink($filename);
    }
    //bikin file
    $filename = fopen($filename, a);
    fputs($filename, $txt);
    fclose($filename);
}

function LoadFile($filename) {
    if (file_exists($filename)) {
        if ($FH = fopen($filename, 'r')) {
            $doc = '';
            while (!feof($FH)) {
                $doc = $doc . fgets($FH, 1024);
            }
            fclose($FH);
        } else {
            die("ngga bisa mbuka file ");
        }
    } else {
        die("file " . $filename . " ngga ada");
    }
    return $doc;
}

?>