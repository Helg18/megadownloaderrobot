<?php
namespace App\Repositories;

use App\User;
use Illuminate\Support\Collection;

class UserRepository extends AbstractRepository
{
    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    private function addJoin(Collection &$joins, $table, $first, $second, $join_type = 'inner')
    {
        if (!$joins->has($table)) {
            $joins->put($table, json_encode(compact('first', 'second', 'join_type')));
        }
    }

    public function search(array $filters = [], $count = false)
    {
        $query = $this->model->select('users.*')->distinct();

        $joins = collect();

        $joins->each(function ($item, $key) use (&$query) {
            $item = json_decode($item);
            $query->join($key, $item->first, '=', $item->second, $item->join_type);
        });

        return $query;
    }

    public function getTelegramID($telegram_id)
    {
        return $this->model->ofTelegramID($telegram_id)->first();
    }


}
