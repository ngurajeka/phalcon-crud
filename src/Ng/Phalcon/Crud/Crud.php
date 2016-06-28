<?php
/**
 * Crud Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud;


use Ng\Errors\NgErrorInterface;
use Ng\Errors\NgErrors;
use Ng\Phalcon\Models\NgModelInterface;
use Ng\Query\Condition\SimpleCondition;
use Ng\Query\Operator;
use Ng\Query\Query;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\TransactionInterface as Tx;

/**
 * Crud Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
class Crud
{
    /** @type NgErrors #ngerrors */
    protected $ngerrors;

    protected $hideDeleted = true;

    public function __construct()
    {
        $this->ngerrors = new NgErrors();
    }

    /**
     * Checking Error of a Message
     *
     * @param Message $err error message object
     *
     * @return NgErrorInterface
     */
    protected function checkError(Message $err)
    {
        $field  = $err->getField();
        $msg    = $err->getMessage();
        $source = $err->getModel();
        $type   = $err->getType();

        switch ($type) {
        case "PresenceOf":
            return new Error\EmptyField($field, $msg, $source);
            break;
        default:
            return new Error\BasicError(409, $field, $msg, $type, $source);
            break;
        }
    }

    /**
     * Creating Record Data
     *
     * @param NgModelInterface $model object model
     * @param array            $data  the data that we want to insert as record
     * @param Tx               $tx    transaction interface for msyql
     *
     * @return boolean
     */
    public function create(NgModelInterface &$model, array $data, Tx &$tx=null)
    {
        if (!is_null($tx)) {
            $model->setTransaction($tx);
        }

        if (!$model->create($data)) {

            foreach ($model->getMessages() as $i => $err) {
                $this->ngerrors->append($this->checkError($err));
            }

            return false;
        }

        return true;
    }

    /**
     * Reading data record
     *
     * @param NgModelInterface $model object model
     * @param Query            $query object of query builder
     * @param bool             $first a decision to read all or only the first record
     * @param Tx               $tx    Transaction Interface for sql
     *
     * @return array()
     */
    public function read(
        NgModelInterface $model, Query $query, $first=false, Tx &$tx=null
    ) {
        if (!is_null($tx)) {
            $model->setTransaction($tx);
        }

        if ($this->hideDeleted) {
            $this->queryDeleted($query, $model);
        }

        if ($query->hasOrders()) {
            $order  = $query->orderToString();
        } else {
            $order  = sprintf("%s DESC", $model::getPrimaryKey());
        }

        $param = array(
            $query->conditionToString(),
            "limit"     => $query->getLimit(),
            "offset"    => $query->getOffset(),
            "order"     => $order,
        );

        $func       = "find";
        if ($first === true) {
            $func   = sprintf("%sFirst", $func);
        }

        $data = null;

        try {

            $data = $model::$func($param);

        } catch (\Exception $e) {
            $msg    = $e->getMessage();
            $src    = sprintf("%s::%s", $e->getFile(), $e->getLine());
            $trace  = $e->getTraceAsString();
            $error  = new Error\ExceptError(409, $msg, $src, $trace);

            $this->ngerrors->append($error);

            unset($error);
            unset($msg);
            unset($src);
            unset($trace);
        }

        return $data;
    }

    /**
     * Updating Record Data
     *
     * @param NgModelInterface $model object model
     * @param array            $data  updated data for the record
     * @param Tx               $tx    transaction interface for sql
     *
     * @return boolean
     */
    public function update(NgModelInterface $model, array $data, Tx &$tx=null)
    {
        if (!is_null($tx)) {
            $model->setTransaction($tx);
        }

        if (!$model->update($data)) {

            foreach ($model->getMessages() as $i => $err) {
                $this->ngerrors->append($this->checkError($err));
            }

            return false;
        }

        return true;
    }

    /**
     * Delete an object
     *
     * @param NgModelInterface $model
     * @param Tx|null          $tx
     *
     * @return bool
     */
    public function delete(NgModelInterface $model, Tx &$tx=null) {

        if (!is_null($tx)) {
            $model->setTransaction($tx);
        }

        if (!$model->delete()) {

            foreach ($model->getMessages() as $i => $err) {
                $this->ngerrors->append($this->checkError($err));
            }

            return false;
        }

        return true;
    }

    /**
     * Append Query Deleted field
     *
     * @param Query            $query
     * @param NgModelInterface $model
     */
    private function queryDeleted(Query $query, NgModelInterface $model)
    {
        if (empty($model::getDeletedField())) {
            return;
        }

        $field      = $model::getDeletedField();
        if (!is_string($field)) {
            return;
        }

        $query->appendCondition(
            new SimpleCondition($field, Operator::OP_EQUALS, $model::VALUE_DEL)
        );

    }

    public function getNgErrors()
    {
        return $this->ngerrors;
    }
}
