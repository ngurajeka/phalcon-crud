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
use Ng\Phalcon\Crud\Helpers\QueryBuilder;
use Ng\Phalcon\Crud\Helpers\ReversalQueryBuilder;
use Ng\Phalcon\Models\NgModel;
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
class AdvancedRepository extends AbstractRepository implements SQLRepository
{
    use QueryBuilder, ReversalQueryBuilder;
    
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
        $this->queryID($query, $model, $id);

        return $this->retrieveOne($model, $query);
    }

    public function retrieveAllByIds(NgModel $model, array $ids)
    {
        $query = new Query();
        $this->queryIDs($query, $model, $ids);

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
