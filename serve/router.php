<?php
// router.php

// Config variables:
$nest_dir = '/Users/burchell/ubuutil2/skinkworks/data';


// if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
if (preg_match('/\/skink\//', $_SERVER["REQUEST_URI"])) {
    // Serve up some skink content
    // What to do? Four options:
    // (1) Serve the list of skink nests on the system
    if (preg_match('/\/skink\/$/', $_SERVER["REQUEST_URI"])) {
        echo serve_nest_list();
    }
    // (2) Serve the list of skinks in a specific nest
    $matches = array();
    if (preg_match('/\/skink\/([a-zA-Z][^\/]*)\/$/', $_SERVER["REQUEST_URI"], $matches)) {
        echo serve_skink_list($matches[1]);
    }
    // (3) Serve the content of a specific skink
    // (4) Hatch a new skink
} else { 
    echo "<p>Welcome to PHP</p>\n\n\n\n";
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
<p>Click here to hatch a <a href="$nest/hatch">new <i>$nest</i></a> skink</p>
<h2>Skinks in <i>$nest</i></h2>
<p>The skinks in nest <i>$nest</i> are:</p>
<ol>

END;

foreach (get_skink_list($nest) as $skink) {
    $content .= '<li><a href="' . $nest . '/' . $skink . '">' . $skink . '</a></li>';
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
    $skink_dir = $nest_dir . '/' . $nest;
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
?>
