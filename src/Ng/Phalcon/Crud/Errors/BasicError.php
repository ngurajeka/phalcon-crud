<?php
/**
 * Basic Error
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud\Errors;


use Ng\Errors\Error\SimpleError;

/**
 * Basic Error
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
class BasicError extends SimpleError
{
    protected $field;
    protected $type;

    public function __construct(
        $code, $field, $msg, $type, $source=null, $stackTrace=null
    ) {
        $this->field    = $field;
        $this->type     = $type;
        parent::__construct($code, $msg, $source, $stackTrace);
    }

    public function getField()
    {
        return $this->field;
    }

    public function getType()
    {
        return $this->type;
    }

    public function toArray()
    {
        $arr = parent::toArray();
        $arr["field"] = $this->getField();
        return $arr;
    }
}
