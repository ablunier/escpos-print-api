<?php

$app->post('/print', ['middleware' => 'auth', 'uses' => 'PrintingController@printStream']);
