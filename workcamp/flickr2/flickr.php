<?PHP
class flickr
{
public function __construct($api_key)
	{
	$this->api_key = $api_key;
	}
public function search($query)
	{
	$x = simplexml_load_file('http://www.flickr.com/services/rest/?method=flickr.photos.search&text='.$query.'&api_key='.$this->api_key);
	$ret['total'] = (int)$x->photos['total'];
	foreach($x->photos->photo as $res)
		{
		$r[] = array('id' => (int)$res['id'], 'title' => (string)$res['title'], 'owner' => (string)$res['owner'], 'secret' => (string)$res['secret']);
		}
	$ret['img'] = $r;
	return $ret;
	}
public function getContext($photo_id)
	{
	$x = simplexml_load_file('http://www.flickr.com/services/rest/?method=flickr.photos.getContext&photo_id='.$photo_id.'&api_key='.$this->api_key);
	$ret = array('prev' => array('id' => (int)$x->prevphoto['id'], 'title' => (string)$x->prevphoto['title'], 'url' => (string)$x->prevphoto['url'], 'thumb' => (string)$x->prevphoto['thumb']), 'next' => array('id' => (int)$x->nextphoto['id'], 'title' => (string)$x->nextphoto['title'], 'url' => (string)$x->nextphoto['url'], 'thumb' => (string)$x->nextphoto['thumb']));
	return $ret;
	}
public function getSizes($photo_id)
	{
	$x = simplexml_load_file('http://www.flickr.com/services/rest/?method=flickr.photos.getSizes&photo_id='.$photo_id.'&api_key='.$this->api_key);
	foreach($x->sizes->size as $res)
		{
		$ret[] = array('width' => (int)$res['width'], 'height' => (int)$res['height'], 'source' => (string)$res['source'], 'url' => (string)$res['url']);
		}
	return $ret;
	}
public function getInfo($photo_id)
	{
	$x = simplexml_load_file('http://www.flickr.com/services/rest/?method=flickr.photos.getInfo&photo_id='.$photo_id.'&api_key='.$this->api_key);
	$ret = array('secret' => (string)$x->photo['secret'], 'dateuploaded' => (int)$x->photo['dateuploaded'], 'url' => (string)$x->photo->urls->url,
	'owner' => array('nsid' => (int)$x->photo->owner['nsid'], 'username' => (string)$x->photo->owner['username'], 'realname' => (string)$x->photo->owner['realname'], 'location' => (string)$x->photo->owner['location']));
	return $ret;
	}
public function getRecent($per_page)
	{
	$x = simplexml_load_file('http://www.flickr.com/services/rest/?method=flickr.photos.getRecent&per_page='.$per_page.'&api_key='.$this->api_key);
	foreach($x->photos->photo as $res)
		{
		$ret[] = array('id' => (int)$res['id'], 'title' => (string)$res['title'], 'owner' => (string)$res['owner'], 'secret' => (string)$res['secret']);
		}
	return $ret;
	}
/*Authentication*/
public function createAuthLink($secret, $perms = 'write')
	{
	$sig = md5($secret.'api_key'.$this->api_key.'perms'.$perms);
	return 'http://flickr.com/services/auth/?api_key='.$this->api_key.'&perms='.$perms.'&api_sig='.$sig;
	}
public function getToken($frob, $secret)
	{
	$sig = md5($secret.'api_key'.$this->api_key.'frob'.$frob.'methodflickr.auth.getToken');
	$x = simplexml_load_file('http://www.flickr.com/services/rest/?method=flickr.auth.getToken&frob='.$_GET['frob'].'&api_key='.$this->api_key.'&api_sig='.$sig);
	return (string)$x->auth->token;
	}
}
?>