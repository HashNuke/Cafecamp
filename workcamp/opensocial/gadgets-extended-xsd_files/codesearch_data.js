var potentialResults = [
  {title: 'Android', 
   url:'/android/',
   keywords: {mobile: 10}},
  {title: 'FeedBurner APIs', 
   url:'/apis/feedburner',
   keywords: {feed: 10}},
  {title: 'Google Mashup Editor', 
   url:'/gme', 
   keywords: {ajax: 2, data: 1, gdata: 1, tools: 5}},
  {title: 'Google AJAX Feed API', 
   url:'/apis/ajaxfeeds',
   keywords: {ajax: 8, apis: 5, feed: 6}},
  {title: 'Google AJAX Search API',
   url:'/apis/ajaxsearch', 
   keywords: {ajax: 9, apis: 10, search: 6}},
  {title: 'Google Maps API', 
   url:'/apis/maps/', 
   keywords: {ajax: 7, apis: 4, geo: 6, maps: 6}},
  {title: 'Google AJAX APIs', 
   url:'/apis/ajax', 
   keywords: {ajax: 10, apis: 10}},
  {title: 'Google Web Toolkit', 
   url:'/webtoolkit',
   keywords: {ajax: 6, java: 1, tools: 6, gwt:10}},
  {title: 'Google Gears', 
   url:'/apis/gears/', 
   keywords: {ajax: 5, apis: 9, tools: 1}},
  {title: 'Google Calendar APIs and Tools',
   url:'/apis/calendar', 
   keywords: {apis: 1, feed: 5, data: 2, gadgets: 3, gdata: 1, "data apis": 3, tools: 1}},
  {title: 'YouTube API', 
   url:'/apis/youtube', 
   keywords: {feed: 4, data: 2, gdata: 6}},
  {title: 'Google Code Search Data API',
   url:'/apis/codesearch/overview.html', 
   keywords: {apis: 1, feed: 1, data: 1, gdata: 1, search: 1}},
  {title: 'Google Base Data API', 
   url:'/apis/base',
   keywords: {apis: 1, feed: 1, data: 2, gdata: 1, "data apis": 2}},
  {title: 'Google Account Authentication',
   url:'/apis/accounts/Authentication.html', 
   keywords: {apis: 1, feed: 1, data: 1, gdata: 1}},
  {title: 'Google Data APIs',
   url:'/apis/gdata/index.html', 
   keywords: {apis: 1, feed: 1, data: 6, gdata: 10, "data apis": 10, java: 1}},
  {title: 'Google Documents List Data API',
   url:'/apis/documents/', 
   keywords: {apis: 1, feed: 1, data: 2, gdata: 1, "data apis": 3}},
  {title: 'Google Notebook Data API',
   url:'/apis/notebook/overview.html', 
   keywords: {apis: 1, feed: 1, data: 1, gdata: 1, "data apis": 3}},
  {title: 'Google Safe Browsing APIs',
   url:'/apis/safebrowsing/', 
   keywords: {apis: 1, feed: 1, data: 1, gdata: 1}},
  {title: 'Google SketchUp Ruby APIs',
   url:'/apis/sketchup/', 
   keywords: {apis: 1, geo: 3}},
  {title: 'Social Graph API',
   url:'/apis/socialgraph/', 
   keywords: {social: 9}},
  {title: 'Google Spreadsheets Data API',
   url:'/apis/spreadsheets', 
   keywords: {apis: 1, feed: 1, data: 2, gdata: 1, "data apis": 4}},
  {title: 'Google Search History Feeds',
   url:'http://www.google.com/support/accounts/bin/answer.py?answer=54464',
   keywords: {feed: 1, search: 1}},
  {title: 'Google Transit Feed Specification',
   url:'/transit/spec/transit_feed_specification.htm', 
   keywords: {feed: 1, geo: 1, maps: 1}},
  {title: 'Picasa Web Albums Data API',
   url:'/apis/picasaweb/overview.html', 
   keywords: {feed: 1, data: 1, gdata: 1, "data apis": 3}},
  {title: 'Gmail Atom Feeds',
   url:'http://gmail.google.com/support/bin/answer.py?answer=13465', 
   keywords: {feed: 1}},
  {title: 'Google Coupon Feeds', 
   url:'/apis/coupons/',
   keywords: {feed: 1}},
  {title: 'Google News Feeds',
   url:'http://news.google.com/intl/en_us/news_feed_terms.html', 
   keywords: {feed: 1}},
  {title: 'Blogger Data API',
   url:'/apis/blogger/overview.html', 
   keywords: {apis: 1, feed: 1, data: 2, gdata: 1, "data apis": 4}},
  {title: 'Google Gadgets API', 
   url:'/apis/gadgets', 
   keywords: {finance: 1, apis: 8, gadgets: 6}},
  {title: 'Google Chart API', 
   url:'/apis/chart/',
   keywords: {apis: 1, charts: 1}},
  {title: 'Google Checkout API', 
   url:'/apis/checkout',
   keywords: {apis: 5}},
  {title: 'Google AdSense API', 
   url:'/apis/adsense',
   keywords: {ads: 1, apis: 1}},
  {title: 'Google AdWords API', 
   url:'http://www.google.com/apis/adwords',
   keywords: {ads: 2, apis: 1}},
  {title: 'Google Themes API',
   url:'/apis/themes/', 
   keywords: {apis: 1}},
  {title: 'Google Toolbar API',
   url:'http://www.google.com/tools/toolbar/buttons/apis/', 
   keywords: {apis: 1, tools: 1}},
  {title: 'Google Search Appliance APIs',
   url:'/enterprise/', 
   keywords: {apis: 1, search: 1}},
  {title: 'Google Mapplets',
   url:'/apis/maps/documentation/mapplets/', 
   keywords: {apis: 1, gadgets: 1, geo: 5, maps: 1}},
  {title: 'Google KML', 
   url:'/apis/kml', 
   keywords: {apis: 1, geo: 4, maps: 1}},
  {title: 'Google Apps APIs', 
   url:'/apis/apps', 
   keywords: {apis: 1}},
  {title: 'Google Talk XMPP',
   url:'/apis/talk/talk_developers_home.html', 
   keywords: {apis: 1}},
  {title: 'Google Sitemaps',
   url:'http://www.google.com/webmasters/sitemaps/docs/en/about.html', 
   keywords: {search: 1, tools: 1}},
  {title: 'Google Desktop Gadget API', 
   url:'http://desktop.google.com/dev/gadgetapi.html',
   keywords: {gadgets: 3, search: 1}},
  {title: 'Google Desktop Search API', 
   url:'http://desktop.google.com/dev/searchapi.html',
   keywords: {gadgets: 1, search: 3}},
  {title: 'Google Code Search', 
   url:'http://www.google.com/codesearch',
   keywords: {search: 1}},
  {title: 'Open Source', 
   url:'/opensource/', 
   keywords: {"open source": 10}},
  {title: 'Project Hosting', 
   url:'/hosting/', 
   keywords: {"open source": 6}},
  {title: 'Google Summer Of Code', 
   url:'/soc/', 
   keywords: {"open source": 5}},
  {title: 'Open Source Projects',
   url:'/hosting/projects.html', 
   keywords: {"open source": 1}},
  {title: 'Knowledge Base', 
   url:'/support/', 
   keywords: {faq: 1}},
  {title: 'Google Code for Educators', 
   url:'/edu/',
   keywords: {educators: 1}},
  {title: 'Event Calendar', 
   url:'/events/',
   keywords: {developer: 1}},
  {title: 'Developer Day 2007',
   url:'/events/developerday/', 
   keywords: {developer: 1}},
  {title: 'Google Code Blog', 
   url:'http://google-code-updates.blogspot.com/',
   keywords: {developer: 1}},
  {title: 'Featured Projects', 
   url:'http://google-code-featured.blogspot.com/',
   keywords: {developer: 1}},
  {title: 'Google Enterprise Developer Community ', 
   url:'/enterprise/',
   keywords: {developer: 1}},
  {title: 'Campfire One', 
   url:'/campfire/',
   keywords: {developer: 1}},
  {title: 'Orkut Developer Home', 
   url:'/apis/orkut/',
   keywords: {social: 8}},
  {title: 'OpenSocial', 
   url:'/apis/opensocial/',
   keywords: {social: 10, "open source": 2, apis: 8}},
  {title: 'Google Analytics', 
   url:'/apis/analytics/',
   keywords: {tools: 1}},
  {title: 'Google Mac Developer Playground', 
   url:'/mac/',
   keywords: {"open source": 2, osx: 6, apple: 6, iphone: 6}},
  {title: 'Highly Open Participation Contest', 
   url:'/opensource/ghop/2007-8/',
   keywords: {"open source": 2}}
 ];

