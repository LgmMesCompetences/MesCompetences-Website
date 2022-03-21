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
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $this->firstArrayExpression = $parser->StringExpression();
        $parser->match(Lexer::T_COMMA);
        $this->secondArrayExpression = $parser->StringExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 
        'mcd_in_array('.
            $this->firstArrayExpression->dispatch($sqlWalker). 
            ', '.
            $this->secondArrayExpression->dispatch($sqlWalker).
        ')';
    }
}