// Copyright 2007 Google Inc. All rights reserved.
// codesite.js 
// author: Gabriel Harrison (gharrison@google.com)

(function($) {
  /**
   * Based on comments in the JavaScript mailing list from Lindsey Simon
   * enables BackgroundImageCacheing in IE6 which is by default
   * disabled. I am doing so here as well.
   */
  try {
		document.execCommand("BackgroundImageCache", false, true)
	} catch(e) {
		/*Ignore Errors on this call.*/
	}


  /** 
   * Add regular expression escaping to the RegExp object; see below. This
   * method creates the real RegExp.escape method that is passed back.
   * @return {Function} the generated RegExp.escape method.
   */
  RegExp.escape = (function() {
    var specials = [
      '/', '.', '*', '+', '?', '|',
      '(', ')', '[', ']', '{', '}', '\\'
    ];

    var sRE = new RegExp(
      '(\\' + specials.join('|\\') + ')', 'g'
    );
    
    /**
     * The real function; this function takes any String object and
     * escapes any characters found within that would conflict with
     * RegExp syntax.
     * @param {String} text the potentially regular expression conflicted
     *     code.
     * @return {String} the same supplied text with all of its RegExp conflict
     *     code escaped with backslash characters.
     */
    return function(text) {
      return text.replace(sRE, '\\$1');
    }
  })();  
  
  /**
   * Executes immediately and creates some variables to pass via a closure
   * to the real function that is returned. See comments below. This is done
   * so that some processing is done once and not per event.
   */
  window.CODESITE_minWidth = (function() {
    /**
     * Private, closure passed, array of proccessed jQuery DOM elements.
     * @type Object
     */
    var elements_ = [];
  
    /**
     * Performs the calculations in a safe manner, using a queue if 
     * more than one element on the page has a CODESITE_minWidth applied
     * to it. Function only applies to IE browsers.
     */
    var calc = function() {
      // Avoid potential race condition
      if(!CODESITE_minWidth) return;
      
      for(var i = 0, elem = elements_[0] || null; i < elements_.length; 
          ++i, elem=elements_[i]) {
        
        try {
          if(elem.parent_.offsetWidth <= elem.minWidth_) {
            elem.style.width = elem.minWidth_+'px';
            elem.style.overflow = 'hidden';
          }
          else {
            elem.style.width = '';
            elem.style.overflow = '';
          }
        }
        catch(e) {/*Ignore invalid element*/}
      }
    };

    // Apply the calc function to the onresize and on document ready
    // events if the browser is Internet Explorer.
    if(jQuery.browser.msie) {
      jQuery(window).resize(calc);
      jQuery(calc);
    }
  
    /**
     * Enforces the min width css style in Internet Explorer on 
     * the supplied element. There is a caveat of requiring a 
     * parent element capable of possessing a CSS width value.
     *
     * @param {String|Object} element either a DOM element or a jQuery
     *     selector string.
     * @param {Number} width the minimum width for this element. 
     */
    return function(element, width) {
      if(!jQuery.browser.msie) 
        return;
      
      // Create jQuery wrapper around the supplied element or
      // search using the selector if element is a selector string
      var jElement = jQuery(element)[0];
    
      // Add the minWidth property to the created jQuery wrapper
      jElement.minWidth_ = width-0;
      jElement.parent_ = jElement.parentNode;
    
      // Add to list of elements
      elements_.push(jElement);
    }
  })();

  /**
   * Export a createImageBar function that pulls up to the first three
   * video feeds from the supplied feed url. The generated image bar gets
   * placed within the specified container. 
   *
   * @param {String} url the href pointing to the feed to read the data from.
   * @param {String} selector the CSS syntax selector for the element to hold
   *     the created image bar.
   */
  window.createImageBar = function(url, containerSelector) { 
    var feed = new google.feeds.Feed(url);
    feed.setResultFormat(google.feeds.Feed.XML_FORMAT);
    feed.setNumEntries(8);
    feed.load(function(result) {
      if (!result.error) {
        var container = jQuery(containerSelector);
        var items = jQuery('item', result.xmlDocument);
        var length = 0;

        if(items.length >= 3)
          length = 3;

        /**
         * Creates the FRAME_ constant used to create the 0-3 video frames
         * returned from the feed. The following constants are expected to
         * be replaced before this constant can be effectively used.
         *   &#64;link      - the URL to be go to when clicked
         *   &#64;thumb     - the URL to the thumbnail image.
         *   &#64;origTitle - the original title of the feed
         *   &#64;title     - the modified title
         *   &#64;date      - the date the feed was posted
         *
         * @type String
         */
        var FRAME_ = [
          '<div class="post techtalk">',
            '<div class="screenshot">',
              '<a href="@link">',
                '<img alt="@origTitle" src="@thumb" height="80" width="90">',
              '</a>',
            '</div>',
            '<div class="info">',
              '<div class="name">',
                '<a href="@link" title="@origTitle">@title</a>',
              '</div>',
              '<div class="author videodateformat">Posted on @date</div>',
            '</div>',
          '</div>'
        ].join('');
        
        /**
         * Create the strip from the following HTML.
         * @type String
         */
        var strip = jQuery([
            '<div class="g-section g-tpl-34-33-33 gc-techtalk">',
              '<div class="g-unit g-first">&nbsp;</div>',
              '<div class="g-unit">&nbsp;</div>',
              '<div class="g-unit">&nbsp;</div>',
            '</div>'          
          ].join(''));
        
        for (var i = 0; i < length; i++) {
          var origTitle = jQuery('title:first',items[i]).text();
          var title = origTitle.substring(0, 18) + '...';
          var link = jQuery('link:first',items[i]).text();
          var date = new Date(jQuery('date',items[i]).text());

          var thumbElement = google.feeds.getElementsByTagNameNS(items[i], 
            "http://search.yahoo.com/mrss/", "thumbnail")[0];
          var thumb = thumbElement.getAttribute("url");
          var width = thumbElement.getAttribute("width");
          var height = thumbElement.getAttribute("height");

          // Format date
          //getMonth returns 0-11
          date = (date.getMonth()+1) + '/' + date.getDate() + '/' +
            date.getFullYear();
          
          var frame = jQuery(FRAME_.
            replace(/@link/g, link).
            replace(/@thumb/g, thumb).
            replace(/@origTitle/g, origTitle).
            replace(/@title/g, title).
            replace(/@date/g, date));
            
          jQuery('.g-unit:eq('+i+')', strip).prepend(frame);
        }
        
        container.append(strip);
      }
    });
  } 

  /**
   * adds the "prettyprint" class to all <pre> elements,
   * then calls the prettyPrint function.
   */
  jQuery(function() {
    try {prettyPrint();} catch(e) 
      {/* prettyPrint not defined */}
  });

  /**
   * As the document object model (DOM) becomes available for processing
   * via JavaScript, create a new instance of AsYouTypeSearch.
   */
  jQuery(function() {
    /** 
     * Create a new asYouTypeSearch object for each page. 
     * @type Object 
     */
    var asYouTypeSearch = new AsYouTypeSearch('gsearchInput', 'gsearchButton');
  });
  
  /**
   * This section creates the blog and featured content widgets for any pages
   * containing either <div#gc-blog-gadget> or <div#gc-community-gadget>. If
   * the object _apiGadgetData_ exists within the window scope then we can 
   * safely assume we're working with an API page. 
   *
   * The _apiGadgetData_ is defined in /apis/_gadget-scripts. It takes 
   * values from the server where available.
   */
  jQuery(function() {
    var codeBlogDiv = jQuery('#gc-blog-gadget');
    var featuredDiv = jQuery('#gc-community-gadget');
    
    // Create the blog gadget for either the homepage (when _apiGadgetData_
    // is unavailable) or on any of the api sub pages containing the correct
    // divs. 
    if(codeBlogDiv.length) {
      if(window._apiGadgetData_) {
        new CSG_FeedSqueezeGadget(codeBlogDiv[0], _apiGadgetData_.blogFeedName,
          [{
            url: _apiGadgetData_.blogFeedUrl, 
            name: _apiGadgetData_.blogFeedName
          }]);
      }
      else {
        new CSG_FeedSqueezeGadget(codeBlogDiv[0], 'Blogs', [
          {
            url: "http://google-code-updates.blogspot.com/atom.xml", 
            name: "Google Code Blog", 
            numEntries:"3"
          }, 

          {
            url:"http://www.google.com/reader/public/atom/user/"+
                "08136184812262361848/label/RelatedDeveloperBlogs", 
            name:"Related Developer Blogs", 
            numEntries:"3"
          }    
        ]);
      }
    }
    
    // Create the featured projects gadget for either the homepage (when 
    // _apiGadgetData_ is unavailable) or on any of the api sub pages 
    // containing the correct divs. 
    if(featuredDiv.length) {
      if(window._apiGadgetData_) {
        var data_ = [];

        if(_apiGadgetData_.featureFeedUrl.length) {
          data_.push({
            url: _apiGadgetData_.featureFeedUrl,
            name: 'Featured Projects',
            slideshow:true
          });
        }

        if(_apiGadgetData_.articleFeedUrl.length) {
          data_.push({
            url: _apiGadgetData_.articleFeedUrl,
            name: 'Articles',
            numEntries: 3,
            readMoreLink: _apiGadgetData_.articleLink
          });
        }

        if(_apiGadgetData_.groupFeedUrl.length) {
          data_.push({
            url: _apiGadgetData_.groupFeedUrl,
            name: 'User Group',
            numEntries: 3,
            readMoreLink: _apiGadgetData_.groupLink
          });
        }

        new CSG_FeedSqueezeGadget(featuredDiv[0], 'Community', data_);
      }
      else {
        new CSG_FeedSqueezeGadget(featuredDiv[0], 'Community', [
          {
            url: "http://google-code-featured.blogspot.com/atom.xml", 
            name: "Featured Projects", 
            numEntries: 3, 
            slideshow: true
          },

          {
            url: "http://www.google.com/reader/public/atom/user/"+
                 "08136184812262361848/label/GoogleDevelopers", 
            name: "User Groups", 
            numEntries: 5,
	    showSnippets: false
          },

          {
            url: "http://www.google.com/calendar/feeds/developer-calendar" +
                 "@google.com/public/basic" +
                 "?futureevents=true&orderby=starttime&sortorder=ascending",
            name: "Upcoming Events", 
            numEntries: 5,
	    showSnippets: false,
            showBylines: false,
	    readMoreLink: "/events/"
          }
        ]);
      }
    }
  });
  
  /**
   * This section of code creates the collapsible control for the left
   * navigation. 
   */
  jQuery(function() {
    var pageContent = jQuery('#gc-pagecontent');
    var tableOfContents = jQuery('#gc-toc');
    
    if(pageContent.length) {
      /** 
       * Create a div to hold the arrow 
       * @type Object 
       */
      var cs_hoverArrow = jQuery('<div id="gc-collapsible-arrow">');

      /** 
       * Create a div to hold the collapsible column. 
       * @type Object 
       */
      var cs_collapsible = jQuery('<div id="gc-collapsible">');

      /**
       * Create a method we can use to calculate the arrow's location
       * based on mouse movements. This function is passed via a closure
       * to applied event methods below.
       *
       * @param {Event} eventObj used to poll the mouses y coordinate.
       */
      var hoverCalc = function(eventObj) {
        var offset = pageContent.offset();
        cs_hoverArrow.css({
          left: offset.left + 'px',
          top: (eventObj.pageY || eventObj.clientY) + 'px'
        });
      }

      // Add the collapsible and hoverArrow divs to the page.
      pageContent.css('position','relative').append(cs_collapsible);
      jQuery(document.body).append(cs_hoverArrow);
      
      // Adjust pageContent's location for IE6.... sigh
      if(jQuery.browser.msie && jQuery.browser.version < 7)
        pageContent.css('left','-5px');
        
      cs_collapsible.
        // When the mouse is over the collapsible, the hover class
        // is added thereby widening the background color, narrowing
        // the borders and if the nav is collapsed moving the bar 
        // right by its new visible width.
        mouseover(function(eventObj) {
          cs_collapsible.addClass('hover');
          if(tableOfContents.is(':hidden')) {
            cs_collapsible.css('left','-3px');
            cs_hoverArrow.addClass('collapsed');
          }
          else 
            cs_hoverArrow.removeClass('collapsed');
          cs_hoverArrow.show();
          hoverCalc(eventObj);          
        }).
        
        mousemove(function(eventObj) {
          hoverCalc(eventObj);
        }).
      
        // Undo the modifications of the mouse over effects. Remove the
        // hover class and reset the left to whatever values the style
        // sheet dictates regardless of the collapsed/expanded state
        mouseout(function() {
          cs_collapsible.removeClass('hover');
          cs_collapsible.css('left','');
          cs_hoverArrow.hide();
        }).
      
        // When clicked, remove any styling performed by mousing over
        // then toggle the visibility of the <div#gc-toc> div and 
        // restore the left margin's state on the pageContent div.
        click(function() {
          // Undo any mouseover/out states since the mouse will
          // have left the collapsible on the toc toggle. 
          cs_hoverArrow.hide();
          cs_collapsible.removeClass('hover').css('left','');
          tableOfContents.toggle();
          
          if(tableOfContents.is(':visible')) {
            pageContent.css('margin-left','');
            if(jQuery.browser.msie && jQuery.browser.version < 7)
              pageContent.css('left','-5px');
          }
          else {
            pageContent.css('margin-left','0px');
            if(jQuery.browser.msie && jQuery.browser.version < 7)
              pageContent.css('left','');
          }
        }).
        
        // Set the height of the collapsible to be the same height as the
        // pageContent div. 
        height(pageContent.height());        
    }    
  })

})(jQuery);


