<?php
############# PAGINATION
// https://codex.wordpress.org/Pagination
function pagination($pages = '', $paged = '', $range = 2) {

     $showitems = ($range * 2) + 1;  
 
     if(empty($paged)) $paged = 1;
 
     if($pages == '') {
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages) { $pages = 1; }
     }   
 
     if(1 != $pages) {  

        echo '<div class="pagination">';

        // ARROW - PREVIOUS        
        if($paged > 1 && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged - 1).'" id="prev" class="arrow inactive"><img src="'.get_bloginfo('template_url').'/src/images/arrow-left.svg" alt="Arrow"></span>';
        if($paged > 1) echo '<span id="prev" class="arrow inactive" data-number="'.$prev.'"><img src="'.get_bloginfo('template_url').'/src/images/arrow-left.svg" alt="Arrow"></span>';

        // SHOWS PAGE NUMBERS
        for ($i=1; $i <= $pages; $i++) {
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
               echo ($paged == $i) ? '<span class="current">'.$i.'</span>' : '<a href="'.get_pagenum_link($i).'" class="inactive">'.$i.'</a>';
            }
        }

        // ARROW - NEXT    
        if ($paged < $pages && $showitems < $pages) { echo '<a href="'.get_pagenum_link($paged + 1).'" id="next" class="arrow inactive"><img src="'.get_bloginfo('template_url').'/src/images/arrow-right.svg" alt="Arrow"></span>'; }

        echo "</div>";
    }
}
?>