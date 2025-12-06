<?php

namespace App\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class AccountController extends BaseController
{

    public function index(Request $request): Response
    {
        return $this->redirect($this->url("account.settings"));
    }

    public function settings(Request $request): Response
    {
        return $this->html();
    }
}