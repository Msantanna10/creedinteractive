/*! HOMEPAGE !*/
// On page load
$(document).ready(function(){

    // Custom function to retrieve podcasts
    function getPodcasts(page) {

        // If pagination is empty, use 1
        var pagination = (page) ? page : 1;
        var count = 5;
        var podcasts_displayed = count * (pagination - 1); // Existing podcasts on the page to increase number in the floating circle

        // Makes request
        $.getJSON(objVars.site_url+'/wp-json/podcasts/v1/all?count=' + count + '&page=' + pagination, function(result){
            // Check responses separately below...
        })
        .done(function(result) { 

            // SUCCESS

			// If there are podcasts
            if(result.podcasts.length > 0) {

                // Removes existing load more
                $('.podcasts .listing #loadmore').remove();

                // Useful variables
                var total_pages = result.all_pages;
                var current_page = result.current_page;                
                var next_page = result.current_page + 1; 
                var first_request = (current_page == 1) ? true : false;                

                // Add new div for podcasts [Condition to first call only]
                if(first_request) {
                    // Clear main div
                    $('.podcasts .listing').empty();
                    // Custom div to separate podcasts from the load more button
                    $('.podcasts .listing').append('<div class="all"></div>');
                }  

                // Loop
                $.each(result.podcasts, function( index, value ) {
                    var podcast_element = `
                    <div class="single">
                        <div class="number"><span>${first_request ? index + 1 : index + 1 + podcasts_displayed}</span></div>
                        <div class="in">
                            <div class="main">
                                <div id="bg" style="background-image: url('${value.thumbnail_small}')"></div>
                                <div class="body">
                                    <h2>${value.title}</h2>
                                    <p id="by">by <span>${value.publisher}</span></p>
                                    <p id="qty"><span>${value.total_episodes}</span> episodes</p>
                                    <div class="links">
                                        ${value.itunes_id && `<a href="https://podcasts.apple.com/us/podcast/id${value.itunes_id}" target="_blank"><img src="${objVars.theme_url}/src/images/apple.svg" alt="Apple"> Itunes</a>` }
                                        ${value.website && `<a href="${value.website}" target="_blank"><img src="${objVars.theme_url}/src/images/web.png" alt="Web"> Web</a>` }                                        
                                        ${value.rss && `<a href="${value.rss}" target="_blank"><img src="${objVars.theme_url}/src/images/rss.svg" alt="RSS"> RSS</a>` }                                                                                
                                    </div>
                                </div>
                            </div>
                            <div class="desc">
                                <p>${value.description}</p>
                            </div>
                        </div>
                    </div>  
                    `;          
                    
                    $('.podcasts .listing .all').append(podcast_element);
                });

                // Load more button [Condition to first call only]
                if(total_pages > current_page) { 
                    $('.podcasts .listing').append('<span id="loadmore" data-number="'+next_page+'">Load more</span>');
                };

            }

         })
        .fail(function(errorThrown) { 
            // ERROR
            $('.podcasts .listing').html('<p id="error">Make sure you activated the plugin and that there are podcasts.</p>');
            console.log('IMPORTANT: Make sure you activated the plugin and that there are podcasts.');
        })
        .always(function() {
            // ON END (success or error)
            // Removes 'Loading...' and set 'Load more
            $('.podcasts .listing #loadmore').text('Load more');
        });
    }
    // First request on page load
    getPodcasts();

    // Next requests on 'Load more' click
    $('body').on('click', '.podcasts .listing #loadmore', function(){
        $('.podcasts .listing #loadmore').text('Loading...');
        var next_page = $(this).attr('data-number'); // Custom attribute in the button
        getPodcasts(next_page); // Request with the 'next_page' number
    });

});