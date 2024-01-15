<?php /* Template Name:  Test */ 

echo 'test';

class Automate_life_accordion {
    
    public $accordionTitle, $parent, $child;

    function __construct($accordionTitle, $parent = null, $child) {
        $this->accordionTitle = $accordionTitle;
        $this->parent = $parent;
        $this->child = $child;
    }

    function new_accordion() {
        return '<div class="a">'.
        '<h1>'.$this->accordionTitle.'</h1>'.
        $this->inner_accordion().
        '</div>';
    }

    function inner_accordion() {
        return '<h2>'.$this->child.'</h2>';
    }

    function font_size() {
        return '<div>'.
        '<h1>'.$this->accordionTitle.'</h1>'.
        $this->inner_accordion().
        $this->inner_accordion().
        $this->inner_accordion().
        '</div>';
    }
    function colors() {
        return '<div>'.
        '<h1>'.$this->accordionTitle.'</h1>'.
        $this->inner_accordion().
        $this->inner_accordion().
        $this->toggle().
        '</div>';
    }

    function toggle() {
        return '<h3>Toggle box</h3>';
    }
}

$x = new Automate_life_accordion('font typo', null, 'child');
echo $x->font_size();
echo $x->colors();
$y = new Automate_life_accordion('colors', null, 'child 2');
echo $y->colors();