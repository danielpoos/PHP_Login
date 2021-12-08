<?php
namespace Petrik\Loginapp;
use Illuminate\Database\Eloquent\Model;

class User extends Model{
    public $timestamps = false;
    protected $visible =['id','email'];
}