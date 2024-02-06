<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activity';
    protected $fillable = [
        'ident', 'name', 'sport', 'date', 'created_at', 'updated_at',
    ];

    public function __construct(){
        $this->ident=bin2hex(random_bytes(16));
    }

    // Déclaration de la relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'util', 'ident');
    }
}
