<?php
function delTree($dir)
{
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

if (Phpfox::getService('admincp.product.process')->delete('codemake_cmmaterialv4')) {
    if (file_exists(PHPFOX_DIR_XML . 'codemake_cmmaterialv4.xml')) {
        unlink(PHPFOX_DIR_XML . 'codemake_cmmaterialv4.xml');
        if (is_dir(PHPFOX_DIR_MODULE . 'cmmaterial')) {
            delTree(PHPFOX_DIR_MODULE . 'cmmaterial');
        }
    }
}