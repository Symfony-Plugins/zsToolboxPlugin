<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'markdown.php';

/**
 * Description of zsMarkdownRendererclass
 *
 * @author kbond
 */
class zsMarkdownRenderer
{
  public static function convertToHtml($markdown)
  {
    $html = Markdown($markdown);

    //replace special boxes with a class
    $html = preg_replace(
        '#<blockquote>\s*<p><strong>(info|note|tip)\:?</strong>\:?#si',
        '<blockquote class="$1"><p>',
        $html);

    // Fix spacer
    $html = str_replace('<p>-</p>', '', $html);

    $html = preg_replace_callback('#<pre><code>(.+?)</code></pre>#s', array('zsMarkdownRenderer', 'highlightPhp'), $html);

    return $html;
  }

  public static function highlightPhp($matches)
  {
    return self::geshiCall($matches);
  }

  static protected function highlightYaml($matches)
  {
    $yaml = is_string($matches) ? $matches:$matches[1];

    if ($formatted = sfSympalYamlSyntaxHighlighter::highlight($yaml))
    {
      return $formatted;
    } else
    {
      return $matches[0];
    }
  }

  static protected function geshiCall($matches, $default = '')
  {
    if (preg_match('/^\[(.+?)\]\s*(.+)$/s', $matches[1], $match))
    {
      if ($match[1] == 'yaml' || $match[1] == 'yml')
      {
        return self::highlightYaml($match[2]);
      }

      else
      {
        $code = self::getGeshi(html_entity_decode($match[2]), $match[1]);

        //remove space (bug in Geshi?)
        $code = str_replace('&nbsp;</pre>', '</pre>', $code);
        return $code;
      }
    }
    else
    {
      if ($default)
      {
        return self::getGeshi(html_entity_decode($matches[1]), $default);
      }
      else
      {
        return "<pre><code>".$matches[1].'</code></pre>';
      }
    }
  }

  static protected function getGeshi($text, $language)
  {
    if ('html' == $language)
    {
      $language = 'html4strict';
    }

    $geshi = new GeSHi($text, $language);
    $geshi->enable_classes();

    // disable links on PHP functions, HTML tags, ...
    $geshi->enable_keyword_links(false);

    return @$geshi->parse_code();
  }
}
