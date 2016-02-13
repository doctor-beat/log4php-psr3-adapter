# log4psr
Making log4php compatible with the psr-3 interface.

Log4php is a great logger but it does not conform to psr-3, the php logger standard interface. This is an adapter that make log4php
compatible, so you can swap your loggers without coding.

$logger = new Logger();
$logger->error('error entry');
