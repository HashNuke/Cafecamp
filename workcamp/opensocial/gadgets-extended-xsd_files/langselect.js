// Copyright 2007 Google Inc.
// All Rights Reserved.
  
/**
* langselect.js
*
* @fileoverview Manages the locale/language of the page.
*     
* @author <a href="mailto:apasha@google.com">Ali Pasha</a>
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
(function($){
    
  /**
   * Regular expression to filter a url. Captured elements are
   *   [0] - The full match
   *   [1] - The domain, sub-domain and port number
   *   [2] - The intl directory path (will be null, if none exists, e.g. en)
   *   [3] - The remaining path
   *
   * The array with the above described items can be obtained by
   * calling URL_FILTER.exec(string);
   * @type RegExp
   */  
  var URL_FILTER = /\/\/([^\/]*)?(\/intl\/[^\/]*)?(\/.*)?/;
  var URL_ARRAY = URL_FILTER.exec(location.href);

  /**
   * Regular expression to filter local/lang. Captured elements are
   *   [0] - The full match
   *   [1] - The lang/locale information.
   * 
   * The array with the above described items can be obtained by
   * calling LANG_FILTER.exec(string);
   * @type RegExp
   */  
  var LANG_FILTER = /intl\/([^\/]*)?/;  

  jQuery(document).ready( function() {

    /**
    * On document ready, set the available languages and select the 
    * language based on the URL locale.
    */

    var langData = [
	{innerHTML:'中文（简体）', value:'zh-CN'},
        {innerHTML:'English', value:'en'},
        {innerHTML:'Português (Brasil)', value:'pt-BR'},
        {innerHTML:'Русский', value:'ru', style: 'font-family:arial'},
/*        {innerHTML:'Español', value:'es'},*/
        {innerHTML:'日本語', value:'ja'}
      ];

    //Based on the pages lang/locale (urlLang) select the language.
    var urlLang = LANG_FILTER.exec(location.href);
    urlLang= (urlLang==null)?'en':urlLang[1];
   
    for (i in langData){
      if (langData[i].value == urlLang){
        langData[i].selected = true;
        break;
      }
    }

    //Add the language selector on the page where the div class='dropdown'.
    FauxSelect({
      attachTo: '.dropdown',
      data: langData, 
      opt_onSelect: function(event, jTitle, option) {
        jTitle.html(option.text);
        localeRedirect(option.value);
      }
    });      
  });  
    
  /**
  * Redirects to the page of the correct lang/locale
  * @param {String} locale The name of the page locale to redirect to.
  */
  function localeRedirect(locale)
  {    
    var url = null;

    if (URL_ARRAY){
      if(!URL_ARRAY[1]) URL_ARRAY[1] = 'code.google.com';

      url = URL_ARRAY[3]? 'http://' + URL_ARRAY[1] + '/intl/' + locale 
              + URL_ARRAY[3]:'http://' + URL_ARRAY[1] + '/intl/' + locale + '/';    

      window.location.href = url;            
    }
  }

})(jQuery);
