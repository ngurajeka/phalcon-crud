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


use Phalcon\Mvc\Model\TransactionInterface;

/**
 * Model Interface
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface NgModelInterface
{
    const VALUE_DEL     = 1;
    const VALUE_NOTDEL  = 0;

    // is this model want to implement soft delete behaviour
    public function useSoftDelete();

    // get primary key value from the model
    public function getId();

    // is this model using prefix
    public static function getPrefix();

    // get primary key
    public static function getPrimaryKey();

    // get public fields
    public static function getPublicFields();

    // get created by field
    public static function getCreatedByField();

    // get created time field
    public static function getCreatedTimeField();

    // get updated by field
    public static function getUpdatedByField();

    // get updated time field
    public static function getUpdatedTimeField();

    // get deleted field
    public static function getDeletedField();

    // get deleted by field
    public static function getDeletedByField();

    // get deleted time field
    public static function getDeletedTimeField();
}
