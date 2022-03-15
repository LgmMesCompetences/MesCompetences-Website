<?php

namespace App\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;

class GroupConcat extends FunctionNode
{
    protected $isDistinct = false;
    protected $expression = null;

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return sprintf('GROUP_CONCAT(%s%s)',
            $this->isDistinct ? 'DISTINCT ' : '',
            $this->expression->dispatch($sqlWalker)
        );
    }

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);

        $lexer = $parser->getLexer();
        if ($lexer->isNextToken(Lexer::T_DISTINCT)) {
            $parser->match(Lexer::T_DISTINCT);
            $this->isDistinct = true;
        }

        $this->expression = $parser->SingleValuedPathExpression();
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }
}