<?php

namespace Delivery\Helper;

class Text
{
    public static function sanitizePhone($phone)
    {
        return preg_replace("/[^0-9]/", "", $phone);
    }
}
