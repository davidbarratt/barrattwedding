jQuery(document).ready(function() {
  
  jQuery("#respond_song_list").tokenInput('songs');
  
  var main = jQuery('#photos .carousel.main .slides').bxSlider({
    pager: false,
    easing: 'linear',
    controls: false,
    onSlideNext: function($slideElement, oldIndex, newIndex) {
      next.goToNextSlide();
      prev.goToNextSlide();
    },
    onSlidePrev: function($slideElement, oldIndex, newIndex) {
      next.goToPrevSlide();
      prev.goToPrevSlide();
    }
  });
  
  var prev = jQuery('#photos .carousel.prev .slides').bxSlider({
    startSlide: main.getSlideCount() - 1,
    pager: false,
    controls: false,
    easing: 'linear'
  });
  
  var next = jQuery('#photos .carousel.next .slides').bxSlider({
    startSlide: 1,
    pager: false,
    controls: false,
    easing: 'linear'
  });
  
  jQuery('#photos .carousel.prev').css('cursor', 'pointer').click(function() {
    main.goToPrevSlide();
  });
  
  jQuery('#photos .carousel.next').css('cursor', 'pointer').click(function() {
    main.goToNextSlide();
  });
  

  // Hendle the From Submit
  jQuery('form.rsvp').on('submit' , function(event) {
  
    // Do not Redirect
    event.preventDefault();
    
    // Disable the Submit Button
    jQuery('input[type="submit"]', this).attr('disabled', 'disabled');
    
    // Remove the errors
    jQuery('.error', this).remove();
    
    // Serialzie the data
    var data = jQuery(this).serialize();
    
    // Get the POST url
    var url = jQuery(this).attr('action');
    
    // Set this to a variable
    var element = jQuery(this);
    
    // Submit the Data
    jQuery.post(url, data, function(data) {
      
      // Deal with any errors
      if (data.errors) {
            
        jQuery.each(data.errors, function(index, error) {
          jQuery('#'+error.id).before('<div class="error"><ul><li>'+error.text+'</li></ul></div>');
        });
        
        jQuery.scrollTo('#rsvp');
        
        // Make the submit button work again
        jQuery('input[type="submit"]', element).removeAttr('disabled');
        
        return;
        
      }
      
      // Change the title
      jQuery('#rsvp .title').text(data.title);
      
      // Add the returned HTML
      jQuery(element).before('<div class="body" style="display:none;">'+data.content+'</div>');
      
      // Hide the Form
      jQuery(element).animate({
        opacity: 'hide',
        height: 'hide'
      }, 'slow');
      
      jQuery.scrollTo('#rsvp');
      
      // Show the Form
      jQuery('#rsvp .body').animate({
        opacity: 'show',
        height: 'show'
      }, 'slow');
            
    });
    
    
  });
  
});
