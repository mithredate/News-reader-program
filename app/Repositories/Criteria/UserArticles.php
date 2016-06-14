<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-13
 * Time: 4:38 PM
 */

namespace App\Repositories\Criteria;


use App\User;
use Bosnadev\Repositories\Contracts\RepositoryInterface as Repository;
use Bosnadev\Repositories\Criteria\Criteria;
use Bosnadev\Repositories\Contracts\RepositoryInterface;

class UserArticles extends Criteria
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, Repository $repository)
    {
        return $model->where('reporter_email',$this->user->email);
    }
}