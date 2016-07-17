<?php
/**
 * Repository Interfaces
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
 * Repository Interfaces
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface SQLRepository
{
    public function retrieveOne(NgModel $model, Query $query);

    public function retrieveAll(NgModel $model, Query $query);

    public function store(NgModel &$model, array $data);

    public function put(NgModel &$model, array $data);

    public function patch(NgModel &$model, array $data);

    public function remove(NgModel $model);
}
