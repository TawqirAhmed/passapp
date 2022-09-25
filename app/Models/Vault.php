<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Models\Category;

class Vault extends Model
{
    use HasFactory;

    protected $table = "vaults";

    public function category(){

        return $this->belongsTo(Category::class, 'category_id');

    }

    public function scopeSearch($query,$term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term)
        {
            $query->where('site','like',$term)
                    ->orWhere('user_name','like',$term)
                    ->orWhere('email','like',$term)
                    ->orWhere('updated_at','like',$term)
                    ->orWhereHas('category', function($query) use ($term){
                        $query->where('name','like',$term);
                    });
        });
    }
}
