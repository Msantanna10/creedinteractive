<?php
################### META TAGS
global $wp;
$url = home_url( $wp->request );

// Default values that can be changed based on the rules below
$image = get_theme_file_uri() . '/src/images/ogimage.png';
$title = get_bloginfo('name');
$content = 'Code Challenge';

if(is_page()) {
  // Creates titles for pages
  $title = get_the_title() . ' | ' . get_bloginfo('name');
}
if(is_home() || is_front_page()) {
  // Creates title for homepage
  $title = get_bloginfo('name') . ' | ' . get_bloginfo('description');
}

// ogImage width and height (only if it's a live site because it may break on localhost)
if(!isLocalhost()) { list($width, $height) = getimagesize($image); }
?>

<!-- Social media -->    
<meta property="og:locale" content="en_US" />
<meta property="og:image" content="<?php echo $image; ?>">
<meta property="og:image:secure_url" content="<?php echo $image; ?>" />
<meta property="og:title" content="<?php echo $title; ?>">
<meta property="og:description" content="<?php echo $content; ?>">
<meta property="og:url" content="<?php echo $url; ?>">
<?php if(!isLocalhost()) { ?>
<meta property="og:image:width" content="<?php echo $width; ?>">
<meta property="og:image:height" content="<?php echo $height; ?>">
<?php } ?>

<title><?php echo $title; ?></title>