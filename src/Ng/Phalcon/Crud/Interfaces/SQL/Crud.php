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
namespace Ng\Phalcon\Crud\Interfaces\SQL;


use Ng\Phalcon\Models\Abstracts\NgModel;
use Ng\Query\Adapters\SQL\Query;

/**
 * CRUD Interfaces
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface Crud
{
    public function create(NgModel &$model, array $data);

    public function read(NgModel $model, Query $query, $first=false);

    public function update(NgModel &$model, array $data);

    public function delete(NgModel $model);
}