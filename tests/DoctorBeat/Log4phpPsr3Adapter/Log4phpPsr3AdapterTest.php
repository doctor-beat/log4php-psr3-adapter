<?php


namespace DoctorBeat\Log4phpPsr4Adapter;

use Logger;
use PHPUnit_Framework_TestCase;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-02-04 at 16:11:43.
 */
class Log4phpPsr4AdapterTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Log4phpPsr4Adapter
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Log4phpPsr4Adapter();
    }

//protected function tearDown2()
//{

    
    function testMe() {
        //$this->object = Logger::getLogger('main'); /* @var $logger Logger */
        $this->object->emergency('emergency entry');
        $this->object->alert('alert entry');
        $this->object->critical('critical entry');

        $this->object->warning('warning entry');
        $this->object->notice('notice entry');
        $this->object->info('info entry');
            
        $this->object->debug('debug entry');
            
    }
}