<?php


namespace DoctorBeat\Log4psr;

use ErrorException;
use Mockery as m;
use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Psr\Log\LogLevel;

class LoggerTest extends PHPUnit_Framework_TestCase {

    /**
     * @var Log4phpPsr3Adapter
     */
    protected $object;
    
    /**
     *
     * @var MockInterface
     */
    protected static $logger;  // = m::mock('Logger');

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Logger();
        
        self::$logger = m::mock('Logger');
        $this->object->setLogger(self::$logger);
    }
    
     function testLogEmergency() {
        self::$logger->shouldReceive('fatal')->once()->withArgs(array('emergency entry', null));
        
        $this->object->emergency('emergency entry');
        
    }
    function testLogAlert() {
        self::$logger->shouldReceive('fatal')->once()->withArgs(array('alert entry', null));
        
        $this->object->alert('alert entry');
        
    }
    function testLogCritical() {
        self::$logger->shouldReceive('fatal')->once()->withArgs(array('critical entry', null));
        
        $this->object->critical('critical entry');
        
    }
    function testLogError() {
        self::$logger->shouldReceive('error')->once()->withArgs(array('error entry', null));
        
        $this->object->error('error entry');
        
    }
    function testLogWarning() {
        self::$logger->shouldReceive('warn')->once()->withArgs(array('warning entry', null));
        
        $this->object->warning('warning entry');
        
    }
    function testLogNotice() {
        self::$logger->shouldReceive('warn')->once()->withArgs(array('notice entry', null));
        
        $this->object->notice('notice entry');
        
    }
    function testLogInfo() {
        self::$logger->shouldReceive('info')->once()->withArgs(array('info entry', null));
        
        $this->object->info('info entry');
        
    }
    function testLogDebug() {
        self::$logger->shouldReceive('debug')->once()->withArgs(array('debug entry', null));
        
        $this->object->debug('debug entry');
        
    }
    function testLogInfo2() {
        self::$logger->shouldReceive('warn')->once()->withArgs(array('notice entry', null));
        
        $this->object->log(LogLevel::NOTICE, 'notice entry');
        
    }
    
    /**
     * @expectedException Psr\Log\InvalidArgumentException
     */
    function testLogInvalidLevel() {
        $this->object->log('NOT_EXSTING', 'notice entry');
        
    }

    function testLogException() {
        $exp = new ErrorException("123");

        self::$logger->shouldReceive('fatal')->once()->withArgs(array('oeps', $exp));
        
        $context = array('exception' => $exp);
        $this->object->emergency('oeps', $context);
        
    }

    function testInterpolate() {

        self::$logger->shouldReceive('info')->once()->withArgs(array("a string, par1: 'value 1', par2: [second value]", null));
        
        $context = array('par1' => 'value 1', 'par2' => 'second value');
        $this->object->info("a string, par1: '{par1}', par2: [{par2}]", $context);
        
    }

    
    
}
