<?php

namespace Incodiy\Reactiform\Tests;

use Incodiy\Reactiform\FormGenerator;
use PHPUnit\Framework\TestCase;

class FormGeneratorTest extends TestCase
{
    public function testSelectElementGeneration()
    {
        $form = new FormGenerator();
        $form->select('country', ['ID', 'US']);
        
        $elements = $form->getElements();
        
        $this->assertCount(1, $elements);
        $this->assertEquals('select', $elements[0]['type']);
        $this->assertCount(3, $elements[0]['options']); // Termasuk empty option
    }
}