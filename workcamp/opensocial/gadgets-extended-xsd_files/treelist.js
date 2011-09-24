// Copyright 2007 Google Inc.
// All Rights Reserved.

/**
 * treelist.js
 *
 * @fileoverview Converts "treelist" classed ul or ol elements into a 
 *     collapsible tree control. Also manages the special #gc-toc lists 
 *     and their respective highlighting.
 *     
 *     NOTE: If there exists an list within a #gc-toc node, it will have 
 *     the .treelist class added to it before the rest of the 
 *     script is run.
 * @author <a href="mailto:gharrison@google.com">Gabriel Harrison</a>
 */
 
/**
 * Function used to isolate scope and prevent unwanted variable leakage
 * on the page. Variables defined within the method call below that are to
 * appear globally will be delcared with explicit window.variableName
 * notation.
 * 
 * @param {Object} $ reference to the jQuery object such that within the scope
 *     of the function, $ can be used in place of jQuery.
 */
(function($) {
  /**
   * Regular expression to filter a url. Captured elements are
   *   [0] - The full match
   *   [1] - The domain, sub-domain and port number
   *   [2] - The path relative to the domain excluding query params and hashes
   *   [3] - The query string including the prefixed question mark, if any;
   *         null otherwise
   *   [4] - The remaining string contents (usually a # followed by the link)
   *         but always at least an empty string (safe to concatenate).
   *
   * The array with the above described items can be obtained by
   * calling URL_FILTER.exec(string);
   * @type RegExp
   */
  var URL_FILTER = /\/\/([^\/]*)?(\/[^\#\?]*)?([^\#]*)?(.*)$/;
  
  /**
   * Based on the djb2 hash function found at
   * http://www.cse.yorku.ca/~oz/hash.html
   *
   * Used to convert a string into a semi-unique number
   *
   * @param {String} string this value is any unicode string.
   * @return {String} a calculated hash value.
   * @private
   */
  function simpleChecksum(string) {
    var hash = 5381;
    for (var i = 0; i < string.length; i++) {
      hash = ((hash<<5) + hash) + string.charCodeAt(i);
    }    
    return hash;    
  }
  
  /**
   * COOKIE_KEY a key used once on the page to identify trees created
   * below based on the directory of the table of contents include page 
   * being served for a particular docs page. If _tocPath_ isn't defined
   * the fallback is to use the current page's URL.
   * @type Array
   * @private
   */
  var COOKIE_KEY_ARRAY = window._tocPath_ 
    ? [null, null, _tocPath_, null, '']
    : URL_FILTER.exec(location.href);
  
  /**
   * Due to overall confusion of about a variable that started as an
   * Array and was subsequently converted into a String (normal for 
   * JavaScript; abnormal for more strongly typed languages) an additional
   * variable was created. Based on the values of COOKIE_KEY_ARRAY, this
   * variable will contain either ck_ followed by a numeric hash value
   * of the table of contents path location or ck_checksumError.
   * @type String
   * @private
   */  
  var COOKIE_KEY = COOKIE_KEY_ARRAY 
    ? ['ck_', simpleChecksum(COOKIE_KEY_ARRAY[2] + 
      COOKIE_KEY_ARRAY[4])].join('')
    : 'ck_checksumError';  
  
  /**
   * This method takes any object (that can be converted into a String)
   * and filters it's String converted version for any single quotes
   * These quotation marks are then returned in a new String properly 
   * escaped with back slashes.
   * @param {Object} unfiltered any Object that can be converted into
   *     a String; including Numbers, Objects, Strings, etc...
   * @return {String} a String version of the supplied object with it's
   *     quote marks escaped.
   */
  window['CODESITE_filterSingleQuotes'] = function(unfiltered) {
    // A regular expression used to escape single and double quotes
    var filter = /(\')/g;
    
    // Using the built-in String function's replace method to
    // invoke any necessary Object->String conversions, this will
    // return a String with all single and double quotes escaped
    return String.prototype.replace.call(unfiltered, filter, '\\$1');    
  }
  
  /**
   * Creates and exposes a method, CODESITE_createTreeLists, that is
   * responsible for searching the page for any "treelist" classed
   * lists and convert them into tree controls. 
   * 
   * This method may be called more than once per page. Converted lists
   * will have the class "tlw-processed" added to them to prevent 
   * subsequent calls to CODESITE_createTreeLists() from trying to 
   * convert them more than once.
   *
   * @param {String} opt_selector a jQuery selector that can be used to
   *     identify a specific ul/ol or a group of specific ul/ol nodes
   *     rather than parsing the entire DOM again for any "treelist"
   *     classed nodes.   
   */
  window['CODESITE_createTreeLists'] = function(opt_selector) {
    // Manually define selector to be .treelist when it is undefined
    // Whenever a function is passed into the jQuery.ready() function
    // as is done at one point with this function, jQuery automatically
    // supplies the jQuery object itself as a parameter to the function
    // supplied to jQuery.ready(). The check for jQuery is a crucial one.
    // do not remove it.
    opt_selector = opt_selector != jQuery && opt_selector || '.treelist';

    /**
     * This is a private function used to enable easy collaping and
     * expanding of pivot nodes on the tree. 
     *
     * @param {boolean} value true if the node is to expand and show its
     *     related sub-list's elements; false otherwise
     * @param {element} the HTML element node reference that contains the
     *     control image. It is assumed that it is nested in a <a> within a
     *     <div> and that the next element, sibling to the <div>, is the 
     *     toggled <ul> or <ol>.
     * @param {String} opt_expand the text to be used as a pseudo constant for 
     *     the expansion alt and title attributes of the control image and its 
     *     parent.
     * @param {String} opt_collapse the text to be used as a pseudo constant  
     *     for the collapse alt and title attributes of the control image and  
     *     its parent.
     */
    function setExpanded(value, controlImage, opt_expand, opt_collapse) {
      // Handle constants if not supplied.
      var expand = opt_expand || "Expand branch";
      var collapse = opt_collapse || "Collapse branch";

      // Wrap necessary elements in jQuery for ease of use.
      var control = jQuery(controlImage);
      var nestedList = control.parents('div:first').next();
      var text = value ? collapse : expand;
      var newClass = value ? 'tlw-minus' : 'tlw-plus';

      control.attr('alt', text).parent().attr('title', text);
      control.removeClass('tlw-minus tlw-plus').addClass(newClass);
      value ? nestedList.show() : nestedList.hide();
    }
    
    /**
     * See individual comments below; this outer wrapper function exists
     * only to create toString once rather then upon each invocation.
     */
    var unpackState = (function() {
      /**
       * Creates, one time only, a constant closure passed
       * toString method that is injected into the results
       * of every unpacked state object. It is used to pack
       * itself back into a String format for cookie storage.
       * @return {String} a cookie formatted tree state.
       */
      var toString = function() {
        // An array used for string concatenation below.
        var buffer = [];
        // Performance is greater if declared outside a loop
        var value = null;
        for (var key in this) {
          if (key == 'toString') continue;                      
          key = CODESITE_filterSingleQuotes(key);
          value = CODESITE_filterSingleQuotes(this[key]);
          buffer.push(['"', key, '":"', value, '"'].join(''));
        }
        return ['{', buffer.join(), '}'].join('');
      }
      
      /**
       * The real unpackState function. This method takes the
       * previously defined toString method as a closure variable
       * and attaches it to each unpacked state value for easy
       * processing of the value.
       * @return {Object} a state object in dictionary format
       */
      return function() {
        // Create a usable cookie list
        var cookie = null;
        var state = null;
      
        // Parse the current list of cookies
        cookie = new RegExp([COOKIE_KEY, '=([^\;]*)?'].join('')).
          exec(document.cookie);
      
        // Unpack state
        if (cookie) {
          state = eval('[' + cookie[1] + '][0]');
        }
          
        // Ensure a valid object no matter the (non)existance of cookies
        state = state || {};
        state.toString = toString;
      
        return state;
      }
    })();
    
    /**
     * This method takes a listId, which is a combination of a tree and
     * a sub-tree count, as a String and a boolean value to determine
     * if the listId should be removed or stored in the cookies for this
     * page's directory.
     *
     * @param {String} listId a String combination of tree index and sub tree
     * index separated by dashes. Applies (theoretically) to all pages in
     * the same directory
     * @param {boolean} expanded true if the node should be stored as open
     * in the cookie; false otherwise.
     */
    function storeState(listId, expanded) {
      var state = unpackState();
      
      if (expanded) {
        state[listId] = true;
      } else {
        delete state[listId];
      }
        
      document.cookie = [COOKIE_KEY, '=', state.toString()].join('');
    }

    /** 
     * This is a wrapper put into place to allow the plus/minus sign to 
     * appear next to the title of a collapsible sub-tree. An n-number of
     * these elements may be created in direct proportion to the number
     * of sub-trees and titles appear in the converted ultree list.
     * @type {String}
     */
    var wrapper = [
      '<div class="tlw-title">',
        '<a href="javascript:void(0)" class="tlw-control" title="">',
          '<img src="/images/cleardot.gif" alt="" class="tlw-control">',
        '</a>',
      '</div>'  
    ].join('');

    // Grab each tagged ultree UL list on the page and process it.
    jQuery(opt_selector).each(function() {
      // Wrap the iterated result object in jQuery wrapper
       var root = jQuery(this);
      
      // Get out if this tree has already been processed
      if (root.is('.tlw-processed')) return; 
      
      // Setup a per tree numerical count of subtrees
      root._count = 0;
      
      // Store page reference to this tree
      var callee = arguments.callee;
      var treeId = (callee._list=callee._list||[]).length;
      callee._list.push(root);   
      
      // Brand this .treelist object with .tlw-processed to prevent a
      // second call to _createTreeLists() from trying to process this node
      // twice
      root.addClass('tlw-processed tlw-instance-' + treeId);  
      
      // TODO(gharrison): This section can be removed if, and only if, all
      // of the misplaced <span.new> elements are correctly placed.
      // 
      // Fix misplaced <span.new> elements. They'll cause a problem for both
      // layout and parsing. By placing the <span.new> within the link, we can
      // avoid any issues. Do this for each <span.new> immediately following
      // an <a> within this tree list.
      root.find('a + span.new').each(function() {
        var jThis = jQuery(this);
        var jAnchor = jThis.prev();
        var container = jQuery('<span>');
        
        container.css('textDecoration', jAnchor.css('textDecoration'));
        container.append(jAnchor.html());
        jAnchor.css('textDecoration', 'none').empty();        
        jAnchor.append(container).append(this);
      });
      
      // Define the parent qualifers list; All elements listed here will get
      // the plus/minus control if they immediately precede a ul and are both
      // contained within a li.
      var qualifiedParents = [
        'a + ul',
        'a + ol',
        'h1 + ul',
        'h1 + ol',
        'span.tlw-title + ul',
        'span.tlw-title + ol'
      ].join();
      
      // The first (or top most) qualified parents don't actually qualify
      // and as such must have the tlw-ignore class added.
      root.children().each(function() {
        jQuery(this).children(':first').next(qualifiedParents).
          prev().addClass('tlw-ignore');
      });
      
      // Attach the click events to all the nodes contained within list items. 
      // Add the appropriate plus/minus class designation to their previous 
      // siblings as well.          
      root.find(qualifiedParents).each(function() {
        // Declare some subtree processing variables.
        var nestedList = jQuery(this);
        var subId = [treeId, 'sub', root._count].join('-');
        var title = nestedList.prev();
        var expando = jQuery(wrapper);
        var control = jQuery('img.tlw-control:first', expando);
        
        // TODO(gharrison): remove English literals from code and replace
        //     them with a more i18n suitable approach when codesite gets
        //     updated to support more than just English effectively.
        var expand = "Expand " + title.html();
        var collapse = "Collapse " + title.html();
        
        // Quit if this one's title has the class tlw-ignore
        if (title.is('.tlw-ignore')) return;
        
        // Assign this menu as a submenu of root, ensuring we have 
        // enough sub nodes in the root menu
        var controls_ = {          
          $open: function() {
            if (nestedList.is(':hidden')) {
              setExpanded(true, control, expand, collapse);
              if (CODESITE_createTreeLists._init) {
                storeState(subId, true);          
              }
            }
          },
          $close: function() {
            if (nestedList.is(':visible')) {
              setExpanded(false, control, expand, collapse);
              if (CODESITE_createTreeLists._init) {
                storeState(subId, false);          
              }
            }
          },
          $toggle: function() {
            var expanded = nestedList.is(':hidden');
            setExpanded(expanded, control, expand, collapse);
            if (CODESITE_createTreeLists._init) {
              storeState(subId, expanded);       
            }               
          }
        };     
        jQuery.extend(this, controls_);   
        jQuery.extend(control.parent()[0], controls_);

        // For rendering purposes, a div containing a link and some other
        // markup is created to hold the sub-list's preceeding anchor. Here
        // we place the title within the div and make sure the div is 
        // positioned where the title used to be.  
        nestedList.attr('id', subId);
        nestedList.before(expando);
        expando.append(title);
        expando.addClass('tlw-branch');
        expando.parent().css({paddingTop:'0', paddingBottom:'0'});
        
        // Set the inital state of the branch node
        this.$close();
        
        // Apply a click event that toggles the branch node's children
        control.parent().click(function(event) {
          this.$toggle();
        });
        
        // Increment the subtree count
        root._count++;
      });
    });
    
    // Restore state based on cookies
    var state = unpackState();
    jQuery.each(state, function(key, value) {
      if (key=='toString') return;
      try {jQuery('#' + key)[0].$open();}
        catch(e) {}
    });
    
    // Optional call back for when ontreelist is assigned to the window
    // object. Can be used to speed up implementation.
    if (window.ontreelistcomplete && typeof ontreelistcomplete == 'function') {
      window.ontreelistcomplete(opt_selector);   
    }
  };

  /**
   * This method will build a set of breadcrumbs based on the left navigation
   * found in the #gc-toc div. Breadcrumbs (in this version) will not be made
   * if no element with a class of "selected" is found. Therefore, the
   * CODESITE_tocHighlighter must be called first if dynamic breadcrumbs are
   * desired.
   */
  window['CODESITE_buildBreadcrumbs'] = function() {
    // Grab the selected node; if there isn't one we need to quit.
    var selected = jQuery('#gc-toc .selected').
      add('ul.gc-topnav-tabs a.selected');
    
    if (selected.length < 2) {
      $('#gc-pagecontent ol.cs-breadcrumbs:first').remove();
      return;
    };
    
    // Find all the appropriate parent links 
    var parents = jQuery(selected.parents('ul:not(.treelist)').
      siblings('.tlw-branch').find('a:not(.tlw-control)').get().reverse()).
      add(selected.find('a:not(.tlw-control)'));
      
    // A constant HTML snippet representing the breadcrumb start.
    var BREADCRUMBS = '<ol class="cs-breadcrumbs"></ol>'
      
    // A constant HTML snippet for the area between breadcrumbs. 
    // The radioactive symbol, &#9672;, is better in my opinion.
    var SEPARATOR = '<span class="cs-crumbSpacer">&nbsp;&gt;&nbsp;</span>';
    
    // A constant HTML snippet for holding a breadcrumb link.
    var CRUMB = '<li class="cs-crumb"></li>';
    
    // Clone the home link from the top right tabs and add a separator
    // as the start of our breadcrumbs.
    var homeLnk = jQuery('ul.gc-topnav-tabs a.selected').clone(true).
      removeAttr('id').removeClass('selected');    
    var results = jQuery(BREADCRUMBS).append(jQuery(CRUMB).append(homeLnk).
      append(SEPARATOR));
   
    for (var i = 0, anchor=parents[i], len=parents.length; i < len ; i++, 
        anchor=parents[i]) {
      var crumb = jQuery(CRUMB).append(jQuery(anchor).clone(true));
      
      if (i != len - 1) {
        crumb.append(SEPARATOR);
      }
      
      results.append(crumb);
    }
    
    // Add the breadcrumbs to the page.
    jQuery('#gc-pagecontent').prepend(results);
    
    // Optional call back for when ontreelist is assigned to the window
    // object. Can be used to speed up implementation.
    if (window.oncrumbscomplete && typeof oncrumbscomplete == 'function') {
      window.oncrumbscomplete();    
    }
  }
  
  /**
   * This function, local to the execution scope, massages the data in
   * the page's div#gc-toc and then converts those modified instances
   * manually in a one-off function. 
   *
   * @private 
   */
  window['CODESITE_convertTableOfContents'] = function() {
    // Manually add the ultree class to the one UL tree list we know should
    // be on each page. Forcing compliance.
    jQuery('#gc-toc ul:first, #gc-toc ol:first').addClass('treelist').
      siblings('ul, ol').addClass('treelist');
  }
  
  /**
   * This public function searches through the #gc-toc for links that
   * match specific portion of the window's location href value. If they
   * do match accordingly, they are deemed selected. Their contents will
   * then be highlighted and tagged as class "selected".
   */
  window['CODESITE_tocHighlighter'] = function() {
    // Finds all links within the #gc-toc element and passes their
    // href attributes through a custom regular expression. The results,
    // if any, are checked for existance within the document's current
    // location. Any results are considered to be selected navigation
    // elements and the links parent is tagged with a .selected className.
    var PRE_FIX = /\/intl\/.*?\//;
    var POST_FIX = /\/index\.html$/;
    var anchors = jQuery('#gc-toc a[@href]');
    var pageUrl = window.location.href;
    var linkUrl = null;
    var rootPath = null;
    var jAnchor = null;
    var newPath = URL_FILTER.exec(pageUrl);
          
    if (newPath) {
      pageUrl = newPath[2];
    }
    
    // Clean the pageUrl of any /intl/* references.
    pageUrl = pageUrl.replace(PRE_FIX, '/').replace(POST_FIX,'/');
    
    for(var i = 0; i < anchors.length; i++) {
      rootPath = URL_FILTER.exec(anchors[i].href);      
      if (rootPath) {
        jAnchor = jQuery(anchors[i]);
        linkUrl = (rootPath[2] + rootPath[4]).
          replace(PRE_FIX, '/').replace(POST_FIX,'/');
        
        if (pageUrl == linkUrl) {
          jAnchor.parent().addClass('selected');          
          // Call the control anchors' click() method. This is safer
          // then trying to do it manually as it also invokes the
          // accessibility's alt/title attribute modifications.
          var tlwControls = jAnchor.siblings('a.tlw-control');
          for(var ctrl = 0; ctrl < tlwControls.length; ctrl++) {
            tlwControls[ctrl].$open();
          }
          
          var tlwBranches = jAnchor.parents('ul').siblings('.tlw-branch').
            find('a.tlw-control');
          for(var branch = 0; branch < tlwBranches.length; branch++) {
            tlwBranches[branch].$open();
          }
        }
      }
    }
    anchors.each(function() {
    });
    
    // Optional call back for when ontreelist is assigned to the window
    // object. Can be used to speed up implementation.
    if (window.ontreelisthighlight && 
         typeof ontreelisthighlight == 'function') {
      window.ontreelisthighlight();        
    }
  }

  // Using jQuery's DOM ready method, place both an initial call to
  // CODESITE_createTreeLists as well as a call to the private function
  // convertTableOfContents_. The CODESITE_tocHighlighter method *must*
  // be called before CODESITE_buildBreadcrumbs or a list of breadcrumbs
  // will not be created.
  jQuery(document).ready(CODESITE_convertTableOfContents).
    ready(CODESITE_createTreeLists).ready(CODESITE_tocHighlighter).
    ready(CODESITE_buildBreadcrumbs);
  
  jQuery(window).load(function() {
    CODESITE_createTreeLists._init = true;
  });    
})(jQuery);
