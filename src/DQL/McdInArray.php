<?php

namespace App\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class McdInArray extends FunctionNode
{
    public $firstArrayExpression = null;
    public $secondArrayExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->firstArrayExpression = $parser->StringExpression(); // (4)
        $parser->match(Lexer::T_COMMA); // (5)
        $this->secondArrayExpression = $parser->StringExpression(); // (6)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'mcd_in_array(' .
            $this->firstArrayExpression->dispatch($sqlWalker) . ', ' .
            $this->secondArrayExpression->dispatch($sqlWalker) .
        ')';
    }
}