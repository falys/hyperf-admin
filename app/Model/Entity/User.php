<?php

declare (strict_types=1);
namespace App\Model\Entity;

use Hyperf\DbConnection\Model\Model;
/**
 * @property int $id 
 * @property string $mobile 
 * @property string $username 
 * @property string $password 
 * @property string $salt 
 * @property string $email 
 * @property int $status 
 * @property string $nickname 
 * @property int $avatar 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class User extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'status' => 'integer', 'avatar' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}