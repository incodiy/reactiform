<?php

namespace Tests;

use Incodiy\Reactiform\FormGenerator;
use Orchestra\Testbench\TestCase;

class AdvancedComponentsTest extends TestCase
{
    /** @test */
    public function test_richtext_initialization()
    {
        $form = new FormGenerator();
        $form->richtext('content', ['max_length' => 10000]);
        
        $element = $form->getElements()[0];
        $this->assertEquals('richtext', $element['type']);
        $this->assertEquals(10000, $element['max_length']);
    }

    /** @test */
    public function test_combobox_async_config()
    {
        $form = new FormGenerator();
        $form->combobox('tags', [], ['async_source' => '/api/search']);
        
        $element = $form->getElements()[0];
        $this->assertEquals('/api/search', $element['async_source']);
        $this->assertTrue($element['tags']);
    }

    /** @test */
    public function test_multifile_validation_rules()
    {
        $form = new FormGenerator();
        $form->multifile('docs', ['max_files' => 5]);
        
        $element = $form->getElements()[0];
        $this->assertEquals(
            'required|array|max:5', 
            $element['attributes']['data-rules']
        );
    }
}