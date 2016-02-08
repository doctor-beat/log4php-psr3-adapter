<?php

namespace DoctorBeat\Log4phpPsr3Adapter;

use Exception;
use Logger;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

class Log4phpPsr3Adapter extends AbstractLogger {
    const EXCEPTION_KEY = 'exception'; 
    
    /**
     *
     * @var Logger;
     */
    private $logger;

    public function __construct($logger = 'main', $config = null) {
        Logger::configure($config);
        $this->logger = Logger::getLogger($logger);
    }
    
    public function log($level, $message, array $context = array()) {
        // PSR-3 states that $message should be a string
        $message = (string) $message;
        
        $exception = null;
        if (isset($context[self::EXCEPTION_KEY]) && $context[self::EXCEPTION_KEY] instanceof Exception) {
            $exception = $context[self::EXCEPTION_KEY];
        }
         
        $message = $this->interpolate($message, $context);
        
        switch ($level) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
                $this->logger->fatal($message, $exception);
                break;
            case LogLevel::ERROR:
                $this->logger->error($message, $exception);
                break;
            case LogLevel::WARNING:
            case LogLevel::NOTICE:
                $this->logger->warn($message, $exception);
                break;
            case LogLevel::INFO:
                $this->logger->info($message, $exception);
                break;
            case LogLevel::DEBUG:
                $this->logger->debug($message, $exception);
                break;
            default:
                // PSR-3 states that we must throw a
                // PsrLogInvalidArgumentException if we don't
                // recognize the level
                throw new InvalidArgumentException("Unknown loglevel level '$level'");
        }        
    }
    
    function setLogger($logger) {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Interpolates context values into the message placeholders.
     * @param String $message
     * @param array $context
     * @return String
     */
    protected function interpolate($message, array $context = array()){
        // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
    
}
