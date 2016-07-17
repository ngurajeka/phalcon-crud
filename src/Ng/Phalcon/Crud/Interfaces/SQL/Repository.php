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
namespace Ng\Phalcon\Crud\Interfaces\SQL;


use Ng\Phalcon\Models\Abstracts\NgModel;
use Ng\Query\Adapters\SQL\Query;

/**
 * Repository Interfaces
 *
 * @category Library
 * @package  Library
 * @author   Ady Rahmat MA <adyrahmatma@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/ngurajeka/phalcon-crud
 */
interface Repository
{
    public function retrieveOne(NgModel $model, Query $query);

    public function retrieveAll(NgModel $model, Query $query);

    public function store(NgModel &$model, array $data);

    public function put(NgModel &$model, array $data);

    public function patch(NgModel &$model, array $data);

    public function remove(NgModel $model);
}
