<?php
namespace App\Test\TestCase\View\Helper;
use App\View\Helper\ProgressHelper;
use Cake\TestSuite\TestCase;

// use PHPUnit\Framework\TestCase;

use Cake\View\View;



class ProgressHelperTest extends TestCase
{

    public function setUp()
    {
        
        parent::setUp();
        $View = new View();
        $this->Progress = new ProgressHelper($View);

    }


    public function testBar()
    {

        $result = $this->Progress->bar(90);
        $this->assertContains('width: 90%', $result);
        $this->assertContains('progress-bar', $result);
        $result = $this->Progress->bar(33.3333333);
        $this->assertContains('width: 33%', $result);

    }




}