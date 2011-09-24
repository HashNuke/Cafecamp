<html>
<head>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  
</head>
<body>
  <div id="feed"></div>
  
  <script type="text/javascript">

  google.load("feeds", "1");
  
  
  function initialize() {
  
    feedUrls = ["http://www.digg.com/rss/index.xml","http://feeds.feedburner.com/bharatentrepreneurs"];
    
    var allentries = [];
    
    for(var i=0; i<feedUrls.length; i++)
    {   
		var feed = new google.feeds.Feed(feedUrls[i]);
		feed.setNumEntries(100);
		
		for(var j=0; j<result.feed.entries.length; j++)
		{
			var entry = result.feed.entries[i];
			allentries.push(entry.title);
		}
    }
    
    for(var k=0; k<allentries.length; k++)
	{
		document.write(k);
	}
  }
  google.setOnLoadCallback(initialize);

  </script>
  
  
  
  
  
  
</body>
</html>