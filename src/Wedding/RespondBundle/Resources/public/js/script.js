jQuery(document).ready(function() {
  
  jQuery("#respond_song_list").tokenInput('songs');
  
  if (jQuery('#photos').length) {
  
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
    
  }
  
  jQuery('#photos .carousel.prev').css('cursor', 'pointer').click(function() {
    main.goToPrevSlide();
  });
  
  jQuery('#photos .carousel.next').css('cursor', 'pointer').click(function() {
    main.goToNextSlide();
  });
  
  // Get the div that holds the collection of guest
  var collectionHolder = jQuery('form.rsvp .guest .collection');

  // setup an "add a tag" link
  var $addGuestLink = jQuery('<a href="#" class="add-guest-link">Add a Guest</a>');
  var $newLinkLi = jQuery('<div class="add-more"></div>').append($addGuestLink);


  // add the "add a tag" anchor and li to the tags ul
  collectionHolder.append($newLinkLi);

  // count the current form inputs we have (e.g. 2), use that as the new
  // index when inserting a new item (e.g. 2)
  collectionHolder.data('index', collectionHolder.find(':input').length);

  $addGuestLink.on('click', function(e) {
      // prevent the link from creating a "#" on the URL
      e.preventDefault();

      // add a new guest form (see next code block)
      addGuestForm(collectionHolder, $newLinkLi);
  });
  
  collectionHolder.find('div.form').each(function() {
      addGuestFormDeleteLink(jQuery(this));
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


function addGuestForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in a div, before the "Add a Guest" link.
    var $newFormDiv = jQuery('<div class="form"></div>').append('<label class="guest-num"><span class="guest">Guest #<span class="num">' + (index + 1) + '</span></span></label>').append(newForm);
    $newLinkLi.before($newFormDiv);
    addGuestFormDeleteLink($newFormDiv);
    
    updateGuestNumber();
}

function addGuestFormDeleteLink($guestFormDiv) {

    var $removeFormA = $('<a href="#" class="remove">remove</a>');
    jQuery('label.guest-num', $guestFormDiv).append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $guestFormDiv.remove();
        
        updateGuestNumber();
    });
}

function updateGuestNumber() {
 
 jQuery('label.guest-num .num').each(function(index, element) {
  
  jQuery(element).html(index+1);
  
 });
  
}
