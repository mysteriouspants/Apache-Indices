<!DOCTYPE html>
<?php
    //=======================================================================
    // A few configuration values.  Change these as you see fit.
    //=======================================================================

    // use_js
    //   If true, does a DHTML thing to cruise the DOM of Apache's
    //   HTML output, injecting useful class names throughout.
    //   This allows for a simple CSS file.
    //     + looks better (directories only bold, no trailing slash on dirs, etc)
    //     + works on IE
    //     - you'll get less styling if you have javascript disabled
    //
    //   If false, uses a more sophisticated CSS (some CSS2 stuff)
    //   to style Apache's output.
    //     + no javascript, which makes it less delicate
    //     - looks a bit worse
    //     - IE6 doesn't do CSS2, so you'll miss out on some styling, in particular
    //       hidden "description" column and "parent directory" row
    $use_js = true;

    // show_readme
    //   If true, the contents of an (optional) readme.html file will appear before
    //   the directory listing.  This file should be an HTML snippet; no head/body/etc
    //   tags.  You can do paragraph tags or whatever.
    $show_readme = true;

    // titleformat
    //   How to format the <title> tag.  %DIR is replaced with the directory path.
    // for instance:
    //   $titleformat = "antisleep: %DIR";
    $titleformat = "cdn.fsdev.net%DIR";

    // logoimageurl, logolink
    //   If these are provided, the provided logo URL will be inserted as an <img> tag
    //   at the top of the directory listing.  If logolink is non-empty, the logo image
    //   will link to the provided URL.
    // for instance:
    //  $logoimageurl = "/images/titlebar-small.gif";
    //  $logolink     = "http://antisleep.com/";
    $logoimageurl = "http://cdn.fsdev.net/fsdevlogo_full_black.png";
    $logolink     = "http://cdn.fsdev.net/";

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

	    $pathtext = $uri;
    }
?>
<html lang="en-us">
<head>
    <title><?=$titletext?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- le styles -->
    <link rel="stylesheet" href="/www-web-common/twitter-bootstrap-2.0.4/css/bootstrap.min.css">
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
    <script type="text/javascript" src="/www-web-common/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="/www-web-common/twitter-bootstrap-2.0.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/indices/script.js"></script>
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
        <?php
          $splitpath = explode('/', $pathtext);
          $splitpath[0] = '/';
          $spliturls = array();
          for ($i=0; $i<count($splitpath); $i++) {
            $part = $splitpath[0];
            for ($j=1; $j<=$i; $j++) {
              $part .= $splitpath[$j].'/';
            }
            if (count($splitpath)>0) {
              $part = rtrim($part, '/');
            }
            $spliturls[$i] = $part;
          }
        ?>
        <ul class="breadcrumb">
          <li>
            <a href="/"><i class="icon-home"></i></a>
            <span class="separator">/</span>
          </li>
          <?php for ($i=1; $i<count($splitpath) && $i<count($spliturls); $i++) { ?>
            <li>
              <a href="<?=$spliturls[$i]?>"><?=$splitpath[$i]?></a>
              <?php if ($i < count($splitpath) && $i < count($spliturls)) { ?>
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
