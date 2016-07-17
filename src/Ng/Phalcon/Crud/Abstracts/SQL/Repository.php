<?php
/**
 * AbstractSQLRepository Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud\Abstracts\SQL;


use Ng\Errors\NgErrorList;
use Ng\Phalcon\Crud\Interfaces\SQL\Repository as RepositoryInterface;

/**
 * AbstractSQLRepository Module
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
abstract class Repository implements RepositoryInterface
{
    /** @type NgErrorList $errors */
    protected $errors;
    /** @type Crud $handler */
    protected $handler;

    public function __construct(Crud $crud)
    {
        $this->errors   = new NgErrorList();
        $this->handler  = $crud;
    }

    /**
     * Reset Crud Handler or Re-Construct
     *
     * @return void
     */
    public function reset()
    {
        $this->__construct(new $this->handler);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
