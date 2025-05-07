<?php

namespace Incodiy\Reactiform\Contracts;

interface FormInterface
{
    public function render();
    
    // Basic Inputs
    public function text(string $name, array $attributes = []);
    public function email(string $name, array $attributes = []);
    public function password(string $name, array $attributes = []);
    
    // Select & Options
    public function select(
        string $name, 
        array $options, 
        array $attributes = [], 
        array $selected = []
    );
    
    // File Handling
    public function file(string $name, array $attributes = []);
    
    // Checkbox & Radio
    public function checkbox(
        string $name, 
        array $options, 
        array $attributes = []
    );
    
    public function radio(
        string $name, 
        array $options, 
        array $attributes = []
    );
    
    // Form Structure
    public function open(array $attributes = []);
    public function close(array $buttons = []);
    
    // Advanced Components
    public function richtext(string $name, array $attributes = []);
    public function combobox(string $name, array $attributes = []);
    
    // Validation
    public function withValidation(array $rules, array $messages = []);
}