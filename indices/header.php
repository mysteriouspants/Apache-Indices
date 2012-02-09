<!DOCTYPE html PUBLIC>
<?php
    //=======================================================================
    // A few configuration values.  Change these as you see fit.
    //=======================================================================

    // show_readme
    //   If true, the contents of an (optional) readme.html file will appear before
    //   the directory listing.  This file should be an HTML snippet; no head/body/etc
    //   tags.  You can do paragraph tags or whatever.
    $show_readme = true;

    // titleformat
    //   How to format the <title> tag.  %DIR is replaced with the directory path.
    // for instance:
    //   $titleformat = "antisleep: %DIR";
    $titleformat = "yourstuff: %DIR";

    // logoimageurl, logolink
    //   If these are provided, the provided logo URL will be inserted as an <img> tag
    //   at the top of the directory listing.  If logolink is non-empty, the logo image
    //   will link to the provided URL.
    // for instance:
    //  $logoimageurl = "/images/titlebar-small.gif";
    //  $logolink     = "http://antisleep.com/";
    $logoimageurl = "http://cdn.fsdev.net/fsdevlogo_full_black.png";
    $logolink     = "http://cdn.fsdev.net/";
    
    // set these to where you keep your jquery & where the indices dir is
    $jqueryurl = "/jquery-1.7.1.min.js";
    $indiceswebroot = '/indices';

    //=======================================================================
    // (end of config)
    //=======================================================================

    $uri = urldecode($_SERVER['REQUEST_URI']);
    $uri = preg_replace("/\/ *$/", "", $uri);
    $uri = preg_replace("/\?.*$/", "", $uri);

    $titletext = str_replace("%DIR", $uri, $titleformat);

    $logohtml = "";
    if ($logoimageurl != "") {
        $logohtml = "<img src='" . $logoimageurl . "' alt=''/>";

        if ($logolink != "") {
            $logohtml = "<a href='" . $logolink . "'>" . $logohtml . "</a>";
        }

        $logohtml = "<div class='logohtml'>$logohtml</div>";
    }

    // this is hacky, but in almost every situation there's no real harm.
    // it just might fail if you're doing something funky with directory mappings.
    $readmetext = "";
    $pathtext = "";
    $readmefile = $_SERVER["DOCUMENT_ROOT"] . $uri . "/readme.html";
    if ($show_readme && file_exists($readmefile)) {
        $readmetext = "<div class='readme'>" . file_get_contents($readmefile) . "</div>";
    } else {
        // If no readme, show URI.
	$pathtext = "<div class='path'>$uri</div>";
    }
?>
<html lang="en-us">
<head>
    <title><?=$titletext?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="screen, projection" href="<?=$indiceswebroot?>/style-js.css">
    <script type="text/javascript" src="<?=$jqueryurl?>"></script>
    <script type="text/javascript" src="<?=$indiceswebroot?>/script.js"></script>
</head>

<body>
    <div id="pagecontainer" style="display: none;">

        <div class='header'>
            <div class='header-image'>
              <?=$logohtml?>
            </div>
            <?=$readmetext?>
        </div>

        <br clear="both"/>
        <p><?=$pathtext?></p>