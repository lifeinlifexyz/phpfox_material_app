<?php
namespace Apps\CM_Material;

use Core\App;

/**
 * Class Install
 * @author  Neil
 * @version 4.5.0
 * @package Apps\CM_Material
 */
class Install extends App\App
{
    private $_app_phrases = [

    ];
    protected function setId()
    {
        $this->id = 'CM_Material';
    }
    protected function setAlias()
    {

    }
    protected function setName()
    {
        $this->name = 'CM Material Template App';
    }
    protected function setVersion() {
        $this->version = '4.0.4';
    }
    protected function setSupportVersion() {
        $this->start_support_version = '4.2.0';
        $this->end_support_version = '4.5.0';
    }
    protected function setSettings() {
        $this->settings = ['cm_material_enabled' => ['info' => 'Material App Enabled','type' => 'input:radio','value' => '1','js_variable' => '1',],'cm_material_welcome_title' => ['info' => 'Welcome Title','value' => 'Material Kit',],'cm_material_welcome_subtitle' => ['info' => 'Welcome Sub Title','value' => 'Start Your Development With A Badass Bootstrap UI Kit inspired by Material Design.',],'cm_material_number_of_blogs' => ['info' => 'Number Of Blogs On The Index Visitor','value' => '6',],'cm_material_blog_sort' => ['info' => 'Sort Blogs','value' => 'latest','type' => 'select','options' => ['most_discussed' => 'Most Discussed','most_viewed' => 'Most Viewed','latest' => 'Latest',],],'cm_material_number_of_photos' => ['info' => 'Number of photos','value' => '6',],'cm_material_photo_sort' => ['info' => 'Sort Photos','value' => 'latest','type' => 'select','options' => ['most_discussed' => 'Most Discussed','most_viewed' => 'Most Viewed','latest' => 'Latest',],],];
    }
    protected function setUserGroupSettings() {

    }
    protected function setComponent() {

    }
    protected function setComponentBlock() {

    }
    protected function setPhrase() {
        $this->phrase = $this->_app_phrases;
    }
    protected function setOthers() {
        $this->admincp_route = '/cmmaterial/admincp/section/row';
        $this->admincp_menu = ['Section Type Row' => '/cmmaterial/section/row/','Section Type Coll' => '/cmmaterial/section/coll/',];
//        $this->icon = '//cdn.codemake.org/phpfox/cmmaterial/default.png';
        $this->_publisher = 'CodeMake.Org';
        $this->_publisher_url = 'http://codemake.org/';
    }
    public $store_id = '1625';
    public $vendor = '<a href="//codemake.org" target="_blank">CodeMake.Org</a> - See all our products <a href="//store.phpfox.com/techie/u/ecodemaster" target=_new>HERE</a> - contact us at: support@codemake.org';
}