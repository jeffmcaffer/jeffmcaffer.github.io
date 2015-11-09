<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /><!-- leave this for stats -->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="shortcut icon" href="/favicon.ico" >
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>  
<?php wp_head(); ?>
</head>
<body>
<div id="header-padding">
</div>
<a href="<?php echo get_option('home'); ?>/">

<?php
$dir=opendir("/home/codaca/sites/mcaffer.com/wp-content/themes/book/images/header/");
$i=0; 
while($imgfile=readdir($dir)) { 
     if ($imgfile != "." && $imgfile!="..") { 
        $imgarray[$i]=$imgfile; 
        $i++; 
     } 
} 
closedir($dir); 

$rand=rand(0,count($imgarray)-1); 
if($rand >= 0) { 
    echo '<div id="header" style="background:transparent url(http://mcaffer.com/wp-content/themes/book/images/header/'.$imgarray[$rand].') no-repeat center bottom;">'; 
} 
?>

	<div id="header-left">
	</div>
        <div id="header-right">
        </div>	
</div>
                </a>
<!--
<div id="menu">
	<ul>
	    <li <?php if(is_home()){echo 'class="current_page_item"';}?>>
		<?php wp_list_pages('title_li=&depth=1&sort_column=menu_order');?>
		<li id="rss"><a title="RSS Feed of Posts" href="<?php bloginfo('rss2_url'); ?>"></a></li>
	</ul>
	</div>
 end header -->

<div id="wrap">
