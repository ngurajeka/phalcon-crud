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
namespace Ng\Phalcon\Crud\Adapter\SQL;


use Ng\Phalcon\Crud\AbstractRepository;
use Ng\Phalcon\Crud\Exception as CrudException;
use Ng\Phalcon\Crud\Interfaces\SQLRepository;
use Ng\Phalcon\Models\NgModel;
use Ng\Query\Condition\ArrayCondition;
use Ng\Query\Condition\SimpleCondition;
use Ng\Query\Operator;
use Ng\Query\Query;

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
class Repository extends AbstractRepository implements SQLRepository
{
    /** @type Crud $handler */
    protected $handler;
    
    public function __construct(Crud $handler)
    {
        $this->handler = $handler;
        parent::__construct();
    }

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
        } catch (CrudException $e) {
            $this->errors->merge($this->handler->getErrors());
            throw new CrudException($e->getMessage());
        }

        return $result;
    }

    public function retrieveAll(NgModel $model, Query $query)
    {
        try {
            $result = $this->handler->read($model, $query, false);
        } catch (CrudException $e) {
            $this->errors->merge($this->handler->getErrors());
            throw new CrudException($e->getMessage());
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
