<?php namespace ProcessWire;
/**
 * Iframe Sidebar for the ProcessWire page edit screen
 *
 * @author Bernhard Baumrock, 02.04.2020
 * @license Licensed under MIT
 * @link https://www.baumrock.com
 */
class RockIframe extends WireData implements Module {
  private $frame;

  public static function getModuleInfo() {
    return [
      'title' => 'RockIframe',
      'version' => '0.0.1',
      'summary' => 'Iframe Sidebar for the ProcessWire page edit screen',
      'autoload' => "template=admin",
      'singular' => true,
      'icon' => 'columns',
      'requires' => [],
      'installs' => [],
    ];
  }

  public function init() {
    $this->addHookAfter("ProcessPageView::execute", $this, "addIframe");
    $url = $this->config->urls($this)."RockIframe.css";
    $this->style = "<link type='text/css' href='$url' rel='stylesheet'>";
  }

  public function addIframe(HookEvent $event) {
    if(!$this->frame) return;
    $html = str_replace("</body>", $this->frame."</body>", $event->return);
    $html = str_replace("</head>", $this->style."</head>", $html);
    $event->return = $html;
  }

  public function show($data) {
    $url = $this->getUrl($data);
    if(!$url) return;
    $this->frame = "<iframe src='$url' class='RockIframe'></iframe>";
  }

  public function getUrl($data) {
    if($data instanceof Pagefiles) return $data->first()->url;
    return $data;
  }
}
