<pre><?PHP
include 'flickr.php';
$a = new flickr('3cd89929c55171eba5c13786abc4d2ae');
echo 'SEARCH:<BR>';
print_r($a->search('gentoo'));

echo 'getRecent:<BR>';
print_r($a->getRecent(10));

echo 'getInfo:<BR>';
print_r($a->getInfo(142796681));
?>