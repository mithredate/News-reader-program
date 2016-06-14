<?php
/**
 * Created by PhpStorm.
 * User: mithredate
 * Date: 2016-06-12
 * Time: 3:58 PM
 */

namespace App\Repositories;


use Bosnadev\Repositories\Eloquent\Repository;

class ArticlesRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\NewsArticle';
    }
}