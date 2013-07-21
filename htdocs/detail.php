<?php
require_once "../MovieThreadFactory.php";

function e($str) {
	echo $str;
}

function getResesHtml($reses) {
	$result = "";
	foreach ($reses as $i => $res) {
		$result .= '<div class="res">';
		$result .= getOneResHtml($res);
		$result .= '</div>';
	}
	return $result;
}

function getOneResHtml($res) {
	$result = "";
	$result .= $res -> index . " : " . $res -> name . " : " . $res -> writeDate -> strDate() . "<br>";
	$result .= "<strong>" . $res -> contents -> raw() . '</strong><br>';

	if (count($res -> recivedAnchorIndexes) > 0) {
		$result .= "<div class=\"subres\">";
		foreach ($res -> recivedAnchorIndexes as $subRes) {
			$result .= getOneResHtml($subRes);
		}
		$result .= "</div>";
	}
	return $result;
}

function getYoutubeMovie($url) {
	$ary = explode("?v=", $url);
	$movieId = $ary[1];
	return '<iframe width="420" height="315" src="//www.youtube.com/embed/' . $movieId . '" frameborder="0" allowfullscreen></iframe>';
}

$datname = $_GET["dat"];
$datContents = trim(file_get_contents("../dat/$datname"));
$factory = new MovieThreadFactory();
$movieThread = $factory -> create($datContents);

$pageTitle = $movieThread -> name();
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bootbusiness | Short description about company">
    <meta name="author" content="Your name">
    <title><?php echo $pageTitle ?> | Go for Brazil</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap responsive -->
    <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
  </head>
  <body>
    <!-- Start: HEADER -->
    <header>
      <!-- Start: Navigation wrapper -->
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a href="index.html" class="brand brand-bootbus">Go for Brazil</a>
            
          </div>
        </div>
      </div>
      <!-- End: Navigation wrapper -->   
    </header>
    <!-- End: HEADER -->
    <!-- Start: Main content -->
    <div class="content">    
      <div class="container">
        <!-- Start: Product description -->
        <airticle class="article">
          <div class="row bottom-space">
            <div class="span12">
              <div class="page-header">
                <h1><br><?php e($pageTitle) ?></h1>
              </div>
            </div>
            <div class="span12 center-align">
            	<?php
            	$urls = $movieThread -> movies();
            	foreach ($urls as $movieUrl) {
					e(getYoutubeMovie($movieUrl));
				} 
            	
            	?>            
            </div>
          </div>
          <div class="row">
          	<div class="span12 center-align">
                  <?php
				e(getResesHtml($movieThread -> resArray()));
                   ?>
           </div>
          </div>
          
        </airticle>
        <!-- End: Product description -->
      </div>
    </div>
    </div>
    <!-- End: Main content -->
    <!-- Start: FOOTER -->
    <!-- End: FOOTER -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/boot-business.js"></script>
  </body>
</html>
