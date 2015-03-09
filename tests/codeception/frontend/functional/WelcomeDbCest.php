<?php
namespace tests\codeception\frontend;
use frontend\models\db\dao\CollectionUtil;

class WelcomeDbCest extends \Codeception\TestCase\Test
{
/*    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }*/

    // tests
    public function tryToTest(FunctionalTester $I)
    {
        $a = new CollectionUtil();
        $this->assertFalse($a == null);
    }
}