<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @method \Illuminate\Http\RedirectResponse redirect($to = null, $status = 302, $headers = [], $secure = null)
 * @method \Illuminate\View\View view($view = null, $data = [], $mergeData = [])
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
