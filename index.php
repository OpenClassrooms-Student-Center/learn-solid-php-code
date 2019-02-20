<?php

#
# Front Controller
#

require_once 'config/config.php';
require_once 'config/config_db.php';

require_once 'vendor/autoload.php';

header('Location: ' . BASE_URL . 'public/index.php');
