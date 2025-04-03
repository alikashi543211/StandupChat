<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all of the messages for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'user_id', 'id');
    }

    public function getImageAttribute($value)
    {
        if($value)
        {
            if(file_exists(public_path($value)))
            {
                return url($value);
            }
        }

        return url('chat-assets/images/default.png');
    }

    /**
     * Get all of the contactsAddedByMe for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactsAddedByMe(): HasMany
    {
        return $this->hasMany(Channel::class, 'user1_id', 'id');
    }

    /**
     * Get all of the contactsAddedByOther for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contactsAddedByOther(): HasMany
    {
        return $this->hasMany(Channel::class, 'user2_id', 'id');
    }
}
