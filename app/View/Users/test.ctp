
<div id="flickr">

</div>




<script type="text/javascript" src="/js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/load-style.css" />
<script type ="text/javascript">
    var loading = true;
    
    
    function loadFlickr() {
        var url = "<?php echo Router::url(array('controller' => 'tweets', 'action' => 'test')); ?>";
        
        $.getJSON(url, function(data) {
            //console.log(data);
            //console.log(data.length);            
            for(var i = 0; i<=data.length; i++){ 
               
                var tweet = data[i].Tweet.description;
                var user = data[i].User.username;
                $.each(data[i], function(i, v) {
                $("#flickr").append("<div class='flickr_results'><p>"+user+"</p>"+tweet+"<p></div>");
                });
            }
           
            loading = false;
            $(".loading").remove();
    
        });
        
    }
    
    $(function() {
        // load initial photos
        loadFlickr();
   
        // scroll event of the main div
        $(window).scroll(function() {
   loading = false;
             //get the max and current scroll
            var curScroll = $(this)[0].scrollTop;
            var maxScroll = $(this)[0].scrollHight;
   console.log(curScroll);
    console.log(maxScroll-1800);
            // are we at the bottom?
            if( (curScroll == maxScroll) && loading == false) {
    //alert('a');
               // when you start, set loading
                loading = true;
   
                // add the loading box
                $("#flickr").append("<div class='loading'>No more tweets to load</div>");
    
                // scroll to the bottom of the div
                $(this)[0].scrollTop = $(this)[0].scrollHeight - $(this).height();
     
                // load more photos
                loadFlickr();
            } 
        });  
        loading = false;
   

        
    });

</script>
