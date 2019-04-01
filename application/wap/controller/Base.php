<?php

namespace  app\wap\controller;
use think\Controller;
class Base extends Controller{
    private $_config;
    public function __construct(){
        $this->_config=load_config();
        parent::__construct();
    }
}