<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Tambahkan constants untuk role
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_EDITOR = 'editor';
    const ROLE_PENDING = 'pending'; // User baru yang belum diverifikasi

    // Daftar role untuk dropdown
    public static function getRoles()
    {
        return [
            self::ROLE_PENDING => 'Menunggu Verifikasi',
            self::ROLE_USER => 'User Biasa',
            self::ROLE_EDITOR => 'Editor',
            self::ROLE_ADMIN => 'Administrator',
        ];
    }

    // Role yang bisa di-assign oleh admin (kecuali pending)
    public static function getAssignableRoles()
    {
        return [
            self::ROLE_PENDING => 'Batal Verifikasi',
            self::ROLE_USER => 'User',
            // self::ROLE_EDITOR => 'Editor',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    // Helper methods
    public function isPending()
    {
        return $this->role === self::ROLE_PENDING;
    }

    public function isVerified()
    {
        return $this->role !== self::ROLE_PENDING;
    }

    public function getRoleName()
    {
        return self::getRoles()[$this->role] ?? $this->role;
    }
}