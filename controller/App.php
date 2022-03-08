<?php
header('Content-Type: text/html; charset=utf-8');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "vendor/autoload.php";
require "controller/Template.php";
require "models/helper/DB.php";
require "controller/Routes.php";
require "controller/Helper.php";
require "controller/KeepSession.php";

/** 
 * App is a instance class to init the Application
 * 
 * @author Roiner Adrianza <roineradrianzap@gmail.com>
 * 
 * @version Release: 1.0.0 
 * 
 * @access public
 */

class App
{

    /** 
     * Init the App 
     * 
     * @access public
     *  
     */
    public function __construct()
    {
        new KeepSession();
        new Routes();
    }
}
