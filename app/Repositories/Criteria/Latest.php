<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-13
 * Time: 3:04 PM
 */

namespace App\Repositories\Criteria;


use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class Latest extends Criteria
{

    protected $field;

    public function __construct($field = 'created_at')
    {
        $this->field = $field;
    }


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->latest($this->field);
    }
}