<?php
/**
 * CRUD Interfaces
 *
 * PHP Version 5.4.x
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
namespace Ng\Phalcon\Crud\Interfaces;


use Ng\Phalcon\Models\NgModel;
use Ng\Query\Query;

/**
 * CRUD Interfaces
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface SQLCrud
{
    public function create(NgModel &$model, array $data);

    public function read(NgModel $model, Query $query, $first=false);

    public function update(NgModel &$model, array $data);

    public function delete(NgModel $model);
}