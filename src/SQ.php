<?php 
/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */
namespace Saidqb\Lib;

class SQ
{
    use 
    Common\Accounting,
    Common\Api,
    Common\Config,
    Common\Date,
    Common\Generate,
    Common\Manipulation,
    Common\Number,
    Common\Query,
    Common\Url,
    Common\Server,
    Common\Firebase;

    static function version(){
        return '1.0.0';
    }
}