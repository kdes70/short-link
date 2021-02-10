<?php

use App\Services\VirusTotal\VirusTotalUrl;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    $url = 'https://themeforest.net/';

    $virus = new VirusTotalUrl('d764e2e1c6d5055319f98cb6e38e6acd098bd3d4a0bb74bb82a69685d4b7f621');

    $res = $virus->analysis($url);

    dd($res);

});
