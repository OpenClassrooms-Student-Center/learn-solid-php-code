<?php

use Behat\Behat\Context\Context;
use App\Classes\Tools\Database;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @AfterScenario
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
        require_once __DIR__ . '/../../config/config_db.php';

        // empty the database
        $connection = Database::getInstance()->getConnexion();
        $connection->exec('TRUNCATE TABLE albums');
        $connection->exec('TRUNCATE TABLE songs');

        // empty the files
        $files = glob(__DIR__ .'/../../data/*.{jpg,png,gif,mp3}', GLOB_BRACE);
        foreach ($files as $file) {
            if (is_file($file)) {
                @unlink($file);
            }
        }
    }
}
