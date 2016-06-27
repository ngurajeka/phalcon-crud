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
namespace Ng\Phalcon\Crud\Error;


use Ng\Errors\Error\NotFound;

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
class EmptyField extends NotFound
{
    protected $field;

    public function __construct($field, $msg, $source=null, $stackTrace=null)
    {
        $this->field = $field;
        parent::__construct($msg, $source, $stackTrace);
    }

    public function getField()
    {
        return $this->field;
    }

    public function toArray()
    {
        $arr = parent::toArray();
        $arr["field"] = $this->getField();
        return $arr;
    }
}
