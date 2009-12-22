<?php
set_include_path("./application/libraries");
require_once "Zend/Loader.php";
Zend_Loader::loadclass('Zend_Gdata_Photos');
Zend_Loader::loadclass('Zend_Gdata_ClientLogin');
Zend_Loader::loadclass('Zend_Gdata_AuthSub');
$gb = new Zend_Gdata_Photos(null, "Google-DevelopersGuide-1.0");
$query = $gb->newQuery("http://pacasaweb.google.com/data/feed/api/all");
$query->setParam("kind", "photo");
$query->setQuery($tag);
$query->setMaxResults("10");
$userFeed = $gb->gerUserFeed(null, $query);
foreach($userFeed as $photoEntry){
	echo "<p>";
	echo "<a href='".$photoEntry->getLink('alternate')->getHref()."'>Link album</a><BR>";
	if($photoEntry->getMediaGroup()->getContent() != null) {
		$mediaContentArray = $photoEntry->getMediaGroup()->getContent();
		$contentUrl = $mediaContentArray[0]->getUrl();
		echo "<img style='width:300px;' src='".$contentUrl."'>";
	}
	echo "</p>";
}
?>