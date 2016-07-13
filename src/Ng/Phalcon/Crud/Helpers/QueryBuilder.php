<?php
/**
 * QueryBuilder Trait
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
use Ng\Query\Query;
use Ng\Query\Condition\ArrayCondition;
use Ng\Query\Condition\SimpleCondition;
use Ng\Query\Operator;

/**
 * QueryBuilder Trait
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
trait QueryBuilder
{
    /**
     * Build Query to Filter by ID
     *
     * @param Query     &$query
     * @param NgModel   $model
     * @param int       $id
     *
     * @return void
     */
    protected function queryID(Query &$query, NgModel $model, $id)
    {
        $field  = $model::getIdField();
        $cond   = new SimpleCondition($field, Operator::OP_EQUALS, $id);
        $query->addCondition($cond);
    }

    /**
     * Build Query to Filter by array of ID
     *
     * @param Query     &$query
     * @param NgModel   $model
     * @param array     $ids
     *
     * @return void
     */
    protected function queryIDs(Query &$query, NgModel $model, array $ids)
    {
        $field  = $model::getIdField();
        $cond   = new ArrayCondition($field, Operator::OP_IN, $ids);
        $query->addCondition($cond);
    }

}
