<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Model;

class MenuNode extends Model
{

	protected $table = 'menu_nodes';
	
    protected $fillable = [
	    'menu_id',
	    'parent_id',
	    'related_id',
	    'type',
	    'url',	
	    'icon_font',
	    'position',	
	    'title',	
	    'css_class',	
	    'target',
	    'has_child'
    ];
    
     /**
     * @return mixed
     * @author Tuan Louis
     */
    public function parent()
    {
        return $this->belongsTo(MenuNode::class, 'parent_id');
    }

    /**
     * @return mixed
     * @author Tuan Louis
     */
    public function child()
    {
        return $this->hasMany(MenuNode::class, 'parent_id');
    }
    
     public function hasChild()
    {
        return $this->has_child == 1;
    }
  
}
