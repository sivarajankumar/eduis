<?php
class Lib_Model_DbTable_Isbn extends Libz_Base_Model {

    const TABLE_NAME = 'isbn';

    protected $_name = 'isbn';

    public static function getIsbnDetails ($isbn_id) {
        $sql = self::getDefaultAdapter()->select()
            ->from(self::TABLE_NAME)
            ->where('isbn_id = ?', $isbn_id);
        return $sql->query()->fetch();
    }

    public function getBookGdata ($isbn_id) {
        $objGdata = new Zend_Gdata_Books();
        $query = $objGdata->newVolumeQuery();
        $isbnno = 'isbn:' . $isbn_id;
        $query->setQuery($isbnno);
        $feed = $objGdata->getVolumeFeed($query);
        $thumbnail_img = null;
        foreach ($feed as $entry) {
            $thumbnailLink = $entry->getThumbnailLink();
            if ($thumbnailLink) {
                $thumbnail = $thumbnailLink->href;
            } else {
                $thumbnail = null;
            }
            $preview = $entry->getPreviewLink()->href;
            $thumbnail_img = (! $thumbnail) ? '' : '<a href="' . $preview .
             '"><img src="' . $thumbnail . '"/></a>';
        }
        return $thumbnail_img;
    }
}
?>