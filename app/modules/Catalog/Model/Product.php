<?php

class Catalog_Model_Product extends Core_Model_Default
{

    const DISPLAYED_PER_PAGE = 15;

    protected $_instanceSingleton;
    protected $_outlets;
    protected $_category;
    protected $_category_ids;
    protected $_groups;

    public function __construct($datas = array()) {
        parent::__construct($datas);
        $this->_db_table = 'Catalog_Model_Db_Table_Product';
    }

    public function findByCategory($category_id, $use_folder = false, $offset = null) {
        return $this->getTable()->findByCategory($category_id, $use_folder, $offset);
    }

    public function findByValueId($value_id, $pos_id = null, $only_active = false, $with_menus = false) {
        return $this->getTable()->findByValueId($value_id, $pos_id, $only_active, $with_menus);
    }

    public function findByPosId($product_id) {
        $this->uns();
        $row = $this->getTable()->findByPosId($product_id);
        if($row) {
            $this->setData($row->getData());
            $this->setId($row->getId());
        }

        return $this;
    }

    public function findMenus($value_id) {
        return $this->getTable()->findMenus($value_id);
    }

    public function findLastPosition($value_id) {
        return $this->getTable()->findLastPosition($value_id) + 1;
    }

    public function updatePosition($rows) {
    	$this->getTable()->updatePosition($rows);
    	return $this;
    }

    public function getCategory() {

        if(is_null($this->_category)) {
            $this->_category = new Catalog_Model_Category();
            $this->_category->find($this->getCategoryId());
        }

        return $this->_category;
    }

    public function setCategory($category) {
        $this->_category = $category;
        return $this;
    }

    public function getCategoryIds() {
        if(!$this->_category_ids) {
            $this->_category_ids = array();
            if($this->getId()) {
                $this->_category_ids = $this->getTable()->findCategoryIds($this->getId());
            }
        }

        return $this->_category_ids;
    }

    public function getGroups() {

        if(!$this->_groups) {
            $group = new Catalog_Model_Product_Group_Value();
            $this->_groups = $group->findAll(array('product_id' => $this->getId()));
        }

        return $this->_groups;

    }

    public function getType() {
        if(is_null($this->_instanceSingleton)) {
            if(!is_null($this->getData('type'))) {
            $class = 'Catalog_Model_Product_';
            $class .= implode('_', array_map('ucwords', explode('_', $this->getData('type'))));
                $this->_instanceSingleton = new $class();
                $this->_instanceSingleton->setProduct($this);
            }
        }

        return $this->_instanceSingleton;
    }

//    public function getPrice() {
//        if($this->getData('price')) {
//            return $this->formatPrice($this->getData('price'));
//        }
//    }

    public function getMinPrice() {

        if(!$this->getData('min_price')) {
            $min_price = null;
            if($this->getData('type') == 'format') {
                $formats = $this->getType()->getOptions();
                foreach($formats as $format) {
                    if(is_null($min_price)) $min_price = $format->getPrice();
                    else $min_price = min($min_price, $format->getPrice());
                }
                if(is_null($min_price)) $min_price = 0;
            }
            else {
                $min_price = $this->getPrice();
            }

            $groups = $this->getGroups();
            foreach($groups as $group) {

                if(!$group->isRequired()) continue;
                $min_option_price = null;
                foreach($group->getOptions() as $option) {
                    if($option->getPrice()) {
                        if(!$min_option_price) $min_option_price = $option->getPrice();
                        else $min_option_price = min($min_option_price, $option->getPrice());
                    }
                }
                if($min_option_price) $min_price += $min_option_price;
            }

            $this->setMinPrice($min_price);
        }

        return $this->getData('min_price');
    }

    public function checkType() {
        $options = $this->getData('option');
        if(!empty($options)) {
            $this->setType('format');
            $this->getType()->setOptions($options);
        }
    }

    public function getDescription() {
        return stripslashes($this->getData('description'));
    }

    public function getPictureUrl() {
        if($this->getData('picture')) {
            $image_path = Application_Model_Application::getImagePath().$this->getData('picture');
            $base_image_path = Application_Model_Application::getBaseImagePath().$this->getData('picture');
            if(file_exists($base_image_path)) {
                return $image_path;
            }
        }
        return null;
    }

