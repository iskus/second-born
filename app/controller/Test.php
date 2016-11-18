<?php
/**
 * Created by PhpStorm.
 * User: iskus
 * Date: 12.06.15
 * Time: 17:48
 */

namespace app\controller;


use core\Controller;
use core\database\Db;
use core\Model;
use core\sources\UsefulData;

/** 
Сначала нам потребуются 2 таблицы, в одну сложим ссылки, ну а другая для инфы по этим ссылкам.
Кстати, вторую (info_cards), можно разбить тысячи по 3 записей.

*/

// CREATE TABLE `links` (
// `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
// `link` varchar(254) NOT NULL,
// PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8

// CREATE TABLE `info_cards` (
// `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
// `title` varchar(254) NOT NULL,
// `edrpou` varchar(254) NOT NULL,
// `email` varchar(254) NOT NULL,
// `phone` varchar(254) NOT NULL,
// `adress` varchar(254) NOT NULL,
// `reg_adress` varchar(254) NOT NULL,
// `face` varchar(254) NOT NULL,
// `created` varchar(254) NOT NULL,
// PRIMARY KEY (`id`)
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8

class Test extends Controller {
    public $fields;
    public $model;

    public function __construct() {

/** даем скрипту максимальное время на выполнение */
        ini_set('max_execution_time', '0');
        error_reporting(E_ALL);

/** определяем массив соответствия заголовка полю в таблице */
//        $this->fields = [
//            'ЄДРПОУ:' => 'edrpou',
//            'Адреса електронної пошти:' => 'email',
//            'Номер факсу (телефаксу):' => 'phone',
//            'Поштова адреса:' => 'adress',
//            'Юридична адреса:' => 'reg_adress',
//            'Відповідальна особа:' => 'face',
//            'Дата заповнення:' => 'created',
//            'title' => 'title',
//        ];
        $this->parser = new ParserYopta();
        $this->model = new Model();
        parent::__construct();
    }

/** По хорошему сюда надо бы морду какую-то приделать.. */
/** 
TODO Приделать face 
*/


    public function index() {
        $this->getModelsByMarks();
//        if ($what = UsefulData::getRequest('what') == 'links') {
//            $this->getUniqueLinks();
//        } elseif ($what == 'info') {
//            $this->getInfoByLinks();
//        }
    }


    public function getModelsByMarks() {
        $this->model->setDbTable('marks');
        $marks = $this->model->getEntitys();

        foreach ($marks as $mark) {
            echo $mark->name . '<br/>';
        }
    }


    public function getModelsByMark() {
        $this->model->setDbTable('models');
        $models = $this->parser->pq->find('td.search_place > a');

        foreach ($models as $model) {
            echo $model->name . '<br/>';
        }
    }

    public function getMarks() {
        $url = "http://tecdoc.autodoc.ru/";
        $this->parser->setPage($url);

        $elements = $this->parser->pq->find('a');
        $this->model->setDbTable('marks');


        foreach ($elements as $key => $element) {
            $obj = new \stdClass();
            $obj->link = pq($element)->attr('href');
            $obj->name = pq($element)->text();
            echo $obj->name .'<br/>';
            $links[] = $obj;
            if (($key >= 100 && ($key % 100 == 0)) || (count($elements) - 1) == $key) {
                $this->model->addEntitys($links);
                $links = [];
            }

        }
    }

/** Метод достающий уникальные ссылки, уникальность достигается путем использования REPLACE вместо INSERT */
    public function getUniqueLinks() {
        /** Чтобы вытащить все, будем искать по каждой цифре отдельно  */
        for ($i = 0; $i < 10; $i++) {
            /** Формируем, собственно сам УРЛ */
            $url = 'http://email.court.gov.ua/search?utf8=%E2%9C%93&term=' . $i . '&count_page=10';

            /** Создаем объект парсера, конструктор принимает URL, парсер просто обертка для PhpQuery */
            $parser = new ParserYopta($url);
            /** Собираем все необходимые нам линки */
            $elements = $parser->pq->find('div.name > a');

            $this->model->setDbTable('links');
            $links = ['replace' => true];
            /** И пишем в базу */
            foreach ($elements as $key => $element) {
                $obj = new \stdClass();
                $obj->link = "http://email.court.gov.ua" . pq($element)->attr('href');
                $links[] = $obj;
                if (($key >= 100 && ($key % 100 == 0)) || (count($elements) - 1) == $key) {
                    $this->model->addEntitys($links);
                    $links = ['replace' => true];
                }
//                $obj->replace = true;
//                $this->model->addEntity($obj);

            }
        }
    }

/** Метод отрабатывает по ссылкам, которые берет из базы, нужную нам инфу */
    public function getInfoByLinks() {

        for ($i = 0; $i <= 10100; $i += 100) {
            $this->model->setDbTable('links');
            $links = $this->model->getEntitys([], $i, 100);
            $this->model->setDbTable('info_cards');
            //$objects = [];
            /** Практика показала, что на моей тачке лучше инсертить по одной записи, почему-то... */
            foreach ($links as $link) {
                $parser = new ParserYopta($link->link);
                $titleBlock = $parser->pq->find('div#header > div.name');
                $title = pq($titleBlock)->find('div.left')->text() . ' | '
                    . pq($titleBlock)->find('div.actual')->text();
                $obj = new \stdClass();
                $obj->title = $title;
                $rows = $parser->pq->find('div#container > div.row');
                foreach ($rows as $row) {
                    $prop = $this->fields[pq($row)->find('div.left')->text()];
                    $value = pq($row)->find('div.right')->text();
                    $obj->$prop = $value;
                }
                //$objects[] = $obj;
                $this->model->addEntity($obj);
            }
            //$this->model->addEntitys($objects);

        }
    }

}