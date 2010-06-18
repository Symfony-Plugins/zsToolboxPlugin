<?php

/**
 * @link http://akrabat.com/php/notes-on-zend_cache/
 */
class zsCache
{

    /**
     * @var boolean
     */
    static protected $_enabled = false;
    /**
     * @var Zend_Cache_Core
     */
    static protected $_cache;

    static function init($enabled, $dir, $lifetime=7200)
    {
        self::$_enabled = $enabled;
        if (self::$_enabled)
        {
            ProjectConfiguration::registerZend();

            $frontendOptions = array(
                'lifetime' => $lifetime,
                'automatic_serialization' => true,
            );
            $backendOptions = array(
                'cache_dir' => $dir,
                'hashed_directory_level' => 2,
            );
            self::$_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        }
    }

    static function getInstance()
    {
        if (self::$_enabled == false)
        {
            return false;
        }
        return self::$_cache;
    }

    static function load($keyName)
    {
        if (self::$_enabled == false)
        {
            return false;
        }
        return self::$_cache->load($keyName);
    }

    static function save($keyName, $dataToStore)
    {
        if (self::$_enabled == false)
        {
            return true;
        }

        return self::$_cache->save($dataToStore, $keyName);
    }

    static function clean()
    {
        if (self::$_enabled == false)
        {
            return;
        }
        self::$_cache->clean();
    }

}
