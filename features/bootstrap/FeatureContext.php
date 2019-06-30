<?php

use Behat\Behat\Context\Context;
use App\Classes\Tools\Database;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

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
     * @BeforeScenario
     */
    public function initDB(BeforeScenarioScope $scope)
    {
        require_once __DIR__ . '/../../config/config.php';
        require_once __DIR__ . '/../../config/config_db.php';
    }

    /**
     * @AfterScenario
     */
    public function cleanDB(AfterScenarioScope $scope)
    {
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
