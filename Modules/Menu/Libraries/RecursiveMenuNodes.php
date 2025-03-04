<?php use Modules\Menu\Repositories\MenuNodeInterface;
class RecursiveMenuNodes{
	
	protected $_sourceArr;
	public function __construct($menu_id){
		
		$menuNode = app(MenuNodeInterface::class)
							->getByAttributes(
							[], ['menu_id' => $menu_id], 'position', 'asc')
							->toArray();
		$this->_sourceArr = $menuNode;	
					
	}
	

	public function build($parents = 0){
		$resultArr = '';
		$this->recursiveMenu($this->_sourceArr,$parents, 1,$resultArr);
		
		return str_replace('<ul></ul>','',$resultArr);
	}
	
	public function getParentsIdArray($id,$options = null){
		if($options['type'] == 1){
			$arrParents[] = $id;
		}
		$this->findParents($this->_sourceArr,$id, $arrParents);
		return $arrParents;
	}
	
	
	public function recursiveMenu($sourceArr, $parents = 0,$level = 1, &$newMenu){
	  if(count($sourceArr) > 0){
		 $newMenu .= '<ol class="dd-list">';
		  foreach($sourceArr as $key => $value){
			  if($value['parent_id'] == $parents){
				  $value['level'] = $level;
				  $icon_status = '';	
				  $title_status = '';
			
				 
				 $newMenu .= '<li data-id="'.$value['id'].'" class="dd-item dd2-item item-'.(($level == 1)?'orange':'blue2').'" id="sort_'.$value['id'].'">';
				 $newMenu .= '<div class="dd-handle dd2-handle"><i class="normal-icon ace-icon fa fa-bars blue bigger-130"></i><i class="drag-icon ace-icon fa fa-arrows bigger-125"></i></div>';
				$newMenu .= '<div class="dd2-content"><span class="msg_'.$value['id'].'">'. $value['title'].'</span>';
				$newMenu .=  '<div class="pull-right action-buttons">';
				$newMenu .= modal('/' . BACKEND ."/menunode/modal", "<i class='fa fa-pencil bigger-130 font-weight-bold'></i> Sửa", array("class" => "","data-keyboard" => 'false', "title" => "Sửa menu", "data-post-id" => $value['id'] )).'&nbsp; &nbsp;';
				$newMenu .=  '<a onclick="deleteMenuNode(this);" class="red" data-url="/'. BACKEND ."/menunode/delete/". $value["id"].'"><i class="fa fa-trash bigger-130"></i></a></div></div>';
			
				 $newParents = $value['id'];
				 unset($sourceArr[$key]);	
				 if ($value['has_child']){
				  $this->recursiveMenu($sourceArr, $newParents, $level + 1, $newMenu);
				  }
				$newMenu .= '</li>';
			  }
		  }
	
		   $newMenu .= '</ol>';
	  }else{
		   $newMenu .= '<ol class="dd-list"></ol>';
	  }
	}
		public function findParents($sourceArr,$id, &$arrParents){
			foreach ($sourceArr as $key => $value){		
				if($value['id'] == $id){
					if( $value['parent'] >0 ){
						$arrParents[] = $value['parent'];
						unset($sourceArr[$key]);
						$newID = $value['parent'];
						$this->findParents($sourceArr,$newID, $arrParents);
					}
				}
			}
		}
		
	
}
