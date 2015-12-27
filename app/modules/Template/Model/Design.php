<?php

class Template_Model_Design extends Core_Model_Default {

    const PATH_IMAGE = '/images/templates';

    protected $_blocks;

    public function __construct($params = array()) {
        parent::__construct($params);
        $this->_db_table = 'Template_Model_Db_Table_Design';
        return $this;
    }

    public function findAllWithCategory() {
        $all_templates = $this->findAll();
        $template_a_category = $this->getTable()->findAllWithCategory();
        $final_templates = array();

        foreach($all_templates as $template) {

            $tmp_category_ids = array();
            foreach($template_a_category as $template_category) {
                if($template->getDesignId() == $template_category["design_id"])
                    $tmp_category_ids[] = $template_category["category_id"];
            }
            $template->setCategoryIds( $tmp_category_ids );

            $final_templates[] = $template;
        }

        return $final_templates;
    }

    public function getBlocks() {

        if(!$this->_blocks) {
            $block = new Template_Model_Block();
            $this->_blocks = $block->findByDesign($this->getId());
        }

        return $this->_blocks;

    }

    public function getBlock($name) {

        foreach($this->getBlocks() as $block) {
            if($block->getCode() == $name) return $block;
        }
        return new Template_Model_Block();

    }

    public function getOverview() {
        return Core_Model_Directory::getPathTo(self::PATH_IMAGE.$this->getData('overview'));
    }

    public function getBackgroundImage($base = false) {
        return $base ? Core_Model_Directory::getBasePathTo(self::PATH_IMAGE.$this->getData('background_image')) : Core_Model_Directory::getPathTo($this->getData('background_image'));
    }

    public function getBackgroundImageHd($base = false) {
        return $base ? Core_Model_Directory::getBasePathTo(self::PATH_IMAGE.$this->getData('background_image_hd')) : Core_Model_Directory::getPathTo($this->getData('background_image_hd'));
    }

    public function getBackgroundImageTablet($base = false) {
        return $base ? Core_Model_Directory::getBasePathTo(self::PATH_IMAGE.$this->getData('background_image_tablet')) : Core_Model_Directory::getPathTo($this->getData('background_image_tablet'));
    }

}
