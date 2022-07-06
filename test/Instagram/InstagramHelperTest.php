<?php

namespace Meta\InstagramSDK;

use PHPUnit\Framework\TestCase;
use Meta\InstagramSDK\InstagramHelper;

class InstagramHelperTest extends TestCase
{
    public function testGetLink()
    {
        $helper = new InstagramHelper(
            '...',
        '...',
        '...');

        $this->assertIsString($helper->getLink());
    }
}
