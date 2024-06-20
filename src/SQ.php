<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */
namespace Saidqb\Lib;

class SQ
{

    use Common\Accounting;
    use Common\Api;
    use Common\Config;
    use Common\Currency;
    use Common\Date;
    use Common\Firebase;
    use Common\Generate;
    use Common\Manipulation;
    use Common\Notification;
    use Common\Number;
    use Common\Query;
    use Common\Server;
    use Common\Url;

    static function version()
    {
        return '1.0.0';
    }
}
