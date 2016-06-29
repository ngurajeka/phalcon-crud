<?php
/**
 * Model Interface
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Models;


use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\SoftDelete;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 * Model Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
class NgModelBase extends Model implements NgModelInterface
{
    const ID            = "id";

    const CREATED_AT    = "createdTime";
    const CREATED_BY    = "createdBy";
    const UPDATED_AT    = "updatedTime";
    const UPDATED_BY    = "updatedBy";
    const DELETED       = "deleted";
    const DELETED_AT    = "deletedTime";
    const DELETED_BY    = "deletedBy";

    public function __call($method, $arguments)
    {
        $key    = substr($method, 0, 3);
        $field  = lcfirst(substr($method, 3));
        $return = $this;

        if (!array_key_exists($field, get_object_vars($this))) {
            throw new Exception("Property " . $field . " Was Not Found");
        }

        switch ($key) {
            case "get":
                $return         = $this->{$field};
                break;
            case "set":
                $this->{$field} = $arguments[0];
                break;
        }

        return $return;
    }

    public function initialize()
    {
        if ($this->useSoftDelete() === true) {
            $this->implementSoftDelete();
        }
    }

    protected function implementSoftDelete()
    {
        /** @type NgModelInterface $class */
        $class = get_called_class();
        if (!empty($class::getDeletedField())) {
            return;
        }

        $opt = array(
            'field' => $class::getDeletedField(),
            'value' => self::VALUE_DEL,
        );

        $this->addBehavior(new SoftDelete($opt));
    }

    public function beforeValidationOnCreate()
    {
        $class  = get_called_class();
        $field  = $class::getCreatedTimeField();
        if (!empty($field)) {
            $this->{$field} = date("Y-m-d H:i:s");
        }

        $field  = $class::getDeletedField();
        if (!empty($field)) {
            $this->{$field} = NgModelInterface::VALUE_NOTDEL;
        }
    }

    public function beforeCreate()
    {
        $this->beforeValidationOnCreate();
    }

    public function beforeValidationOnUpdate()
    {
        $class  = get_called_class();
        $field  = $class::getUpdatedTimeField();
        if (!empty($field)) {
            $this->{$field} = date("Y-m-d H:i:s");
        }
    }

    public function beforeUpdate()
    {
        $this->beforeValidationOnUpdate();
    }

    public function useSoftDelete()
    {
        return true;
    }

    public function getId()
    {
        $func = sprintf("get%s", ucfirst($this->transformKey(self::ID)));
        return $this->$func();
    }

    public static function getPrefix()
    {
        return "";
    }

    public static function getPrimaryKey()
    {
        return self::transformKey(self::ID);
    }

    // get public fields
    public static function getPublicFields()
    {
        return array(
            self::transformKey(self::ID), self::transformKey(self::CREATED_AT)
        );
    }

    // get created by field
    public static function getCreatedByField()
    {
        return self::transformKey(self::CREATED_BY);
    }

    // get created time field
    public static function getCreatedTimeField()
    {
        return self::transformKey(self::CREATED_AT);
    }

    // get updated by field
    public static function getUpdatedByField()
    {
        return self::transformKey(self::UPDATED_BY);
    }
    // get updated time field
    public static function getUpdatedTimeField()
    {
        return self::transformKey(self::UPDATED_AT);
    }

    // get deleted field
    public static function getDeletedField()
    {
        return self::transformKey(self::DELETED);
    }

    // get deleted by field
    public static function getDeletedByField()
    {
        return self::transformKey(self::DELETED_BY);
    }

    // get deleted time field
    public static function getDeletedTimeField()
    {
        return self::transformKey(self::DELETED_AT);
    }

    protected static function transformKey($key)
    {
        /** @type NgModelInterface $class */
        $class      = get_called_class();
        if (!empty($class::getPrefix()))  {
            $key    = sprintf("%s%s", $class::getPrefix(), ucfirst($key));
        }

        return $key;
    }
}
