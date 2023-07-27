<?php
// This is On Call Application Model
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class OnCallApplication extends Model
    {
        use HasFactory;

        protected $fillable = ['title', 'user_id', 'department', 'reason', 'start_date', 'end_date', 'status', 'rejection'];
    }
?>
