<?php

namespace Tests;

use StrannyiTip\Helper\Type\SimpleString;

class SimpleStringTest extends \Codeception\Test\Unit
{
    private SimpleString $string;

    public function _before(): void
    {
        $this->string = new SimpleString('will work for eat');
    }

    public function testReplace()
    {
        $this->assertEquals('will work for dream', (string)$this->string, 'Check for replace');
    }

    public function testGet_source()
    {
        $this->assertEquals('will work for eat', (string)$this->string, 'Check for get_source');
    }

    public function testIs_start_with()
    {
        $this->assertTrue($this->string->is_start_with('will'), 'Check for is_start_with');
    }

    public function test__toString()
    {
        $this->assertEquals('will work for eat', (string)$this->string, 'Check for __toString work');
    }

    public function testIs_empty()
    {
        $this->assertTrue((new SimpleString(''))->is_empty(), 'Check for empty string is empty');
        $this->assertFalse((new SimpleString('little cosmic cookies'))->is_empty(), 'Check for not empty string is not empty');
    }

    public function testSplit()
    {
        $this->assertEquals([
            'will',
            'work',
            'for',
            'eat'
        ], $this->string->split(''), 'Check for empty split is worked');
        $test_object = new SimpleString('one,two,three');
        $this->assertEquals([
            'one',
            'two',
            'three'
        ], $this->string->split(','), 'Check for split is worked use delimiter');
    }

    public function testPrepend()
    {
        $this->assertEquals('will work for eat', (string)$this->string, 'Check for string is setted and not changed');
        $this->assertEquals('I will work for eat', (string)$this->string->prepend('I '), 'Check for string prepended');
    }

    public function testReplace_regex()
    {
        $this->assertEquals('want work for eat', (string)$this->string->replace_regex('|will|miu', function(string $match) {
            return 'want';
        }));
    }

    public function testClone()
    {
        $this->assertObjectEquals($this->string, $this->string->clone(), 'Check for clone is equals source');
    }

    public function testAppend()
    {
        $this->assertEquals('will work for eat', (string)$this->string, 'Check for string is setted and not changed');
        $this->assertEquals('will work for eat forever', (string)$this->string->append(' forever'), 'Check for string appended');
    }

    public function testToJSONArray()
    {
        $test_array = [
            'field' => 'first',
            'value' => 'second'
        ];
        $test_object = new SimpleString(\json_encode($test_array));
        $this->assertEquals($test_array, $test_object->toJSONArray(), 'Check for array convert to json and back without changes');
    }

    public function test__construct()
    {
        $this->assertEquals('will work for eat', (string)$this->string, 'Check for string initialized');
    }

    public function testIs_match_regex()
    {
        $this->assertTrue($this->string->is_match_regex('|wi[a-z]+|miu'), 'Check for pattern find is work');
    }

    public function testToJSONObject()
    {
        $test_array = [
            'field' => 'first',
            'value' => 'second'
        ];
        $test_object = new \StdClass();
        $test_object->field = 'first';
        $test_object->value = 'second';
        $string_object = new SimpleString(\json_encode($test_array));
        $this->assertEquals($test_object, $string_object->toJSONObject(), 'Check for array convert to object without changes');
    }

    public function testCut()
    {
        $this->assertEquals('will', (string)$this->string->cut(0, 4), 'Check for string is cutted');
    }

    public function testIs_ends_with()
    {
        $this->assertTrue($this->string->is_ends_with('eat'), 'Check what true is true');
        $this->assertFalse($this->string->is_ends_with('some'), 'Check what false is false');
    }

    public function testLength()
    {
        $this->assertEquals(17, $this->string->length(), 'Check for string length is 17');
        $this->assertEquals(\strlen((string)$this->string), $this->string->length(), 'Check for string length is equal strlen');
    }

    public function testTo_array()
    {
        $this->assertEquals([
            'will',
            'work',
            'for',
            'eat'
        ], $this->string->to_array());
    }

    public function testContains()
    {
        $this->assertTrue($this->string->contains('will'), 'Check for string contains string');
        $this->assertTrue($this->string->contains('work'), 'Check for string contains string');
        $this->assertTrue($this->string->contains('for'), 'Check for string contains string');
        $this->assertTrue($this->string->contains('eat'), 'Check for string contains string');
    }

    public function testIs_equal()
    {
        $this->assertTrue($this->string->is_equal('will work for eat'), 'Check for equals');
    }

    public function testIs_numeric()
    {
        $numeric_string = new SimpleString('001');
        $not_numeric_string = new SimpleString('happy');
        $this->assertTrue($numeric_string->is_numeric(), 'Check for numeric is numeric');
        $this->assertFalse($not_numeric_string->is_numeric(), 'Check for not numeric is not numeric');
    }
}
