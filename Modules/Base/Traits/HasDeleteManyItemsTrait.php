<?php

namespace Modules\Base\Traits;

use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Repositories\RepositoryInterface;
use Exception;
use Illuminate\Http\Request;

trait HasDeleteManyItemsTrait
{
    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param RepositoryInterface $repository
     * @param string $screen
     * @return BaseHttpResponse
     * @throws Exception
     */
    protected function executeDeleteItems(
        Request $request,
        BaseHttpResponse $response,
        RepositoryInterface $repository
    ) {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $item = $repository->find($id);

            if (!$item) {
                continue;
            }


            $repository->delete($id);
            event(new DeletedContentEvent($request->all(), $item));
        }

        return $response->setMessage(trans('base::notices.delete_success_message'));
    }
}
