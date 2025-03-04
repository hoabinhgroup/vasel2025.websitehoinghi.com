<?php

namespace Modules\Slug\Listeners;

use Modules\Base\Events\DeletedContentEvent;
use Modules\Slug\Repositories\SlugInterface;
use Exception;
use Slug;

class DeletedContentListener
{

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * SlugService constructor.
     * @param SlugInterface $slugRepository
     */
    public function __construct(SlugInterface $slugRepository)
    {
        $this->slugRepository = $slugRepository;
    }

    /**
     * Handle the event.
     *
     * @param DeletedContentEvent $event
     * @return void
     */
    public function handle(DeletedContentEvent $event)
    {
        if (Slug::isSupportedModel(get_class($event->data))) {
            try {
	            $options = [
                    'reference_id'   => $event->data->id,
                    'reference' => get_class($event->data),
						];
	           	if($event->action){
		           	
		        	if($event->action == 'restore'){
			        	
			        	$this->slugRepository->restoreBy($options);
		        	}elseif($event->action == 'force'){
			        				        	
			        	 $this->slugRepository->forceDelete($options);
			        	
		        	}
               }else{
	               $this->slugRepository->deleteBy($options);
               }
                    
	            
            } catch (Exception $exception) {
                info($exception->getMessage());
            }
        }
    }
}
