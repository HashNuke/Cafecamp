// Copyright 2007 Google Inc. All Rights Reserved.
// Author: pamelafox@google.com (Pamela S. Fox)
// Modified: gharrison@google.com (Gabriel Harrison)

(function($) {
  /**
   * AsYouTypeSearch class. Initializes the variables, etc.
   *
   * @param {String} searchInputId 
   * @param {String} searchButtonId 
   * @constructor
   */
  window.AsYouTypeSearch = function(searchInputId, searchButtonId) {
    // Initialize results_ array object.
    this.results_ = [];

    // Grab a reference to the search button element
    this.buttonEl_ = jQuery('#'+searchButtonId);

    // Grab a reference to the text input element
    this.inputFieldEl_ = jQuery('#'+searchInputId);

    // When the search button gets focus, hide the results window
    var me = this;
    jQuery(this.buttonEl_).focus(function() {
      me.hideResultsWindow_();
    });

    // Create the search results div
    this.searchResultsEl_ = jQuery('<div id="cs-searchresults">');
    this.searchResultsEl_.click(function(e) {(event||e).cancelBubble = true;});
    this.searchResultsEl_.appendTo(document.body);

    // Create the recommended caption div
    jQuery('<div id="cs-recommended">').html('Suggestions').
      appendTo(this.searchResultsEl_);

    // Add search result divs
    for (var i = 0, num = 1; i < this.MAX_RESULTS_; i++, num++) {
      jQuery('<div id="searchResult'+num+'">').
        appendTo(this.searchResultsEl_);
    }

    // NOTE: The following section of code assigns event functions to various
    // stored elements on the page. These events must be wrapped in 
    // function(e){return me.<function>.call(me,e)}
    // snippets to facilitate the instance of AsYouTypeSearch references from
    // within the events themeselves. Alternate ways of doing this exist for
    // the interested -- gharrison@google.com
    
    // Adding event handlers
    jQuery(document.body).
      click(function(e){return me.handleBodyClick_.call(me,e)});
      
    jQuery(document).
      keydown(function(e){return me.handleBodyKeyDown_.call(me,e)}).
      keypress(function(e){return me.handleBodyKeyPress_.call(me,e)}).
      keyup(function(e){return me.handleBodyKeyUp_.call(me,e)});

    // Handle repositioning the search drop down on window resize
    jQuery(window).
      resize(function(e){me.handleBodyResize_.call(me,e)});
    
    /**
     * A fix for firefox that hides the results window when the fast
     * back feature is enabled. Note: If e.persisted is true then the page
     * is cached by the browser.
     *
     * @param {Event} e
     */
    window.onpageshow = function(e) {
      if(e.persisted)
        me.hideResultsWindow_();
    }
  
    // Add event bindings to the text input element
    this.inputFieldEl_.
      keyup(function(e){return me.handleInputKeyUp_.call(me,e)}).
      focus(function(e){return me.handleInputFocus_.call(me,e)}).
      blur(function(e){return me.handleInputBlur_.call(me,e)}).
      click(function(e){return me.handleInputClick_.call(me,e)}).
      attr('autocomplete', 'off');

    // Set the object initialized flag.
    this.initialized_ = !!(this.inputFieldEl_.length && 
      this.searchResultsEl_.length && this.buttonEl_.length);
  };

  /**
   * Define the intial properties of a AsYouTypeSearch object. 
   */
  AsYouTypeSearch.prototype = {
    /**
     * Results from the last search
     * @type Array.<Object>
     */
    results_: null, 

    /** 
     * Whether the whole as-you-type search engine has been initialized
     * @type Boolean 
     */
    initialized_: false, 

    /**
     * Whether the search is active (it will be false when the form is being 
     * submitted, so new results won't appear then)
     * @type Boolean
     */
    searchActive_: true, 

    /**
     * Whether pop-down window is hidden or visible 
     * @type Boolean
     */
    resultsWindowHidden_: true, 
  
    /**
     * A handler to the input field
     * @type Number
     */
    inputFieldEl_: 0,    

    /**
     * A handler to the pop-down
     * @type Number
     */
    searchResultsEl_: 0, 

    /**
     * Whether the input field currently has focus (can be 0, 0.5 or 1) 
     * @type Number
     */
    inputFieldHasFocus_: 0,            

    /**
     * Whether any of the results is activated by navigating through it via
     * keyboard. 0 if no. 
     * @type Number
     */
    activeResult_: 0, 

    /**
     * Whether the arrow key has been processed on keydown event, and can be
     * ignored on keypress (see handleBodyKeyPress_ for more information on why
     * this is necessary)
     * @type Boolean
     */
    arrowKeyProcessed_: false,

    /**
     * The query last typed by the user
     * @type String
     */
    typedQuery_: '', 

    /**
     * Color property for background hover. 
     * @type String
     */
    backgroundHover: "#3366CC",

    /**
     * Color property for background hover. 
     * @type String
     */
    foregroundHover: "#ffffff",

    /**
     * Color property for background. 
     * @type String
     */
    backgroundOff: "#ffffff",

    /**
     * Color property for foreground. 
     * @type String
     */
    foregroundOff: "#000000",
    
    /** 
     * Maximum number of search results including (more).
     * @type Number
     */
    MAX_RESULTS_: 7,
    
    /**
     * A constant value representing the first possible
     * search result.
     * @type Number
     */
    FIRST_RESULT_: 1,
    
    /**
     * Get a query from the input field and clean it up a little bit
     * @return {String} A cleaned up query
     */
    getQueryFromInputField_: function() {
      return jQuery.trim(this.inputFieldEl_.val().toLowerCase());
    },

    /**
     * Performs search on whatever the user typed against the JSON data.
     * Currently implemented as a full-text match.
     */
    querySearch_: function() {
      // If the search isn't yet active, get out of here.
      if (!this.searchActive_) 
        return;

      // Get rid of the results window and finish if the text is empty.
      if (this.typedQuery_.length == 0) {
        this.hideResultsWindow_();
        return;
      }

      // Empty our array instead of creating a new one
      this.results_.splice(0, this.results_.length);

      // Split the results into an array
      for (var i = 0; i < potentialResults.length; i++) {
        var potentialResult = potentialResults[i];
        var matchPoints = 0;
        var regEx = new RegExp('(?:\\s|^)' + RegExp.escape(this.typedQuery_));
        var match = potentialResult.title.toLowerCase().match(regEx);
        if (match != null) 
          matchPoints = 2;
      
        // check for keyword matches
        for (var keyword in potentialResult.keywords) {
          // full query match
          var keywordMatch = keyword.match(regEx);
          if (keywordMatch != null) 
            matchPoints += potentialResult.keywords[keyword];
        
          // subquery (word) match
          var queryWords = this.typedQuery_.split(' ');
          if (queryWords.length > 1) {
            for (var j = 0; j < queryWords.length; j++) {
              var wordRegEx = new RegExp('(?:\\s|^)' + queryWords[j]);
              var wordKeywordMatch = keyword.match(wordRegEx);
              if (wordKeywordMatch != null) {
                matchPoints += potentialResult.keywords[keyword];
              }
            }
          }
        }
      
        // If the match points total above zero, store the results
        // for later.
        if (matchPoints > 0) {
          this.results_.push({
            match: matchPoints, 
            title: potentialResult.title,
            url: potentialResult.url
          });      
        }
      }

      this.results_.sort(this.sortMatches_);
      this.results_.length = Math.min(this.results_.length, 6);
      this.prepareResultsWindow_();  
    },
  
    /**
     * Sorts array based on length of matched strings.
     * @param {Object} left First result object to compare
     * @param {Object} right Second result object to compare
     * @return {Boolean} True if match is longer string
     */
    sortMatches_: function(left, right) {
      var x = right.match;
      var y = left.match;
      return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    },
  
    /**
     * This method takes a search result index number and then
     * modifies the events, html, styles and attributes on the
     * specified result div.
     * @param {Number} resultIndex the search result index number
     * of the DIV to modify.
     */
    createSearchResultDiv: function(resultIndex) {
      var num = resultIndex + 1;
      var me = this;
      var resultsDiv = jQuery("#searchResult" + num);
    
      resultsDiv.
        // Ensure it has the right class
        attr('class','cs-searchresult').
      
        // Set it's CSS styles
        css({
          display: 'block',
          textAlign: 'left',
          zoom: '1'
        }).
      
        // Set it's HTML contents
        html([
          '<a tabindex="-1" id="searchResultLink', num, '" ',
          'href="',this.results_[resultIndex].url,'">',
          this.results_[resultIndex].title,
          '</a>'
        ].join('')).
      
        // Remove all bound events
        unbind().
      
        /**
         * Removes all bound onMouseOver events and then assigns
         * a new event. This deselects all other results and then
         * selects the current result.
         */
        mouseover(function() {
          me.deactivateAllResults_();
          me.activateSearchResult_(num);
        }).
      
        /**
         * Removes all bound onMouseOut events and then deselects
         * all search results.
         */
        mouseout(function() {
          me.deactivateSearchResult_(num);
        }).
      
        /**
         * Causes the page to load to the appropriate url when the
         * DIV is clicked. 
         */
        click(function() {
          window.location.href = me.results_[resultIndex].url;
        });
    },
  
    /**
     * Prepare the HTML mark-up for the pop-down results window.
     */
    prepareResultsWindow_: function() {
      this.activeResult_ = 0;
      if (this.results_.length == 0) {
        this.hideResultsWindow_();
        return;
      }

      // Then we generature summaries
      for (var i = 0; i < this.results_.length; i++) 
        this.createSearchResultDiv(i);      

      this.deactivateAllResults_();
      var moreNum = this.results_.length + 1;
      var resultsDiv = jQuery('#searchResult' + moreNum);
    
      // Adjust the more result...
      var me = this;
      resultsDiv.
        // Ensure it has the right class
        attr('class','').
        
        // Set it's CSS styles
        css({
          textAlign:'right',
          display:'block',
          zoom: '1'
        }).
        
        // Set it's HTML contents
        html(('<a style="color: #0000ff; text-decoration: underline;" ' +
            'id="searchResultLink' + moreNum + '"> more &raquo;</a>')).
        
        // Remove all bound events
        unbind().
        
        mouseup(function() {
          me.hideResultsWindow_();
          executeGSearch(me.inputFieldEl_.val());
        }).
        
        /**
         * Removes all bound onMouseOver events and then assigns
         * a new event. This deselects all other results and then
         * selects the current result.
         */
        mouseover(function() {
          me.deactivateAllResults_();
          me.activateSearchResult_(moreNum);
        }).
        
        /**
         * Removes all bound onMouseOut events and then deselects
         * all search results.
         */
        mouseout(function() {
          me.deactivateSearchResult_(moreNum);
        });
      
      // Set visible, only the ones that matter
      for(var i = moreNum + 1; i <= this.MAX_RESULTS_; i++)
        jQuery('#searchResult'+i).hide();

      // Show the results window if it's hidden
      if (this.resultsWindowHidden_)
        this.showResultsWindow_();    
    },

    /**
     * Calculate and update the position of the dropdown 
     */
    updateDimensions_: function() {
      if (!this.searchActive_) return;
      
      // grab the offset of the element relative to the viewport
      var offset_ = this.inputFieldEl_.offset();

      // Adjust the left offset
      offset_.left += 3;

      // Adjust the properties of the search results element
      this.searchResultsEl_.css({
        left: offset_.left + 'px',
        top: (offset_.top + this.inputFieldEl_[0].offsetHeight + 2) + 'px',
        width: this.inputFieldEl_.css('width')
      })
    },
  
    /**
     * Show the pop-down window with results.
     */
    showResultsWindow_: function() {
      if (!this.searchActive_) return;
    
      this.searchResultsEl_.css('visibility','hidden');
      this.updateDimensions_();
      this.searchResultsEl_.css('display','block');
      this.searchResultsEl_.css('visibility','visible');
      this.resultsWindowHidden_ = false;
    },


    /**
     * Hide the pop-down window with results.
     */
    hideResultsWindow_: function() {
      if (this.resultsWindowHidden_) return;

      this.searchResultsEl_.hide();
      this.resultsWindowHidden_ = true;
      this.activeResult_ = 0;
    },


    /**
     * Activate (highlight) a result. Used for keyboard navigation
     * between pop-down results.
     *
     * @param {Number} num The number of the result to activate
     */
    activateSearchResult_: function(num) {
      this.inputFieldEl_[0].blur();
        
      var searchResultDiv = jQuery('#searchResult' + num);
      var searchResultA = jQuery('#searchResultLink' + num);

      if (searchResultDiv.length) 
        searchResultDiv.css('backgroundColor', this.backgroundHover);
    
      if (searchResultA.length) 
        searchResultA.css('color', 'white');    
    },

    /**
     * Deactivate (de-highlight) a result. Used for keyboard navigation
     * between pop-down results.
     *
     * @param {Number} num The number of the result to deactivate
     */
    deactivateSearchResult_: function(num) {
      var searchResultDiv = jQuery('#searchResult' + num);
      var searchResultA = jQuery('#searchResultLink' + num);

      if (searchResultDiv) 
        searchResultDiv.css('background', this.backgroundOff);
    
      if (searchResultA && num == this.results_.length + 1) 
        searchResultA.css('color', '#0000ff');
      else if (searchResultA)     
        searchResultA.css('color', this.foregroundOff);
    },

    /**
     * Deactivates (de-highlights) all results. 
     */
    deactivateAllResults_: function() {
      for (var i = 0, len = this.results_.length + 1; i < len; i++) 
        this.deactivateSearchResult_(i+1);
    },

    /**
     * Activate (highlight) a next result, if possible.
     */
    activateNextSearchResult_: function() {
      if (this.results_.length > 0) {
        if ((this.activeResult_ <= this.results_.length)) {
          this.deactivateSearchResult_(this.activeResult_);
          this.activeResult_++;
          this.activateSearchResult_(this.activeResult_);
        }
      }
    },

    /**
     * Deactivate (de-highlight) a next result, if possible.
     */
    activatePrevSearchResult_: function() {
      if (this.results_.length > 0) {
        if (this.activeResult_ == this.FIRST_RESULT_) {
          // Going up from the first result will get us back in the input field
          this.deactivateSearchResult_(this.activeResult_);
          this.activeResult_ = 0;
          this.inputFieldEl_[0].focus();
        } else if (this.activeResult_ > this.FIRST_RESULT_) {
          this.deactivateSearchResult_(this.activeResult_);
          this.activeResult_--;
          this.activateSearchResult_(this.activeResult_);
        }
      }
    },

    /**
     * Handle a key up event in the input form. Fire a search query if
     * applicable.
     *
     * @param {Event} e Browser event
     */
    handleInputKeyUp_: function(e) {
      if (!this.initialized_) return;
      if (!this.searchActive_) return;
      e = e || window.event;
      var whichKey = (e.which) ? e.which : e.keyCode;

      if (whichKey == 13) {
        this.hideResultsWindow_();
        executeGSearch(this.inputFieldEl_.val());
        return;
      }

      // Changing the query to lowercase and stripping out the white
      // space surrounding it
      var query = this.getQueryFromInputField_();

      if (query != this.typedQuery_) {
        this.typedQuery_ = query;
        this.querySearch_();
      }

      return true;
    },

    /**
     * Handle a key down event in the document body.
     *
     * @param {Event} e Browser event
     */
    handleBodyKeyDown_: function(e) {
      var valueToReturn = true;

      if (this.initialized_) {
        e = e || window.event;
        var whichKey = (e.which) ? e.which : e.keyCode;
        var targetElement = (e.target) ? e.target : e.srcElement;
        var activeResult = jQuery('#searchResultLink' + this.activeResult_);
        switch (whichKey) {
          
          case 13: // Enter
            if (this.activeResult_ >= 0) {
              if (this.activeResult_ == this.results_.length + 1) {
                this.hideResultsWindow_();
                executeGSearch(this.inputFieldEl_.val());
              } 
              else if (activeResult.length) 
                location.href =  activeResult.attr('href');
              
              valueToReturn = false;
            }
            break;
          case 27: // Escape
            // Escape can do three things, in order of precedence:
            // 1. If the page with results is loading, Escape should
            //    be handled by the browser to cancel loading the page.
            // 2. If the pop-down with results is shown, Escape should
            //    remove it.
            // 3. Otherwise it should clear the field.

            if (!this.searchActive_) {
              this.searchActive_ = true;
              this.inputFieldEl_[0].focus();
              valueToReturn = true;
            } else if (!this.resultsWindowHidden_) { 
              this.hideResultsWindow_();
              valueToReturn = false;
            } else {
              this.inputFieldEl_.val('');
              valueToReturn = false;
            }
            break;
          case 40: // down arrow
          case 63233: // down arrow
            // If we press down arrow in the input field, we can force the 
            // re-query 
            if ((this.resultsWindowHidden_) && (this.inputFieldHasFocus_) && 
                (whichKey != 39)) {
              this.searchActive_ = true;
              this.querySearch_();
              valueToReturn = false;
            } else if ((!this.resultsWindowHidden_) && 
                ((this.activeResult_ > 0) || ((whichKey != 39)))) {
              // If not, right or down arrow activate the next result
              this.deactivateAllResults_();
              this.activateNextSearchResult_();
              valueToReturn = false;
              this.arrowKeyProcessed_ = true;
            }
            break;
          case 38: // up arrow
          case 63235: // up arrow
            if ((!this.resultsWindowHidden_)) {
              this.deactivateAllResults_();
              this.activatePrevSearchResult_();
              valueToReturn = false;
              this.arrowKeyProcessed_ = true;
            }
            break;
          case 37: // left arrow
          case 39: // right arrow
            if(!this.inputFieldHasFocus_ && !this.resultsWindowHidden_) {
              this.arrowKeyProcessed_ = true;
              this.inputFieldEl_[0].focus();
            }
            if(!this.inputFieldHasFocus_ || this.resultsWindowHidden_)
              valueToReturn = false;
        }
      }

      return valueToReturn;
    },

    /**
     * Handle a key press event in the document body.
     *
     * @param {event} e Browser event
     */
    handleBodyKeyPress_: function(e) {
      if (this.initialized_) {
        e = e || window.event;
        var whichKey = (e.which) ? e.which : e.keyCode;

        // Arrow keys have the same key codes here as some other characters
        // (for example, down arrow is the same as left parenthesis)
        // We have to detect whether the arrow key was pressed during key down,
        // and then ignore it here if that's the case (otherwise it'd scroll
        // the screen)
        if ((this.arrowKeyProcessed_) && (whichKey >= 37) && (whichKey <= 40))
          return false;
          
        return true;
      }
    },

    /**
     * Handle a key up event in the document body.
     *
     * @param {event} e Browser event
     */
    handleBodyKeyUp_: function(e) {
      var valueToReturn = true;

      e = e || window.event;
      var whichKey = (e.which) ? e.which : e.keyCode;
      var targetElement = (e.target) ? e.target : e.srcElement;

      this.arrowKeyProcessed_ = false;

      return valueToReturn;
    },

    /**
     * Handle a onresize event in the document body.
     *
     * @param {event} e Browser event
     */
    handleBodyResize_: function(e) {
      this.updateDimensions_();
      return true;
    },    

    /**
     * Handle input field losing focus. Remember this in a variable.
     *
     * @param {event} e Browser event
     */
    handleInputBlur_: function(e) {
      this.inputFieldHasFocus_ = 0;
    },

    /**
     * Handle input field receiving focus. Remember this in a variable.
     *
     * @param {event} e Browser event
     */
    handleInputFocus_: function(e) {
      this.inputFieldHasFocus_ = 0.5;
      if (this.initialized_) 
        this.deactivateAllResults_();
    },

    /**
     * Handle input field receiving a click.
     *
     * @param {event} e Browser event
     */
    handleInputClick_: function(e) {
      e = e || window.event;
      e.cancelBubble = true;

      this.searchActive_ = true;

      // Clicking on the input field again when it's already active
      // shows the pop-down again
      if (this.inputFieldHasFocus_ == 1) {
        if (this.resultsWindowHidden_) {
          this.querySearch_();
        }
      } else {
        this.inputFieldHasFocus_ = 1;
      }
    },

    /**
     * Closes the results window if a click occurs elsewhere.
     *
     * @param {event} e Browser event
     */
    handleBodyClick_: function(e) {
      e = e || window.event;
      var targetElement = (e.target) ? e.target : e.srcElement;

      if (targetElement) 
        if (targetElement.parentNode) 
          this.hideResultsWindow_();
    }
  };
})(jQuery);
