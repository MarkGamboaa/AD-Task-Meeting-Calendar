<?php
define('BASE_PATH', realpath(__DIR__));
define('HANDLERS_PATH', realpath(BASE_PATH . "/handlers"));
define('UTILS_PATH', realpath(BASE_PATH . "/utils"));
define('DUMMIES_PATH', realpath(BASE_PATH . "/staticDatas/dummies"));
define('COMPONENTS_PATH', realpath(BASE_PATH . "/components"));
define('LAYOUTS_PATH', realpath(BASE_PATH . "/layouts"));
define('ASSETS_PATH', realpath(BASE_PATH . "/assets"));
define('ERRORS_PATH', realpath(BASE_PATH . "/errors"));

chdir(BASE_PATH);
