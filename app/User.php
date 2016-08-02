<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Status\User\Authenticated;
use App\Status\User\Registered;
use App\Status\User\UserStatusBroker;
use App\Status\User\State;
use App\Status\User\Verified;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $registered;
    public $verified;
    public $authenticated;


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->registered = new Registered($this);
        $this->verified = new Verified($this);
        $this->authenticated = new Authenticated($this);
    }


    public function getStatusAttribute($value){
        return UserStatusBroker::getStatus($this,$value);
    }

    public function setStatusAttribute($value){
        $this->attributes['status'] = is_int($value) ? $value: $value->getStatus();
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param State $status
     */
    public function setStatus(State $status)
    {
        $this->update(['status' => $status]);
    }

    public function articles(){
        return $this->hasMany('App\NewsArticle','reporter_email','email');
    }
}
