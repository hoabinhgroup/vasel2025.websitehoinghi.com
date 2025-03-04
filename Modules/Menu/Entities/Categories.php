<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
	use SoftDeletes;
     /**
     * @var string 
     */
    protected $table = 'categories';
    /**
     * @var array 
     */
    protected $fillable = [
    	'name',
    	'parent',
    	'description',
    	'status',
    	'user_id'];
    
    public function owner()
    {
	        return $this->belongsTo(Users::class);
    }
    
    public function languageMeta()
    {
	        return $this->hasOne('Modules\Languages\Entities\LanguageMeta','lang_meta_content_id', 'id');
    }
    
     public function slug()
    {
	        return $this->hasOne('Modules\Slug\Entities\Slug','reference_id', 'id');
    }
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Categories $categories) {
	        if ($categories->isForceDeleting()) {
             $categories->languageMeta()->forceDelete();
             $categories->slug()->forceDelete();            
            }else{
	         $categories->languageMeta()->delete();
             $categories->slug()->delete();   
            }
        });
        
         
        static::restored(function (Categories $categories) {
			$categories->languageMeta()->restore();
			$categories->slug()->restore();
		});
    }
}
