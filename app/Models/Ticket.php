<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'priority',
        'category',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function participants()
    {
        return $this->hasMany(TicketParticipant::class);
    }

    public function owner()
    {
        return $this->hasOne(TicketParticipant::class)->where('role', 'owner');
    }

    public function canAccess($userId)
    {
        if ($this->user_id == $userId) {
            return true;
        }
        return $this->participants->contains('user_id', $userId);
    }
} 