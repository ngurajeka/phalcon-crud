<?php
/**
 * ReversalQueryBuilder Trait
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud\Helpers;


use Ng\Phalcon\Models\NgModel;
use Ng\Query\Condition\SimpleCondition;
use Ng\Query\Operator;
use Ng\Query\Query;

/**
 * ReversalQueryBuilder Trait
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
trait ReversalQueryBuilder
{
    /**
     * Build Query to Filter by Current Active Row
     *
     * @param Query     &$query
     * @param NgModel   $model
     *
     * @return void
     */
    protected function filterCurrent(Query &$query, NgModel $model)
    {
        if (!$model::useHistorical()) {
            return;
        }

        $field  = $model::getCurrentField();
        $cond   = new SimpleCondition(
            $field, Operator::OP_EQUALS, $model::CURRENT_ACTIVE
        );
        $query->addCondition($cond);
    }

}
