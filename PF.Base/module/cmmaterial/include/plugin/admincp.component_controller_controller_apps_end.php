<?php
foreach ($allApps as $iKey=>$app){
    if ($app->id == '__module_cmmaterial'){
        unset($allApps[$iKey]);
    }
}