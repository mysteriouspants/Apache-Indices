<!DOCTYPE html>
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
    $titleformat = "cdn.fsdev.net%DIR"; // will create cdn.fsdev.net/dir

    // logoimageurl, logolink
    //   If these are provided, the provided logo URL will be inserted as an <img> tag
    //   at the top of the directory listing.  If logolink is non-empty, the logo image
    //   will link to the provided URL.
    // for instance:
    //  $logoimageurl = "/images/titlebar-small.gif";
    //  $logolink     = "http://antisleep.com/";
    $logoimageurl = "http://cdn.fsdev.net/www-web-common/fsdev/fsdevlogo_full_black.png";
    $logolink     = "http://cdn.fsdev.net/";

    $bootstrap_css_url = "/www-web-common/twitter-bootstrap-2.0.4/css/bootstrap.min.css";
    $bootstrap_js_url  = "/www-web-common/twitter-bootstrap-2.0.4/js/bootstrap.min.js";
    $jquery_url = "/www-web-common/jquery-1.7.2.min.js";
    $indices_js_url = "/indices/script.js"; // all my hackery to style the table

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
    }
    $pathtext = $uri;

    // some additional breadcrumbs logic
    $splitpath = explode('/', $pathtext); // split on / to get individual dirs
    $splitpath[0] = '/'; // ensure that the first dir is / and not null
    $spliturls = array(); // this next bit creates a series of URLs based on the dirs
    for ($i=0; $i<count($splitpath); $i++) { // so $splitpath is the displayable name, and
      $part = $splitpath[0]; // $spliturls is the links
      for ($j=1; $j<=$i; $j++) { // for each add the parent dirs to the url
        $part .= $splitpath[$j].'/';
      }
      if (count($splitpath)>0) { // kill the trailing slash because I don't like it
        $part = rtrim($part, '/');
      }
      $spliturls[$i] = $part; // and there you go, we have yer URL
    }
    
?>
<html lang="en-us">
<head>
    <title><?=$titletext?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- le styles -->
    <link rel="stylesheet" href="<?=$bootstrap_css_url?>">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      #indices-table tbody tr td:first-child {
        text-align: center;
      }
      .header-stuff {
        padding-bottom: 18px;
      }
    </style>

    <!-- le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- le javascript, placed at beginning of document because fast load doesn't matter to me for this page -->
    <script type="text/javascript" src="<?=$jquery_url?>"></script>
    <script type="text/javascript" src="<?=$bootstrap_js_url?>"></script>
    <script type="text/javascript" src="<?=$indices_js_url?>"></script>
</head>

<body>
  <div class="container-fluid">
    <div class="row-fluid header-stuff">
      <div class="span1"> &nbsp; </div>
      <div class="span4">
        <?=$logohtml?>
      </div>
      <div class="span6">
        <?=$readmetext?>
      </div>
      <div class="span1"> &nbsp; </div>
    </div> <!-- .row-fluid -->
    <div class="row-fluid">
      <div class="span1"> &nbsp; </div>
      <div class="span10">
        <ul class="breadcrumb"> <!-- le breadcrumb navigation -->
          <li> <!-- le root/home directory -->
            <a href="/"><i class="icon-home"></i></a> 
            <span class="divider">/</span>
          </li>
          <?php for ($i=1; $i<count($splitpath) && $i<count($spliturls); $i++) { ?>
            <li>
              <a href="<?=$spliturls[$i]?>"><?=$splitpath[$i]?></a>
              <?php if ($i < count($splitpath)-1 && $i < count($spliturls)-1) { ?>
                <span class="divider">/</span>
              <?php } ?>
            </li>
          <?php } ?>
        </ul>
      </div> <!-- .span10 -->
      <div class="span1"> &nbsp; </div>
    </div> <!-- .row-fluid -->
    <div class="row-fluid">
      <div class="span1"> &nbsp; </div>
      <div class="span10" id="indices-content">
