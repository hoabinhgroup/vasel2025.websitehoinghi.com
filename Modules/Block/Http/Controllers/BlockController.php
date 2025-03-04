<?php

namespace Modules\Block\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Block\Repositories\BlockInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Block\Entities\Block;
use Modules\Block\Tables\BlockTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Block\Forms\BlockForm;
use Carbon\Carbon;
use Assets;

class BlockController extends Controller
{
  /**
   * @var BlockInterface
   */
  protected $block;

  public function __construct(BlockInterface $block)
  {
    $this->block = $block;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(BlockTable $table)
  {
    page_title()->setTitle(__("block::block.list"));
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("block::block.add"));
    return $formBuilder->create(BlockForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    $request->merge([
      "status" => $request->has("status") ? 1 : 0,
      "user_id" => Auth::user()->id,
    ]);
    $block = $this->block->create($request->all());

    event(new CreatedContentEvent($request->all(), $block));

    return $response
      ->setPreviousUrl(route("block.index"))
      ->setNextUrl(route("block.edit", $block->id))
      ->setMessage(__("base::form-validate.add-success"));
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("block::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $subject = $this->block->find($id);

    page_title()->setTitle(__("block::block.edit"));

    return $formBuilder
      ->create(BlockForm::class, ["model" => $subject])
      ->renderForm();
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Response
   */
  public function update(Request $request, $id, BaseHttpResponse $response)
  {
    $request->merge(["status" => $request->has("status") ? 1 : 0]);

    $block = $this->block->update($id, $request->all());

    if ($block) {
      event(new UpdatedContentEvent($request->all(), $block));
      return $response
        ->setPreviousUrl(route("block.index"))
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  public function restore(Request $request, BaseHttpResponse $response)
  {
    $block = $this->block->getFirstByWithTrash(["blocks.id" => $request->id]);
    $this->block->restoreBy(["id" => $request->id]);
    event(new DeletedContentEvent($request->all(), $block, "restore"));

    return $response
      ->setPreviousUrl(route("block.index"))
      ->setMessage(__("base::form-validate.update-success"));
  }
  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $block = $this->block->find($id);
    $this->block->delete($id);
    event(new DeletedContentEvent($request->all(), $block));

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }
}
