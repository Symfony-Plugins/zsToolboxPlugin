<?php

class zsUserViewCacheManager extends sfViewCacheManager
{
  public function generateCacheKey($internalUri, $hostName = '', $vary = '', $contextualPrefix = '')
  {
    $key = parent::generateCacheKey($internalUri, $hostName, $vary, $contextualPrefix);
    
    $hostName = $this->getCacheKeyHostNamePart($hostName);

    if ($this->getCacheConfig($internalUri, 'user'))
      $key =  preg_replace('#'.$hostName.'#',
              $hostName.'/'.sfContext::getInstance()->getUser(),
              $key);

    return $key;
  }

  public function addCache($moduleName, $actionName, $options = array())
  {
    parent::addCache($moduleName, $actionName, $options);

    $this->cacheConfig[$moduleName][$actionName]['user'] =
            isset($options['user']) ? $options['user'] : false;
  }
}

