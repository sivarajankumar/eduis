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
    
    public function findPublisher($publisher = NULL,$limit = 10){
        $sql = $this->select()
                    ->distinct()
                    ->from($this->info('name'),array('place_publisher'))
                    ->where('place_publisher like ?','%'.$publisher.'%');
                    
        if ($limit) {
            $sql->limit($limit);
        }
        
        return $sql->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    

    public function findIsbn($isbn = NULL,$limit = 10){
        $sql = $this->select()
                    ->distinct()
                    ->from($this->info('name'),array('isbn_id'))
                    ->where('isbn_id like ?','%'.$isbn.'%');
                    
        if ($limit) {
            $sql->limit($limit);
        }
        
        return $sql->query()->fetchAll(Zend_Db::FETCH_COLUMN);
    }
    
    public function update($data, $where) {
        try {
           $status = parent::update ( $data, $where );
        } catch (Exception $e) {
            if (23000 == $e->getCode()) {
                $this->getLogger()->info('Duplicate ISBN found:'.$where);
                $this->getLogger()->notice('Dependent books are updated to new ISBN and current ISBN deleted');
                try {
                    $newData = array_intersect_key($data, array('isbn_id'=>0));
                    $status = $this->getAdapter()->update('book', $newData , $where );
                    $this->delete($where);
                    return $status;
                } catch (Exception $e) {
                    throw $e;
                }
            }
            throw $e;
        }
        return $status;
    }
}
?>