<?php 
require_once('src/Model/XmlSkierLogs.php');
/**
  * This file is a part of the code used in IMT2571 Assignment 5.
  *
  * @author Rune Hjelsvold
  * @version 2018
  */

/**
  * Unit test class. The tests assume that the provided XML file is loaded
  * in the XmlSkierLogs object.
  */
class Assignment5Test extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    /**
     * @var \XmlSkierLogs The assignment class to be tested
     */
    protected $model;
    
    protected function _before()
    {
        // Load the XML file for every test
        $this->model = new XmlSkierLogs('SkierLogs.xml');
    }

    protected function _after()
    {
    }

    /**
     * Function testing that club loading seem to work as expected.
     */
    public function testClubs()
    {
        $clubs = $this->model->getClubs();
        $this->assertEquals(4, sizeOf($clubs));
        $club = $clubs[1];
        $this->assertEquals('lhmr-ski', $club->id);
        $this->assertEquals('Lillehammer Skiklub', $club->name);
        $this->assertEquals('Lillehammer', $club->city);
        $this->assertEquals('Oppland', $club->county);  
    }
        
}
