#!/usr/bin/php
<?php
// grubcheck: Check constraints on the "grub" before "feeding" the "skink"
// Return 1 for an error; return 0 for no error
$input = file_get_contents("php://stdin");

$xmltree = simplexml_load_string($input);

// Check that regular expression constrains are met
$results = $xmltree->xpath("//*/*[@fill_regex]");
print_r($results);
foreach ($results as $element) {
    echo $element->getName() . "\n";
    echo "value: " . $element . "\n";
    $regex =  $element->xpath("@fill_regex")[0];
    echo "regex: " . $regex . "\n";
    if (!preg_match($regex, $element)) {
        exit(1);
    }
}
exit(0);
?>
