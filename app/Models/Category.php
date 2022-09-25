<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Vault;

class Category extends Model
{
    use HasFactory;

    protected $table = "categories";

    public function info(){

        return $this->hasMany(Vault::class);

    }

    public function scopeSearch($query,$term)
    {
    	$term = "%$term%";
    	$query->where(function($query) use ($term)
    	{
    		$query->where('name','like',$term);
    	});
    }
}
