<?php

class zsUserCacheConfigHandler extends sfCacheConfigHandler
{
  public function execute($configFiles)
  {
    $retval = parent::execute($configFiles);

    return strtr($retval, array('sfCacheConfigHandler' => 'zsCacheConfigHandler'));
  }

  protected function addCache($actionName = '')
  {
    $data = array();

    // enabled?
    $enabled = $this->getConfigValue('enabled', $actionName);

    // cache with or without loayout
    $withLayout = $this->getConfigValue('with_layout', $actionName) ? 'true' : 'false';

    // lifetime
    $lifeTime = !$enabled ? '0' : $this->getConfigValue('lifetime', $actionName, '0');

    // client_lifetime
    $clientLifetime = !$enabled ? '0' : $this->getConfigValue('client_lifetime', $actionName, $lifeTime, '0');

    // contextual
    $contextual = $this->getConfigValue('contextual', $actionName) ? 'true' : 'false';

    // user
    $user = $this->getConfigValue('user', $actionName) ? 'true' : 'false';

    // vary
    $vary = $this->getConfigValue('vary', $actionName, array());
    if (!is_array($vary))
    {
      $vary = array($vary);
    }

    // add cache information to cache manager
    $data[] = sprintf("\$this->addCache(\$moduleName, '%s', array('withLayout' => %s, 'lifeTime' => %s, 'clientLifeTime' => %s, 'user' => %s, 'contextual' => %s, 'vary' => %s));\n",
                      $actionName, $withLayout, $lifeTime, $clientLifetime, $user, $contextual, str_replace("\n", '', var_export($vary, true)));

    return implode("\n", $data);
  }
}
