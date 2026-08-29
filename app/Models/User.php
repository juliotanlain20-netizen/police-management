<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Override;

#[Fillable(['name', 'email', 'password', 'phone', 'status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }
    public function evidenceHistory()
    {
        return $this->hasMany(EvidenceHistory::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }
    // public function notifications()
    // {
    //     return $this->hasMany(Notification::class);
    // }
    public function hasPermission(string $permissionSlug): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permissionSlug) {
                $query->where('permissions.slug', $permissionSlug);
            })->exists();
    }

    public function officer()
    {
        return $this->hasOne(PoliceOfficer::class, 'user_id', 'id');
    }
    public function caseHistory()
    {
        return $this->hasMany(CaseHistory::class);
    }
    public function news()
    {
        return $this->hasMany(News::class, 'author_id', 'id');
    }
    public function log()
    {
        return $this->hasMany(Activity_log::class);
    }
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;//sebenarnya bisa pake notif bawaan laravel


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
