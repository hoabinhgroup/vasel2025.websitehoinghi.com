<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus';
    
    protected $fillable = ['name','slug','status'];

    /**
     * @return mixed
     * @author 
     */
    public function menuNodes()
    {
        return $this->hasMany(MenuNode::class, 'menu_id');
    }
    
     public function languageMeta()
    {
	        return $this->hasOne('Modules\Languages\Entities\LanguageMeta','lang_meta_content_id', 'id');
    }
    
     public function slug()
    {
	        return $this->hasOne('Modules\Slug\Entities\Slug','reference_id', 'id');
    }
    
    public function delete()
    {
	    $this->languageMeta()->delete();
	    $this->slug()->delete();	    
	    return parent::delete();
    }
    
 
}
