// Copyright 2007 Google Inc.
// All Rights Reserved.

(function($) {
  /**
   * The FauxSelect function takes a jQuery based selector (i.e. css) and
   * modifies the element pointed to which it points. When clicked on, the
   * target element will produce a select box containing the supplied data.
   *
   * The appearing select box will be sized to the number of supplied elements
   * if that number is less than six, six or optionally a number supplied as
   * opt_size.
   *
   * When the selected element is chosen, a change event will fire along with
   * the optional opt_onSelect function. If the function is supplied, it has
   * the signature function(event, targetTitle, option) where event is the 
   * standard DOM event object, the targetTitle is a jQuery wrapped <span>
   * containing the original contents of the target element specified in 
   * attachTo and finally the newly selected <option> element (not jQuery
   * wrapped).
   *
   * Mousing out of or blurring the focus of the select box will cause a 400ms
   * timeout to begin after which the box will close on it's own. Mousing back
   * into the select will cancel this timer.
   *
   * Finally, the created jQuery wrapped <select> element is returned after
   * the call to FauxSelect. 
   *
   * Other items of note are: 
   *   • <select> elements created by this function  have the "fauxSelect" 
   *     class name. 
   *   • If the supplied attachTo element is an <a> element with an href 
   *     attribute, a click event is bound that prevents the target from being 
   *     reached. 
   *   • A <span> is created to contain the target element's contents and is
   *     subsequently referred to as the targetTitle element. Any text
   *     decoration applied to the target elment is switched to being applied 
   *     to the targetTitle elment. This is to prevent any underlining of the
   *     injected down arrow element.
   *   • A down arrow element is appended to the child list of the target
   *     element to indicate this target now functions as a drop down list.
   *   • Rather than supplying two to four parameters, a single object 
   *     containing like named properties can be supplied as a single
   *     parameter; for example:
   *       FauxSelect({
   *         attachTo: '.sample',
   *         data: [
   *           {innerHTML:'Option One',value:1},
   *           {innerHTML:'Option Two',value:2}
   *         ],
   *         opt_onSelect: function(event,jTitle,option) {
   *           jTitle.html(option.text);
   *         },
   *         opt_size: 5
   *       });
   *
   * Published Events:
   *   • onShow: This method fires everytime the select element is made
   *     visible, after all the default processing has occurred. The signature
   *     is function(domEvent, select) where select is the popup <select>
   *     element wrapped in a jQuery object.
   *
   *   • onHide: This method fires everytime the select element is hidden
   *     after all the default processing has occurred. The signature
   *     is function(domEvent, select) where select is the popup <select>
   *     element wrapped in a jQuery object.
   *
   *   • optionSelected: This method fires everytime a option within the 
   *     the select element is chosen. It has the method signature of
   *     function(domEvent, targetTitle, option) where event is the standard  
   *     event object, the targetTitle is a jQuery wrapped <span> containing 
   *     the original contents of the target element specified in attachTo and 
   *     finally the newly selected <option> element (not jQuery wrapped).
   *
   * @param {String|Element} attachTo a jQuery selector parameter that denotes
   *     which element will become the trigger for showing and hiding the new
   *     <select> element.
   * @param {Array<Object>} data an Array of Objects that contains at least an 
   *     innerHTML property and one additional property for each attribute 
   *     that is to be applied to the generated <option>. For example:
   *       {innerHTML:'Sample Option','class':'data',id:'option1'}
   * @param {Function} opt_onSelect an optional function with the signature of
   *     function(event, targetTitle, option) where event is the standard DOM 
   *     event object, the targetTitle is a jQuery wrapped <span> containing 
   *     the original contents of the target element specified in attachTo and 
   *     finally the newly selected <option> element (not jQuery wrapped).
   * @param {Number} opt_size an alternate minimum value of displayed items in
   *     the select list that pops up. If this number is supplied, the true 
   *     minimum number of elements is the number of data items or the supplied
   *     number whichever is less. In the rare case where you want a minimum
   *     number regardless of data count, make the following call on the
   *     returned value of FauxSelect:
   *       FauxSelect(...).attr('size', <hard-coded-minimum-number>);
   * @param {String} opt_align one of either 'left' or 'right' indicating which
   *     side of the attachTo element the select box should align with. Note
   *     that if sufficient room isn't provided the alignment will swap 
   *     automatically.   
   * @return {Object} the jQuery wrapped <select> object that pops up when
   *     the attachTo object is clicked.
   */
  window['FauxSelect'] = function(attachTo, data, opt_onSelect, opt_size, 
    opt_align) {
    // Normalize arguments in the case that a single object literal is passed
    // in containing all the constructor parameters (i.e. {attachTo:..,etc..})
    if (arguments.length==1 && 'attachTo' in arguments[0]) {
      var options = arguments[0];
      attachTo = options.attachTo;
      data = options.data;
      opt_onSelect = options.opt_onSelect;
      opt_size = options.opt_size; 
      opt_align = options.opt_align;     
    }    
    
    var target = jQuery(attachTo);
    var select = jQuery('<select class="fauxSelect">');
    
    if(opt_align) {
      opt_align = jQuery.trim(opt_align.toString().toLowerCase());
    }
    else {
      opt_align = 'right';
    }

    // Create the down arrow element.
    var downArrow = jQuery('<span>&nbsp;&#9660;</span>').css({
      verticalAlign: 'middle',
      textDecoration: 'none',
      fontFamily: 'arial, sans-serif',
      fontSize: '11px'
    });

    // Move the contents of the attachTo target element into a newly created
    // target_title <span>.
    var uniqueId = 'title' + new Date().getTime();
    var target_title = jQuery('<span></span>').css('textDecoration', target.
      css('textDecoration')).addClass(uniqueId);

    for (var i = 0, nodes = target.get(0).childNodes; i < nodes.length; 
      i++) {
        target_title.append(nodes[i]);
    }
    
    var _contents = [target_title,downArrow];
    if (opt_align=='left') {
      _contents.reverse();
    }
    jQuery(_contents).appendTo(target);  
    
    // Disable click-through on <a href> attachTo targets.  
    if(target.is('a')) 
      target.bind('click',function(){return false;});

    // Style the attachTo and created <select> elements
    target.css('textDecoration','none');
    target.css({cursor:'pointer'});
    select.css({position: 'absolute'});
    select.attr({size:data.length <= 6 ? data.length : opt_size || 6});

    // Attach the onSelect callback if it is supplied.
    if(opt_onSelect)
      select.bind('optionSelected', opt_onSelect);

    // If the data object has a length, treat it like an array.
    if('length' in data) {
      for(var i = 0; i < data.length; i++) {
        // Only add an option for objects containing at least the
        // innerHTML property.
        if('innerHTML' in data[i]) {
          var newOption = jQuery('<option>').attr(data[i]).appendTo(select);
          if('selected' in data[i]) {
            // Set selected option on first show.
            select.one('onShow', (function(opt) {
              return function() {opt[0].selected = true;}
            })(newOption));            
          }
        }
      }
    }

    /**
     * Calculates the size of the window using whichever methods are
     * best for the particular browsers.
     * 
     * @return {Object} returns an object literal with a height and 
     *     width property
     */
    var windowSize = function()
    {
    	var w = 0;
    	var h = 0;

    	//IE
    	if(!window.innerWidth)
    	{
    		//strict mode
    		if(!(document.documentElement.clientWidth == 0))
    		{
    			w = document.documentElement.clientWidth;
    			h = document.documentElement.clientHeight;
    		}
    		//quirks mode
    		else
    		{
    			w = document.body.clientWidth;
    			h = document.body.clientHeight;
    		}
    	}
    	//w3c
    	else
    	{
    		w = window.innerWidth;
    		h = window.innerHeight;
    	}
    	return {width:w,height:h};
    }

    /**
     * Called when the select object is removed from visibility. The
     * onHide event is triggered to any listeners that are bound after
     * the select element is hidden from view.
     */
    var hideSelect = function() {
      select.hide();
      select.trigger('onHide', [select]);
    }
    
    /**
     * Calculates the offset of the attachTo element and positions
     * the select box below it. Auto-detection of whether or not the
     * select object will extend off the screen is taken into account
     * and the box will be aligned to either the right or the left
     * of the attachTo element based on it's size if there isn't
     * enough room, otherwise the opt_align property will be respected.
     */
    var showSelect = function() {
      var offset = target.offset();
      select.css({visibility:'hidden', display:''});

      var left = offset.left;
      var right = ((offset.left + target.get(0).offsetWidth) - 
        select.get(0).offsetWidth);
      var top = (offset.top + target.get(0).offsetHeight);
      var size = windowSize();
      
      if(opt_align == 'right' && right < 0) {
        opt_align = 'left';
      }
      else if(opt_align == 'left'
              && (left + select.get(0).offsetWidth) > size.width) {
        opt_align = 'right';
      }

      select.css({
        left: (opt_align=='right') ? right + 'px' : left + 'px',
        top: top + 'px'
      })

      select.css('visibility', '').show();
      select.trigger('onShow', [select]);
    }

    // Capture loss of focus or a mouse out event if the opened select element
    // is not what the user intended to use or work on. 
    var lossOfFocus = function(timeout, eventName) {
      if(!eventName) eventName = 'mouseover';
      if(!timeout) timeout = 400;
      
      return (function() {
        var handle = -1;

        handle = setTimeout(function() {
          hideSelect();
          handle = -1;
        }, timeout);

        select.one(eventName, function() {
          if(handle != -1)
            clearTimeout(handle);
        });
      })
    };    

    // Create the mousedown (faster than onclick) for the attachTo target
    target.bind('click', function() {
      // Hide the <select> if it's currently visible
      if(select.is(':visible')) {
        hideSelect();
      }
        
      // Otherwise calculate the location on the page of the attachTo target,
      // modify the <select> object, ensure it's onscreen then show it.
      else {        
        showSelect();
      }
    });
    
    // Remove any previously added but unfired hideSelect events and add
    // a one-time event on the currently selected option such that if it
    // is clicked, the select will hide. NOTE: The click on already selected
    // element to hide it doesn't work in IE. The degradation however is
    // acceptable.
    select.bind('onShow', function(eventObj,jSelect) {
      jSelect.find('option').unbind('click');
      jSelect.find('option:selected').one('click', hideSelect);
      jSelect.get(0).focus();
    });    
    
    // If the <select> is moused over and then subsequently moused out, the
    // user has 400ms to mouse back into the <select> or it will be hidden.
    select.bind('mouseout', lossOfFocus());
    
    // If the <select> is displayed and moused over, a one shot onBlur event
    // is assigned causing the <select> to hide immediately if it loses focus.
    select.one('mouseover', function() {
      select.one('blur', lossOfFocus(0));
    });
    
    // Attach an event that hides the <select> box immediately if an element
    // is selected. This event is also responsible for triggering the optional
    // onSelect method that can be supplied to the call to FauxSelect.
    select.bind('change', function() {      
      hideSelect();
      if(opt_onSelect) {
        var option = select.get(0).options[select.get(0).selectedIndex];
        select.trigger('optionSelected', [target_title, option]);
      }
    });

    // Return the jQuery wrapped <select> element after adding it to the page.
    return select.css('display', 'none').appendTo(document.body);       
  }
})(jQuery);
