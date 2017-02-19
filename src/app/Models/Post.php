<?php namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use UuidPrimaryKey;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['content', 'status', 'title'];

    const STATUS_ENUM = [
        'DELETED' => 9999,
        'DRAFT' => 1000,
        'PUBLIC' => 2000,
    ];
}