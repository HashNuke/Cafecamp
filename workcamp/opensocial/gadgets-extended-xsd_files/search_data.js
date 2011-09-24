// List of products and the corresponding user defined label for displaying 
// search results
var CSE_USER_DEFINED_LABEL = {
  // Products that match code.google.com/apis/*
  'accounts'               : 'Accounts',
  'accounts_groups'        : 'Accounts Groups',
  'adsense'                : 'AdSense',
  'adsense_groups'         : 'AdSense Groups',
  'ajax'                   : 'Ajax APIs',
  'ajax_groups'            : 'Ajax APIs Groups',
  'ajaxfeeds'              : 'Ajax Feeds',
  'ajaxfeeds_groups'       : 'Ajax Feeds Groups',
  'ajaxsearch'             : 'Ajax Search API',
  'ajaxsearch_groups'      : 'Ajax Search API Groups',
  'apps'                   : 'Google Apps',
  'apps_groups'            : 'Google Apps Groups',
  'base'                   : 'Google Base',
  'base_groups'            : 'Google Base Groups',
  'blogger'                : 'Blogger API',
  'blogger_groups'         : 'Blogger API Groups',
  'calendar'               : 'Google Calendar API',
  'calendar_groups'        : 'Google Calendar API Groups',
  'chart'                  : 'Google Chart API',
  'chart_groups'           : 'Google Chart API Groups',
  'checkout'               : 'Google Checkout API',
  'checkout_groups'        : 'Google Checkout API Groups',
  'codesearch'             : 'Code Search API',
  'codesearch_groups'      : 'Code Search API Groups',
  'coupons'                : 'Coupons Feeds',
  'coupons_groups'         : 'Coupons Feeds Groups',
  'docsapis'               : 'Google Docs API',
  'docsapis_groups'        : 'Google Docs API Groups',
  'documents'              : 'Documents List API',
  'documents_groups'       : 'Documents List API Groups',
  'feedburner'             : 'Feed Burner',
  'feedburner_groups'      : 'Feed Burner Groups',
  'gadgets'                : 'Gadgets',
  'gadgets_groups'         : 'Gadgets Groups',
  'gdata'                  : 'Google Data API',
  'gdata_groups'           : 'Google Data API Groups',
  'gears'                  : 'Gears',
  'gears_groups'           : 'Gears Groups',
  'kml'                    : 'Google Earth',
  'kml_groups'             : 'Google Earth Groups',
  'maps'                   : 'Google Maps',
  'maps_groups'            : 'Google Maps Groups',
  'notebook'               : 'Notebook API',
  'notebook_groups'        : 'Notebook API Groups',
  'opensocial'             : 'OpenSocial',
  'opensocial_groups'      : 'OpenSocial Groups',
  'orkut'                  : 'Orkut',
  'orkut_groups'           : 'Orkut Groups',
  'picasaweb'              : 'Picasa API',
  'picasaweb_groups'       : 'Picasa API Groups',
  'safebrowsing'           : 'Safebrowsing API',
  'safebrowsing_groups'    : 'Safebrowsing API Groups',
  'searchappliance'        : 'Search Appliance',
  'searchappliance_groups' : 'Search Appliance Groups',
  'soapsearch'             : 'SOAP Search API',
  'soapsearch_groups'      : 'SOAP Search API Groups',
  'socialgraph'            : 'Social Graph API',
  'socialgraph_groups'     : 'Social Graph API Groups',
  'spreadsheets'           : 'Google Spreadsheets API',
  'spreadsheets_groups'    : 'Google Spreadsheets API Groups',
  'talk'                   : 'Google Talk',
  'talk_groups'            : 'Google Talk Groups',
  'themes'                 : 'Google Themes API',
  'youtube'                : 'Youtube API',
  'youtube_groups'         : 'Youtube API Groups',

  // Products that match code.google.com/*
  'android'                : 'Android',
  'android_groups'         : 'Android Groups',
  'campfire'               : 'Google Campfire One',
  'campfire_groups'        : 'Google Campfire One Groups',
  'edu'                    : 'Educators',
  'edu_groups'             : 'Educators Groups',
  'enterprise'             : 'Google Enterprise',
  'enterprise_groups'      : 'Google Enterprise Groups',
  'gme'                    : 'Google Mashup Editor',
  'gme_groups'             : 'Google Mashup Editor Groups',
  'soc'                    : 'Summer of Code',
  'soc_groups'             : 'Summer of Code Groups',
  'webstats'               : 'Web Authoring Statistics',
  'webstats_groups'        : 'Web Authoring Statistics Groups',
  'webtoolkit'             : 'Google Web Toolkit',
  'webtoolkit_groups'      : 'Google Web Toolkit Groups',

  // Google Code Website
  'google_code'            : 'Google Code Website',

  // Google Code Discussion Groups
  'discussion_groups'      : 'Google Code Groups'
};

var CSE_NoResultsFound = 'No search results found. Search query: ';

var CSE_Suggestions = [
    '<br><br>Suggestions:<br><br>',
    '<ul>',
    '<li>Make sure all words are spelled correctly.</li>',
    '<li>Try different keywords.</li>',
    '<li>Try more general keywords.</li>',
    '</ul>'].join('');

var CSE_TryWebSearch = 'Or try web search';

var CSE_SearchUrl = 'http://www.google.com/search?q=';
