<?php

require_once 'HTMLPurifier/ChildDefHarness.php';
require_once 'HTMLPurifier/ChildDef/Custom.php';

class HTMLPurifier_ChildDef_CustomTest extends HTMLPurifier_ChildDefHarness
{
    
    function test() {
        
        $this->obj = new HTMLPurifier_ChildDef_Custom('(a,b?,c*,d+,(a,b)*)');
        
        $this->assertResult('', false);
        $this->assertResult('<a /><a />', false);
        
        $this->assertResult('<a /><b /><c /><d /><a /><b />');
        $this->assertResult('<a /><d>Dob</d><a /><b>foo</b>'.
          '<a href="moo" /><b>foo</b>');
        
    }
    
    function testNesting() {
        $this->obj = new HTMLPurifier_ChildDef_Custom('(a,b,(c|d))+');
        $this->assertResult('', false);
        $this->assertResult('<a /><b /><c /><a /><b /><d />');
        $this->assertResult('<a /><b /><c /><d />', false);
    }
    
    function testNestedEitherOr() {
        $this->obj = new HTMLPurifier_ChildDef_Custom('b,(a|(c|d))+');
        $this->assertResult('', false);
        $this->assertResult('<b /><a /><c /><d />');
        $this->assertResult('<b /><d /><a /><a />');
        $this->assertResult('<b /><a />');
        $this->assertResult('<acd />', false);
    }
    
    function testNestedQuantifier() {
        $this->obj = new HTMLPurifier_ChildDef_Custom('(b,c+)*');
        $this->assertResult('');
        $this->assertResult('<b /><c />');
        $this->assertResult('<b /><c /><c /><c />');
        $this->assertResult('<b /><c /><b /><c />');
        $this->assertResult('<b /><c /><b />', false);
    }
    
    function testEitherOr() {
        
        $this->obj = new HTMLPurifier_ChildDef_Custom('a|b');
        $this->assertResult('', false);
        $this->assertResult('<a />');
        $this->assertResult('<b />');
        $this->assertResult('<a /><b />', false);
        
    }
    
    function testCommafication() {
        
        $this->obj = new HTMLPurifier_ChildDef_Custom('a,b');
        $this->assertResult('<a /><b />');
        $this->assertResult('<ab />', false);
        
    }
    
}

?>