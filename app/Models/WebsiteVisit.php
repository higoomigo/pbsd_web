<?php
namespace App\Models;

use Coderflex\Laravisit\Concerns\CanVisit;
use Coderflex\Laravisit\Concerns\HasVisits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteVisit extends Model implements CanVisit
{
    use HasFactory;
    use HasVisits;

    // Matikan timestamps karena kita tidak menggunakan tabel fisik
    public $timestamps = false;
    
    // Matikan incrementing karena ID akan kita set secara statis
    public $incrementing = false; 
    
    // Tetapkan tipe key (penting untuk model tanpa tabel)
    protected $keyType = 'int'; 
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Tetapkan ID yang akan dicatat di kolom 'visitable_id'
        $this->id = 1; 
    }

    // Opsional: Untuk mencegah Laravisits mencoba berinteraksi 
    // dengan tabel database untuk model ini (jika Anda tidak ingin membuat tabel dummy)
    protected $table = null;
}