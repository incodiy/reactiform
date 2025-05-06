<?php

namespace Tests;

use Incodiy\Reactiform\FormGenerator;
use Incodiy\Reactiform\Helpers\FormHelper;
use Orchestra\Testbench\TestCase;

class ReactiformTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Incodiy\Reactiform\Providers\FormServiceProvider'];
    }

    /** @test */
    public function test_form_helper_attributes_processing()
    {
        $attributes = FormHelper::processAttributes([
            'class' => 'test',
            'readonly' => true,
            'custom-data' => 'value'
        ]);

        $this->assertEquals([
            'className' => 'test',
            'readOnly' => true,
            'custom-data' => 'value'
        ], $attributes);
    }

    /** @test */
    public function test_form_generator_select_element()
    {
        $form = new FormGenerator();
        $form->select('Test Select', ['option1', 'option2']);
        
        $elements = $form->getElements();
        $select = $elements[0];
        
        $this->assertEquals('select', $select['type']);
        $this->assertArrayHasKey('options', $select);
        $this->assertCount(3, $select['options']); // Including empty option
    }

    /** @test */
    public function test_id_generation_uniqueness()
    {
        $id1 = FormHelper::generateId('test-name');
        $id2 = FormHelper::generateId('test-name');
        
        $this->assertNotEquals($id1, $id2);
    }

    /** @test */
    public function test_react_component_rendering()
    {
        $form = new FormGenerator();
        $form->text('Test Input');
        
        $view = $form->render();
        $this->assertStringContainsString('data-react-component="TextInput"', $view->render());
    }

    /** @test */
    public function test_validation_rules_generation()
    {
        $form = new FormGenerator();
        $form->text('Email', ['rules' => 'required|email']);
        
        $elements = $form->getElements();
        $this->assertEquals(['required', 'email'], $elements[0]['validation']);
    }
}