<?php
/**
 * AbstractRepository Module
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


use Ng\Errors\NgErrorList;

/**
 * AbstractRepository Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
abstract class AbstractRepository
{
    /** @type NgErrorList $errors */
    protected $errors;

    public function __construct()
    {
        $this->errors = new NgErrorList();
    }

    /**
     * Reset Crud Handler or Re-Construct
     *
     * @return void
     */
    public function reset()
    {
        $this->__construct();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
