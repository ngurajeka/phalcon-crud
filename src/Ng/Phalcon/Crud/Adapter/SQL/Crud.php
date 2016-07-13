<?php
/**
 * SQLCrud Module
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


use Ng\Phalcon\Crud\AbstractCrud;
use Ng\Phalcon\Crud\Errors\ExceptError as ExceptionError;
use Ng\Phalcon\Crud\Exception as CrudException;
use Ng\Phalcon\Crud\Interfaces\SQLCrud;
use Ng\Phalcon\Crud\Helpers\MessageChecking;
use Ng\Phalcon\Crud\Helpers\SoftDelete;
use Ng\Phalcon\Models\NgModel;
use Ng\Query\Query;

/**
 * SQLCrud Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
class Crud extends AbstractCrud implements SQLCrud
{
    use MessageChecking, SoftDelete;

    public function create(NgModel &$model, array $data)
    {
        if (!$model->create($data)) {
            foreach ($model->getMessages() as $message) {
                /** @type \Phalcon\Mvc\Model\Message $message */
                $this->errors->addError($this->parseMessage($message));
            }

            return false;
        }

        return true;
    }

    public function read(NgModel $model, Query $query, $first=false)
    {
        // check and implement query to filter data that was using soft delete
        $this->querySoftDelete($query, $model);

        // TODO check and implement query to filter data that was using historical method

        if ($query->hasOrders()) {
            $order  = $query->orderToString();
        } else {
            $order  = sprintf("%s DESC", $model::getPrimaryKey());
        }

        $params     = array(
            $query->conditionToString(),
            "limit"     => $query->getLimit(),
            "offset"    => $query->getOffset(),
            "order"     => $order,
        );

        $func       = "find";
        if ($first === true) {
            $func   = sprintf("%sFirst", $func);
        }

        try {
            $result = $model::$func($params);
        } catch (\Exception $e) {
            $msg    = $e->getMessage();
            $source = sprintf("%s::%s", $e->getFile(), $e->getLine());
            $trace  = $e->getTraceAsString();

            $this->errors->addError(
                new ExceptionError(409, $msg, $source, $trace)
            );

            throw new CrudException($e->getMessage());
        }

        return $result;
    }

    public function update(NgModel &$model, array $data)
    {
        if (!$model->update($data)) {
            foreach ($model->getMessages() as $message) {
                /** @type \Phalcon\Mvc\Model\Message $message */
                $this->errors->addError($this->parseMessage($message));
            }

            return false;
        }

        return true;
    }

    public function delete(NgModel $model)
    {
        if (!$model->delete()) {
            foreach ($model->getMessages() as $message) {
                /** @type \Phalcon\Mvc\Model\Message $message */
                $this->errors->addError($this->parseMessage($message));
            }

            return false;
        }

        return true;
    }
}
