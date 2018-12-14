<?php

function revertPunctuationMarks($str = null) {
    
    if(empty($str))
        return $str;
    
    $marksCount = preg_match_all("/[^\w\d ]/iu", $str, $matches, PREG_OFFSET_CAPTURE);
    if($marksCount === false)
    {
        //mb exception needed
        return $str;
    }
    
    if($marksCount == 0)
    {
        return $str;
    }
    
    $matches = $matches[0];
    $matchesCount = count($matches);
    for($i = 0; $i < ($matchesCount-1)/2; ++$i)
    {
        $str[$matches[$i][1]] = $matches[$matchesCount - 1 - $i][0];
        $str[$matches[$matchesCount - 1 - $i][1]] = $matches[$i][0];
    }
    
    return $str;
}

class Test extends PHPUnit_Framework_TestCase {

    /**
     * @dataProvider revertPunctuationMarksDataProvider
     */
    public function test_revertPunctuationMarks($str, $revertStr) {
        $this->assertEquals($revertStr, revertPunctuationMarks($str));
    }

    public function revertPunctuationMarksDataProvider()
    {
        return array(
            array('', ''),
            array('abc,d.e? f!', 'abc!d?e. f,'),
        );
    }
}
