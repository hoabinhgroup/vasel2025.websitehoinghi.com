<?php

namespace Modules\Slug\Listeners;

use Modules\Base\Events\UpdatedContentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Slug\Repositories\SlugInterface;
use Exception;

class UpdatedContentListener
{
	protected $slug;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SlugInterface $slug)
    {
        $this->slug = $slug;
    }

    /**
     * Handle the event.
     *
     * @param CreatedContentEvent $event
     * @return void
     */
    public function handle(UpdatedContentEvent $event)
    {
	     try {          
		     
        $this->slug->updateOrCreate(
        		['reference' => get_class($event->data),
				 'reference_id' => $event->data->id], 
				 ['key' => $event->request['slug']]); 
             
        } catch (Exception $exception) {
            $exception->getMessage();
        }
    }
}
