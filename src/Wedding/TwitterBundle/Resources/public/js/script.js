jQuery(document).ready(function() {
  
  
  jQuery.getJSON('tweets', function(data) {
  
    jQuery.each(data.tweets, function(index, tweet) {
      jQuery('.tweets').append(tweet);
    });
    
    var tweets = jQuery('.tweets').bxSlider({
      pager: true,
    });
  
  });
  
});