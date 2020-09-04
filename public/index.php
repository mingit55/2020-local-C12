<?php
session_start();

define("_ROOT", dirname(__DIR__));
define("_SRC", _ROOT."/src");
define("_VIEW", _SRC ."/View");
define("_UPLOADS", _ROOT."/public/uploads");

require _SRC."/autoload.php";
require _SRC."/helper.php";
require _SRC."/web.php";
