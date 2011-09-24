// Copyright 2007 Google Inc.
// All Rights Reserved.

/**
 * @fileoverview This script is used for setting up the Custom Search Engine
 * and serving the results.
 * @author jacobm@google.com (Jacob Moon)
 */

// List of products that have Google Groups setup
var CSE_PRODUCT_GROUPS = {
  // Products that are under code.google.com/apis/
  'accounts' : true,
  'adsense' : true,
  'ajax' : true,
  'ajaxfeeds' : true,
  'ajaxsearch' : true,
  'apps' : true,
  'base' : true,
  'blogger' : true,
  'calendar' : true,
  'chart' : true,
  'checkout' : true,
  'codesearch' : true,
  'coupons' : false,
  'docsapis' : true,
  'documents' : true,
  'feedburner' : true,
  'gadgets' : true,
  'gdata' : true,
  'gears' : true,
  'kml' : true,
  'maps' : true,
  'notebook' : true,
  'opensocial' : true,
  'orkut' : true,
  'picasaweb' : true,
  'safebrowsing' : true,
  'searchappliance' : true,
  'soapsearch' : false,
  'socialgraph' : true,
  'spreadsheets' : true,
  'talk' : true,
  'themes' : false,
  'youtube' : true,

  // Products that are under code.google.com/
  'android' : true,
  'campfire' : false,
  'edu' : true,
  'enterprise' : true,
  'gme' : true,
  'soc' : false,
  'webstats' : false,
  'webtoolkit' : true
};

var CSE_SearchControl = null;
var CSE_RecentQuery = '';
var CSE_ShowingSearchResults = false;

