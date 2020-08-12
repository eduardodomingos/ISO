(function($) {
    $(document).ready(function(){

        var dom = {
            $window: $(window),
            $document: $(document),
            $body: $('body')
        };

        /*
         * Article share buttons.
         */
        if(dom.$body.hasClass('single-post')) {
            var $share = $('.share-post'); // cache share
            if ( $share.length ) {
                // Facebook
                $share.find('.facebook a').on('click', function(e){
                    e.preventDefault();
                    var href = $(this).attr('href');
                    window.open(href, "Facebook", "toolbar=0,status=0,width=548,height=325");
                });

                // Twitter
                $share.find('.twitter a').on('click', function(e){
                    e.preventDefault();
                    var href = $(this).attr('href');
                    window.open(href, "Twitter", "toolbar=0,status=0,width=548,height=325");
                });
            }
        }
    });
}(jQuery));