<?php namespace App\Models;

use App\Traits\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Post extends Model
{
    use UuidPrimaryKey;

    const STATUS_ENUM = [
        'DELETED' => 9999,
        'DRAFT' => 1000,
        'PUBLIC' => 2000,
    ];

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

    public static function createValidator($input)
    {
        $rules = [
            'title' => 'required|max:255',
            'content' => 'required|string',
        ];
        $messages = [
            'title.required' => 'Title is missing.',
            'title.max' => 'Title is more than 255 characters.',
            'content.required' => 'Content is missing.',
            'content.string' => 'Content has to be string',
        ];

        return Validator::make($input, $rules, $messages);
    }

    public static function updateValidator($input)
    {
        $rules = [
            'title' => 'sometimes|required|max:255',
            'content' => 'sometimes|required|string',
            'status' => ['sometimes', 'required', 'integer', Rule::in(array_values(Post::STATUS_ENUM))],
        ];
        $messages = [
            'title.max' => 'Title is more than 255 characters.',
            'content.string' => 'Content has to be string.',
            'status.in' => 'Status is invalid.',
        ];

        return Validator::make($input, $rules, $messages);
    }
}