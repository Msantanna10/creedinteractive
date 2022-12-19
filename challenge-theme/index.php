<?php
/* Template Name: Homepage */
get_header();
?>

<div class="header">
    <div class="container">
        <div class="content">
            <h1><span>Top 5</span> <span id="gradient">Web Design</span> <span>Podcasts</span></h1>
            <img id="oval" src="<?php echo bloginfo('template_url'); ?>/src/images/oval.svg" alt="Oval shape">
            <img id="triangle" src="<?php echo bloginfo('template_url'); ?>/src/images/triangle.svg" alt="Triangle shape">
        </div>
    </div>
</div>

<div class="podcasts">
    <div class="container">
        <div class="content">
            <div class="listing">
                <!-- POSTCASTS WILL REPLACE THE LOADING ANIMATION -->     
                <div class="loading">
                    <div class="load-wrapp">
                        <div class="load">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                        </div>
                    </div>
                </div>                          
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>