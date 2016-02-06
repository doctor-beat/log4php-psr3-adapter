<?php

namespace DoctorBeat\Log4phpPsr3Adapter;

use Logger;
use Psr\Log\AbstractLogger;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LogLevel;

class Log4phpPsr3Adapter extends AbstractLogger {
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
        
        $throwable = null;//todo
        
        //todo: interpolate
        
        switch ($level) {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
                $this->logger->fatal($message, $throwable);
                break;
            case LogLevel::ERROR:
                $this->logger->error($message, $throwable);
                break;
            case LogLevel::WARNING:
                $this->logger->warn($message, $throwable);
                break;
            case LogLevel::NOTICE:
            case LogLevel::INFO:
                $this->logger->info($message, $throwable);
                break;
            case LogLevel::DEBUG:
                $this->logger->debug($message, $throwable);
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


    
}
