<?php 
$controller = $this->controller;
 /* Generic helper functions */
function set_if_active($page, $controller) {
	if( $page == strtolower( $controller ) ) {
		return ' class="active"';
	}
	return '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>CookBook - by robert lemon</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
	
	<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
</head>
<body>


<?php if( isset($this->errors) ): ?>
<!-- DEBUG -->
<div class="hero-unit">
	<h1>Errors <small>Debugging</small></h1>
<pre>
<?php print_r($this->errors); ?>
</pre>
</div>
<!-- REMOVE AFTER NOTIFICATIONS -->
<?php endif; ?>


    <div class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <a class="brand" href="#">COOKBOOK</a>
                <ul class="nav">
                    <li <?php echo set_if_active('dashboard', $controller); ?>>
                    <a href="/dashboard">Dashboard</a>
                    </li>
                    <li <?php echo set_if_active('collection', $controller); ?>>
                    <a href="/collection">Collection</a>
                    </li>
                    <li <?php echo set_if_active('explore', $controller); ?>>
                    <a href="/explore">Explore</a>
                    </li>
                </ul>
                <ul class="nav pull-right">
                    <li>
                    <form class="navbar-search pull-left">
                        <input type="text" class="search-query" placeholder="Search">
                    </form>
                    </li>
                    <li class="divider-vertical"></li>
                    <li>
                    <a href="/auth/logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
