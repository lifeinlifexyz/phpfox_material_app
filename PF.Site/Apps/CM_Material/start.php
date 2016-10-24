<?php

//Instance settings
Phpfox_Setting::instance()->setParam('cmmaterial.wellcome_title', setting('cm_material_welcome_title', 'Title'));
Phpfox_Setting::instance()->setParam('cmmaterial.wellcome_subtitle', setting('cm_material_welcome_subtitle', 'Sub Title'));
Phpfox_Setting::instance()->setParam('cmmaterial.number_of_blogs', setting('cm_material_number_of_blogs', '6'));
Phpfox_Setting::instance()->setParam('cmmaterial.blog_sort', setting('cm_material_blog_sort', 'latest'));
Phpfox_Setting::instance()->setParam('cmmaterial.number_of_photos', setting('cm_material_number_of_photos', '6'));
Phpfox_Setting::instance()->setParam('cmmaterial.photo_sort', setting('cm_material_photo_sort', 'latest'));

event('app_settings', function ($settings){
    if (isset($settings['cm_material_enabled'])) {
        \Phpfox::getService('admincp.module.process')->updateActivity('cmmaterial', $settings['cm_material_enabled']);
    }
});

group('/cmmaterial', function (){

    route('/admincp', function (){
        auth()->isAdmin(true);
        if(!Phpfox::getService('admincp.product')->isProduct('codemake_cmmaterialv4')){
            if (file_exists(PHPFOX_DIR_XML.'codemake_cmmaterialv4.xml')){
                echo('material module not installed, please install the module on the <a href="'.Phpfox::getLib('url')->makeUrl('admincp').'">dashboard</a>');
            } else {
                echo('material module not installed');
            }
            return 'controller';
        }

        if (!Phpfox_Module::instance()->isModule('cmmaterial')){
            echo('The module is disabled.');
            return 'controller';
        }
        Phpfox_Module::instance()->dispatch('cmmaterial.admincp.section.row');
        return 'controller';
    });

    route('/admincp/section/row', function (){
        auth()->isAdmin(true);
        if(!Phpfox::getService('admincp.product')->isProduct('codemake_cmmaterialv4')){
            if (file_exists(PHPFOX_DIR_XML.'codemake_cmmaterialv4.xml')){
                echo('material module not installed, please install the module on the <a href="'.Phpfox::getLib('url')->makeUrl('admincp').'">dashboard</a>');
            } else {
                echo('material module not installed');
            }
            return 'controller';
        }

        if (!Phpfox_Module::instance()->isModule('cmmaterial')){
            echo('The module is disabled.');
            return 'controller';
        }
        Phpfox_Module::instance()->dispatch('cmmaterial.admincp.section.row');
        return 'controller';
    });

    route('/admincp/section/coll', function (){
        auth()->isAdmin(true);
        if(!Phpfox::getService('admincp.product')->isProduct('codemake_cmmaterialv4')){
            if (file_exists(PHPFOX_DIR_XML.'codemake_cmmaterialv4.xml')){
                echo('material module not installed, please install the module on the <a href="'.Phpfox::getLib('url')->makeUrl('admincp').'">dashboard</a>');
            } else {
                echo('material module not installed');
            }
            return 'controller';
        }

        if (!Phpfox_Module::instance()->isModule('cmmaterial')){
            echo('The module is disabled.');
            return 'controller';
        }
        Phpfox_Module::instance()->dispatch('cmmaterial.admincp.section.coll');
        return 'controller';
    });

});