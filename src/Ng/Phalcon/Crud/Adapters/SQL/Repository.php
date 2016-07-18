<?php
/**
 * SQLRepository Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud\Adapters\SQL;


use Ng\Phalcon\Crud\Abstracts\SQL\Repository as AbstractRepository;
use Ng\Phalcon\Crud\Exceptions\Exception;
use Ng\Phalcon\Models\Abstracts\NgModel;
use Ng\Query\Adapters\SQL\Conditions\ArrayCondition;
use Ng\Query\Adapters\SQL\Conditions\SimpleCondition;
use Ng\Query\Adapters\SQL\Query;
use Ng\Query\Helpers\Operator;

/**
 * SQLRepository Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
class Repository extends AbstractRepository
{
    public function retrieveOneById(NgModel $model, $id)
    {
        $query = new Query();
        $query->addCondition(
            new SimpleCondition(
                $model::getPrimaryKey(), Operator::OP_EQUALS, $id
            )
        );

        return $this->retrieveOne($model, $query);
    }

    public function retrieveAllByIds(NgModel $model, array $ids)
    {
        $query = new Query();
        $query->addCondition(
            new ArrayCondition(
                $model::getPrimaryKey(), Operator::OP_EQUALS, $ids
            )
        );

        return $this->retrieveAll($model, $query);
    }

    public function retrieveOne(NgModel $model, Query $query)
    {
        try {
            $result = $this->handler->read($model, $query, true);
        } catch (Exception $e) {
            $this->errors->merge($this->handler->getErrors());
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function retrieveAll(NgModel $model, Query $query)
    {
        try {
            $result = $this->handler->read($model, $query, false);
        } catch (Exception $e) {
            $this->errors->merge($this->handler->getErrors());
            throw new Exception($e->getMessage());
        }

        return $result;
    }

    public function store(NgModel &$model, array $data)
    {
        if (!$this->handler->create($model, $data)) {
            $this->errors->merge($this->handler->getErrors());
            return false;
        }

        return true;
    }

    public function put(NgModel &$model, array $data)
    {
        if (!$this->handler->update($model, $data)) {
            $this->errors->merge($this->handler->getErrors());
            return false;
        }

        return true;
    }

    public function patch(NgModel &$model, array $data)
    {
        if (!$this->handler->update($model, $data)) {
            $this->errors->merge($this->handler->getErrors());
            return false;
        }

        return true;
    }

    public function remove(NgModel $model)
    {
        if (!$this->handler->delete($model)) {
            $this->errors->merge($this->handler->getErrors());
            return false;
        }

        return true;
    }
}
