<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'is_blocked'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'is_blocked' => 'boolean',
        ];
    }

    public function competitions()
    {
        return $this->hasMany(Competition::class, 'created_by_user_id');
    }

    public function dog()
    {
        return $this->hasMany(Dog::class, 'created_by_user_id');
    }

    public function handler()
    {
        return $this->hasMany(Handler::class, 'created_by_user_id');
    }

    public function pair()
    {
        return $this->hasMany(Pair::class, 'created_by_user_id');
    }

    public function photo()
    {
        return $this->hasMany(Photo::class, 'uploaded_by_user_id');
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'recorded_by_user_id');
    }

    public function track()
    {
        return $this->hasMany(Track::class, 'created_by_user_id');
    }


    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isOrganizer(): bool
    {
        return $this->role === 'organizer';
    }
    public function isRegularUser(): bool
    {
        return $this->role === 'user';
    }

    public function isSecretary(): bool
    {
        return $this->role === 'secretary';
    }
}
