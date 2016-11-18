<?php
namespace core;
require_once(PATH_TO_LIBS . 'phpQuery/phpQuery/phpQuery.php');

class View
{
    public $data;

    public function __construct()
    {
        $this->template = PATH_TO_TEMPLATES
            . strtolower(App::$controller . '/' . App::$action . '.htm');
        $pathToTempl = PATH_TO_TEMPLATES;
        if (App::$shadow == "shadow") {
            $pathToTempl .= '/' . App::$shadow;
        }
        $this->page = \phpQuery::newDocumentFileHTML($pathToTempl . '/index.htm');
        $this->page['header']->append(file_get_contents($pathToTempl . '/header.htm'));
        $this->page['footer']->append(file_get_contents($pathToTempl . '/footer.htm'))
            ->append($this->getMyMark());
        if (is_file($this->template))
            $this->page['#content']->append(file_get_contents($this->template));
        if (App::$shadow != 'shadow') {
            $this->addScripts();
            $this->addStyles();
            $shadow = pq("<div/>")->addClass('shadow');
            $this->page['body']->append($shadow);
        }
        //$this->createContent();

    }

    public function getMyMark()
    {
        return pq('<div/>')->addClass('my-mark');
    }

    public function addScripts()
    {
        require_once PATH_TO_TEMPLATES . 'script.php';
        foreach ($scripts as $script) {
            $this->page['head']->append(pq('<script>')->attr('src', '/web/js/' . $script . '.js'));

        }
    }

    public function addStyles()
    {
        require_once PATH_TO_TEMPLATES . 'css.php';
        foreach ($styles as $style) {
            $this->page['head']->append(
                pq('<link/>')->attr('href', '/web/css/' . $style . '.css')
                    ->attr('rel', 'stylesheet')->attr('type', 'text/css'));

        }
    }

    public function createContent()
    {

        print \phpQuery::getDocument($this->page->getDocumentID());
    }
}