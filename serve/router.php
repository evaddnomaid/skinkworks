<?php
// router.php

// Config variables:
$nest_dir = '/Users/burchell/ubuutil2/skinkworks/data';

// Serve up some skink content
// What to do? Four options:
// (1) Serve the list of skink nests on the system
if (preg_match('/\/skink\/$/', $_SERVER["REQUEST_URI"])) {
    echo serve_nest_list();
    exit;
}
// (2) Serve the list of skinks in a specific nest
$matches = array();
if (preg_match('/\/skink\/([a-zA-Z][^\/]*)\/$/', $_SERVER["REQUEST_URI"], $matches)) {
    echo serve_skink_list($matches[1]);
    exit;
}
// (3) Hatch a new skink
$matches = array();
if (preg_match('/\/skink\/([a-zA-Z][^\/]*)\/hatch$/', $_SERVER["REQUEST_URI"], $matches)) {
    echo hatch_skink($matches[1]);
    exit;
}
// (4) Serve the content of a specific skink
$matches = array();
if (preg_match('/\/skink\/([a-zA-Z][^\/]*)\/([a-zA-Z][^\/]*).xml$/', $_SERVER["REQUEST_URI"], $matches)) {
    echo display_skink($matches[1], $matches[2]);
    exit;
}

// (5) Feed a skink
// TODO

// -=-=-= End of route handling =-=-=-
    echo "<p>Welcome to PHP</p>\n\n\n\n";

function hatch_skink($skink) {
    global $nest_dir;
    // For the sake of laziness, let's give skinks a timestamp for a unique name
    $hatchling_name = $skink . date('YmdGis') . '.xml';
    touch($nest_dir . '/' . $skink . '/nest/' . $hatchling_name);
    // copy($
}

function serve_skink_list($nest) {
    // Get the list of skinks in a given nest
    $content = <<<"END"
<html>
<head>
<title>Skink Nest $nest</title>
</head>
<body>
<h1>Skink Nest $nest</h1>
<h2>Hatch a new <i>$nest</i> skink</h2>
<p>Click here to hatch a <a href="hatch">new <i>$nest</i></a> skink</p>
<h2>Skinks in <i>$nest</i></h2>
<p>The skinks in nest <i>$nest</i> are:</p>
<ol>

END;

foreach (get_skink_list($nest) as $skink) {
    $content .= '<li><a href="' . $skink . '">' . $skink . '</a></li>';
}

    $content .= <<<'END'
</ol>
</body>
</html>

END;

    return $content;
}

function serve_nest_list() {
    // Get the list of nests by looking to 
    // Serve up the results
    $content = <<<'END'
<html>
<head>
<title>List of Skink Nests</title>
</head>
<body>
<h1>List of Skink Nests</h1>
<p>Nests are:</p>
<ol>

END;

foreach (get_nest_list() as $nest) {
    $content .= '<li><a href="' . $nest . '/">' . $nest . '</a></li>';
}

    $content .= <<<'END'
</ol>
</body>
</html>


END;

    return $content;
}

function get_nest_list() {
    global $nest_dir;
    error_log("Opening dir " . $nest_dir);
    if ($handle = opendir($nest_dir)) {
        $nest_list = array();
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '..') { continue; }
            if ($entry == '.')  { continue; }
            $nest_list[] = $entry;
        }
        closedir($handle);
    }
    return $nest_list;
}

function get_skink_list($nest) {
    global $nest_dir;
    $skink_dir = $nest_dir . '/' . $nest . '/nest';
    error_log("Opening dir " . $skink_dir);
    if ($handle = opendir($skink_dir)) {
        $skink_list = array();
        while (false !== ($entry = readdir($handle))) {
            if ($entry == '..') { continue; }
            if ($entry == '.')  { continue; }
            $skink_list[] = $entry;
        }
        closedir($handle);
    }
    return $skink_list;
}

function display_skink($nest, $skink) {
    global $nest_dir;
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("$nest_dir/$nest/nest/$skink" . '.xml');
    $xslDoc = new DOMDocument();
    $xslDoc->load($nest_dir . '/' . $nest . '/' . $nest . '_display.xsl');
    $proc = new XSLTProcessor();
    $proc->importStylesheet($xslDoc);
    return $proc->transformToXML($xmlDoc);
}

?>
