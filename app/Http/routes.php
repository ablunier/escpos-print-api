<?php

$app->group(['middleware' => 'auth'], function () use ($app) {
    $app->post('printers/{printerId}/print', ['uses' => 'PrinterController@printStream']);
});
