<?php
/**
 * MessageChecking Trait
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


use Ng\Errors\NgErrorInterface as NgError;
use Ng\Phalcon\Crud\Errors\BasicError;
use Ng\Phalcon\Crud\Errors\EmptyField;

use Phalcon\Mvc\Model\Message;

/**
 * MessageChecking Trait
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
trait MessageChecking
{
    /**
     * Parsing Message into an error adapter
     *
     * @param Message $err error message object
     *
     * @return NgError
     */
    protected function parseMessage(Message $err)
    {
        $field  = $err->getField();
        $msg    = $err->getMessage();
        $source = $err->getModel();
        $type   = $err->getType();

        switch ($type) {
            case "PresenceOf":
                return new EmptyField($field, $msg, $source);
                break;
            default:
                return new BasicError(409, $field, $msg, $type, $source);
                break;
        }
    }
}
