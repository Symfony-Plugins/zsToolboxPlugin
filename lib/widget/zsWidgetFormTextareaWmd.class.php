<?php

class zsWidgetFormTextareaWmd extends sfWidgetFormTextarea
{
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $ret = parent::render($name, $value, $attributes, $errors);

    $ret .=
        "<script type='text/javascript'>
          $(document).ready(function() {
            Attacklab.wmd.editor(document.getElementById('".$this->generateId($name)."'));";

    return $ret.
        "});</script>";
  }

  public function getJavascripts()
  {
    return array('/zsToolboxPlugin/js/wmd/wmd.js');
  }
}