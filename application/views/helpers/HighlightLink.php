<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class HighlightLink extends AbstractHelper
{
    public function direct($text)
    {
        return preg_replace('~(http://[^ ]+)~si', '<a href="\\1">\\1</a>', $text);
    }
}