    //If !$all, return only first image
    public function getLibraryPictures($all = true) {
        if($this->getLibraryId()) {
            $library_image = new Media_Model_Library_Image();
            $images = $library_image->findAll(array("library_id" => $this->getLibraryId()));
            $image_list = array();
            foreach($images as $image) {
                $image_path = Application_Model_Application::getImagePath().$image->getLink();
                $image_list[] = array(
                    "id" => $image->getId(),
                    "url" => $image_path
                );
            }
            if(count($image_list) > 0 AND !$all) {
                $image_list = $image_list[0];
            }
            return $image_list;
        }
        return null;
    }

    public function getThumbnailUrl() {
        if($picture = $this->getPictureUrl()) {

            $newIcon = new Core_Model_Lib_Image();
            $newIcon->setId(sha1($picture."_thumbnail"))
                ->setPath(Core_Model_Directory::getBasePathTo($picture))
                ->setWidth(100)
                ->setHeight(100)
                ->crop()
            ;

            return $newIcon->getUrl();
        }
        return null;
    }

    public function save() {

        $this->checkType();

        if(!$this->getIsDeleted()) {
            if (!$this->getPosition()) $this->setPosition($this->findLastPosition($this->getValueId()));

            if (!$this->getData('type')) $this->setData('type', 'simple');
            if ($this->getData('type') == 'simple') {
                $price = Core_Model_Language::normalizePrice($this->getData('price'));
                $this->setData('price', $price);
            }

            //MCommerce multi pictures
            $this->addPictures();
            $this->deletePictures();

            parent::save();

            if ($this->getNewCategoryIds()) {
                $this->getTable()->saveCategoryIds($this->getId(), $this->getNewCategoryIds());
            }
            $this->getType()->setProduct($this)->save();

        } else {
            parent::save();
        }

        return $this;
    }

    public function addPictures() {
        if($picture_list = $this->getPictureList()) {

            if(!($library_id = $this->getLibraryId())) {
                $library = new Media_Model_Library();
                $library->setName("product_".uniqid())->save();
                $library_id = $library->getId();
                $this->setLibraryId($library_id);
            }

            foreach($picture_list as $picture) {

                if($picture != "") {
                    $image = new Media_Model_Library_Image();
                    $img_data = array(
                        "link" => $picture,
                        "can_be_colorized" => 0,
                        "library_id" => $library_id
                    );
                    $image->setData($img_data)->save();
                }

            }
        }
    }

    public function deletePictures() {
        if($picture_list = $this->getRemovePicture()) {
            foreach($picture_list as $picture) {
                if($picture != "") {
                    $image = new Media_Model_Library_Image();
                    $image->find($picture);
                    if($image->getId()) {
                        unlink(Application_Model_Application::getBaseImagePath().$image->getLink());
                        $image->delete();
                    }
                }

            }
        }
    }

    public function deleteAllFormats() {
        if($this->getId()) {
            $this->getTable()->deleteAllFormats($this->getId());
        }
    }

    public function createDummyContents($option_value, $design, $category) {

        $option = new Application_Model_Option();
        $option->find($option_value->getOptionId());

        $dummy_content_xml = $this->_getDummyXml($design, $category);

        if($option->getCode() == "set_meal") {

            foreach ($dummy_content_xml->set_meal->children() as $content) {
                $this->unsData();

                $this->addData((array) $content)
                    ->setValueId($option_value->getId())
                    ->save()
                ;
            }
        }
    }

    public function copyTo($option) {

        $this->copyPictureTo($option);
        $this->setId(null)
            ->setValueId($option->getId())
            ->save()
        ;

        return $this;
    }

    public function copyPictureTo($option) {

        if($image_url = $this->getPictureUrl()) {

            $file = pathinfo($image_url);
            $filename = $file['basename'];

            $relativePath = $option->getRelativePath();
            $folder = Core_Model_Directory::getBasePathTo(Application_Model_Application::PATH_IMAGE.'/'.$relativePath);

            if(!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }

            $img_src = Core_Model_Directory::getBasePathTo($image_url);
            $img_dst = $folder.'/'.$filename;

            if(@copy($img_src, $img_dst)) {
                $this->setPicture($relativePath.'/'.$filename);
            }
        }

    }

}