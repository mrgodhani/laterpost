<?php namespace LaterPost\Api;


use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use Helpers,ValidatesRequests;
}