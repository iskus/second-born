<?php
/** START BLOCK */
$key = 'developer';
$$key = new stdClass();
$$key->nick = 'Iskus';
$$key->email = 'iskus1981@yandex.ru';
$$key->name = 'Anton';
$appConfig[$key] = $developer;
/** END BLOCK */

$obj = 'salt';
$$obj = new stdClass();
$$obj->clean = '14/88';
$$obj->mix = 'WHITE';
$$obj->hash = substr(sha1($$obj->clean . $$obj->mix), 2, 10);
$appConfig[$obj] = $$obj;





