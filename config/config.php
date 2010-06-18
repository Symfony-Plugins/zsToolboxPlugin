<?php
if (sfConfig::get('app_zs_toolbox_use_cache'))
    zsCache::init(true, sfConfig::get('sf_cache_dir') . DIRECTORY_SEPARATOR . sfConfig::get('app_zs_toolbox_cache_dir', 'zend'));