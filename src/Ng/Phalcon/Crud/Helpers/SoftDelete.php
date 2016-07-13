<?php
/**
 * SoftDelete Trait
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
 * SoftDelete Trait
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
trait SoftDelete
{
    /**
     * Append Query Deleted field
     *
     * @param Query     &$query
     * @param NgModel   $model
     *
     * @return void
     */
    protected function querySoftDelete(Query &$query, NgModel $model)
    {
        if (!$model::useSoftDelete()) {
            return;
        }
        
        if (empty($model::getDeletedField())) {
            return;
        }

        $field      = $model::getDeletedField();
        if (!is_string($field)) {
            return;
        }

        $query->appendCondition(
            new SimpleCondition($field, Operator::OP_EQUALS, $model::VALUE_NOTDEL)
        );
    }
}