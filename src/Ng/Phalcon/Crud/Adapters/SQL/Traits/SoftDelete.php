<?php
/**
 * SoftDelete Traits
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud\Adapters\SQL\Traits;


use Ng\Phalcon\Models\Interfaces\NgModelSoftDelete;
use Ng\Query\Adapters\SQL\Conditions\SimpleCondition;
use Ng\Query\Adapters\SQL\Query;
use Ng\Query\Helpers\Operator;

/**
 * SoftDelete Traits
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
     * @param Query             &$query Query Module
     * @param NgModelSoftDelete $model  Model base
     *
     * @return void
     */
    protected function querySoftDelete(Query &$query, NgModelSoftDelete $model)
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

		$className	= get_class($model);
		$field		= sprintf("%s.%s", $className, $field);

        $query->appendCondition(
            new SimpleCondition($field, Operator::OP_EQUALS, NgModelSoftDelete::VALUE_NOTDEL)
        );
    }
}
