<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-13
 * Time: 4:48 PM
 */

namespace App\Repositories\Criteria;


use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class Limit extends Criteria
{

    protected $limit;

    public function __construct($count)
    {
        $this->limit = $count;
    }


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->limit($this->limit);
    }
}