var CSE_QUERY_REGEX_HASH = /([^\#\?]*)?([^\#]*)?\#q=(.*)$/;
var CSE_QUERY_REGEX_QUES = /([^\#\?]*)?()\?q=(.*)$/;

/** 
 * Used to indicate whether the iframe URL is in sync.
 * @type Boolean
 */
var CSE_IframeUrlInSync = true;

/**
 * Polling interval (in milliseconds) for checking whether the iframe URL is
 * updated.
 * @type Number
 */
var CODESITE_IFRAME_URL_CHECK_POLLING_INTERVAL = 50;

/**
 * Initializes search by setting up search control and a couple searchers.
 * The first searcher includes generic Google Code results, and
 * the second searcher includes results from discussion forums.
 */ 
function CSE_initialize() {

  // Initialize search control
  CSE_SearchControl = new GSearchControl();  
  CSE_SearchControl.setResultSetSize(GSearch.LARGE_RESULTSET);
  CSE_SearchControl.setLinkTarget(GSearch.LINK_TARGET_BLANK);

  // CSE for Google Code results
  var cseIdCode = '001456098540849067467:6whlsytkdqg';

  var searcher;

  var URL = window.location.href;

  var productRegex;

  if (URL.indexOf('/apis') != -1) {
    productRegex = /\/apis\/(\w+)(\/)?/;
  } else {
    URL = URL.slice(URL.indexOf('://') + 3, URL.length);
    URL = URL.slice(URL.indexOf('/') + 1, URL.length);
    productRegex = /(\w+)(\/)?/;
  }

  var productResultArr = productRegex.exec(URL);
  var product = '';

  if (productResultArr) {
    product = productResultArr[1];
  }

  // Searchers: Product specific results and product specific Groups results
  if (CSE_USER_DEFINED_LABEL[product] != null) {

    // Searcher: Product specific results
    searcher = new GwebSearch();
    searcher.setSiteRestriction(cseIdCode, product);
    searcher.setUserDefinedLabel(CSE_USER_DEFINED_LABEL[product]);
    CSE_SearchControl.addSearcher(searcher);

    if (CSE_PRODUCT_GROUPS[product]) {
      // Product specific Groups
      searcher = new GwebSearch();
      searcher.setSiteRestriction(cseIdCode, product + '_groups');
      searcher.setUserDefinedLabel(CSE_USER_DEFINED_LABEL[product + '_groups']);
      CSE_SearchControl.addSearcher(searcher);
    }
  }

  // Searcher: Google Code results
  searcher = new GwebSearch();
  searcher.setSiteRestriction(cseIdCode, 'google_code');
  searcher.setUserDefinedLabel(CSE_USER_DEFINED_LABEL['google_code']);
  CSE_SearchControl.addSearcher(searcher);

  // Searcher: All Developers Groups
  searcher = new GwebSearch();
  searcher.setSiteRestriction(cseIdCode, 'discussion_groups');
  searcher.setUserDefinedLabel(CSE_USER_DEFINED_LABEL['discussion_groups']);
  CSE_SearchControl.addSearcher(searcher);

  // Initialize the search in tabbed mode
  var scDiv = document.getElementById('searchControl');
  var drawOptions = new GdrawOptions();
  drawOptions.setDrawMode(GSearchControl.DRAW_MODE_TABBED);
  CSE_SearchControl.draw(scDiv, drawOptions);

  CODESITE_SetupPolling();

  // Check the hash string and execute search if necessary
  CSE_CheckHash(CSE_QUERY_REGEX_HASH, window.location.href);
}

// Initialize search 
GSearch.setOnLoadCallback(function() {
  new CSE_initialize();
});

/**
 * Initiates polling for handling back button functionality.
 * Enables polling for the following browsers: 
 *     Firefox, IE, Safari 3, Mozilla, Netscape, Camino
 */
function CODESITE_SetupPolling() {

  /**
   * Polling interval in ms
   * @type {Number}
   */
  var CSE_POLLING_INTERVAL = 450;

  var morePage = window.location.href.match(/\/more/);

  // IE
  if (jQuery.browser.msie) {
    startPolling_(morePage);

  // Firefox, Mozilla, Netscape, Camino
  } else if (jQuery.browser.mozilla) {
    startPolling_(morePage);

  // Detect Safari version and enable polling if >= 3
  // Reference - http://developer.apple.com/internet/safari/faq.html#anchor2
  } else if (jQuery.browser.safari &&  
            (navigator.userAgent.indexOf('Version/') != -1)) {
    startPolling_(morePage);
  }

  /**
   * Starts polling.
   * @param {Boolean} morePage Whether the current page is site directory page
   */
  function startPolling_(morePage) {
    window.setInterval(function() {
      // Poll the hash string for new search term
      CSE_PollHash();

      // Poll the hash string for the site directory page
      if (morePage) {
        window.MORE.pollHash();
      }
    }, CSE_POLLING_INTERVAL);
  }
}

/**
 * Polls the hash string to preserve the back button functionality.
 */
function CSE_PollHash() {
  if (jQuery.browser.msie) {
    if (CSE_IframeUrlInSync) {
      window.setTimeout(function() {
        if (CSE_CheckHash(CSE_QUERY_REGEX_QUES, 
                          window['backiFrame'].location.href)) {
          CSE_CheckHash(CSE_QUERY_REGEX_HASH, window.location.href);
        }
      }, 0);
    }
  } else {
    CSE_CheckHash(CSE_QUERY_REGEX_HASH, window.location.href);
  }
}

/**
 * Checks the hash string and initiates an action if it has changed.
 * @param {String} queryRegex Regular expression to use
 * @param {String} hashString document location that includes the hash
 */
function CSE_CheckHash(queryRegex, hashString) {
  var queryArray = queryRegex.exec(hashString);
  if (queryArray) {
    if (!queryArray[2]) {
      var query = decodeURI(queryArray[3]);
      if ((query != '') && (query != CSE_RecentQuery)) {
        jQuery('#gsearchInput').attr('value', query);
        executeGSearch(query);
      }
    }
    queryArray = null;
  } else {
    if (CSE_ShowingSearchResults) {
      jQuery('#searchControl').hide();
      jQuery('#codesiteContent').show();
      CSE_RecentQuery = '';
      CSE_ShowingSearchResults = false;
    }
    queryArray = null;
    return false;
  }
  return true;
}

/** 
 * Executes the search.
 * @param {String} query Search query term
 */
function executeGSearch(query) {
  // Don't execute search if the query is an empty string
  if (query == '') {
    return;
  }

  if (!CSE_IframeUrlInSync) {
    return;
  }

  // Handle analytics for search queries. 
  // Append the search term, referrer path and the tab name if applicable.
  var referrer = window.location.href;
  var tab = (jQuery('#searchControl').css('display') == "block") ? 
      jQuery('div[@class*="gsc-tabhActive"]').text() : 
      '';
  var tracking = '/search/?q=' + query + '&referrer=' + referrer + 
      '&tab=' + tab;

  if (window.pageTracker) {
    try {
      pageTracker._initData();
      pageTracker._trackPageview(tracking);
    } catch(e) {}
  }

  var queryParam = 'q=' + encodeURI(query);

  // IE: Set the hash in iframe for browser history management
  // Pause polling until the iframe URL is in sync
  if (jQuery.browser.msie) {
    CSE_IframeUrlInSync = false;
    window['backiFrame'].location.search = queryParam;
    
    var timerID = window.setInterval(checkIframeUrl_, 
        CODESITE_IFRAME_URL_CHECK_POLLING_INTERVAL);
    
    function checkIframeUrl_() {
      if (window['backiFrame'].location.search.substring(1) == queryParam) {
        CSE_IframeUrlInSync = true;
        window.clearInterval(timerID);
      }
    }
  }

  CSE_RecentQuery = query;

  window.location.href = '#' + queryParam;

  jQuery('#searchControl').show();
  jQuery('#codesiteContent').hide();

  CSE_ShowingSearchResults = true;

  var noResults = CSE_MakeNoResultsHtml_(query);

  CSE_SearchControl.setNoResultsString(noResults);
  CSE_SearchControl.execute(query);

  /**
   * Makes HTML that gets displayed when there are no results found
   * @param {string} query The query string
   * @return {string} HTML string 
   */
  function CSE_MakeNoResultsHtml_(query) {
    return [
        CSE_NoResultsFound,
        '<b>', 
        CODESITE_EscapeHtml(query),
        '</b>',
        CSE_Suggestions,
        '<br><a href="',
        CSE_SearchUrl,
        encodeURI(query), 
        '">',
        CSE_TryWebSearch,
        '</a>.'].join('');
  }
}

/**
 * Escapes HTML entities from the given string.
 * @param {string} string String that contains HTML to be escaped
 * @return {string} HTML-escaped string
 */
function CODESITE_EscapeHtml(string) {
  return string.
      replace(/&/g, '&amp;').
      replace(/</g, '&lt;').
      replace(/>/g, '&gt;').
      replace(/\'/g, '&#039;').
      replace(/\"/g, '&quot;');
}

