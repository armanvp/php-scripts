<?php

function file_stat($file)
{
        exec("stat $file", $output);
        return $output;
}

// Check File List
if (count($argv) < 2) {
        die("Specify file list".PHP_EOL);
}

// Read File List
$handle = fopen($argv[1], "r");
if ($handle) {
        while (($line = fgets($handle)) !== false) {
                $output = file_stat($line);
                //print_r($output);
                echo $output[5] . " > " . $output[6] . " > " . $output[0] . PHP_EOL;
        }
        fclose($handle);
} else {
        die("Invalid file".PHP_EOL);
}
