<?php

namespace Modules\Post\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Enums\BaseStatusEnum;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Acl\Entities\Users;
use Modules\Post\Repositories\PostInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\PostRequest;
use Modules\Post\Tables\PostTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Post\Forms\PostForm;
use Modules\Post\Supports\StoreCategoryService;
use Modules\Post\Supports\StoreTagService;
use Carbon\Carbon;
use Assets;
use Exception;

class PostController extends Controller
{
  /**
   * @var PostInterface
   */
  protected $post;

  public function __construct(PostInterface $post)
  {
    $this->post = $post;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(PostTable $table)
  {
    $post = $this->post->allBy(["status" => BaseStatusEnum::PUBLISHED]);

    page_title()->setTitle(__("post::post.list"));
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("post::post.add"));

    return $formBuilder->create(PostForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(
    PostRequest $request,
    StoreCategoryService $categoryService,
    StoreTagService $tagService,
    BaseHttpResponse $response
  ) {
    $requests = $request->request;
    $requests->add(["author_id" => Auth::user()->id]);
    $post = $this->post->create($request->all());

    event(new CreatedContentEvent($request->all(), $post));

    $categoryService->execute($request, $post);
    $tagService->execute($request, $post);

    return $response
      ->setPreviousUrl(route("post.index"))
      ->setNextUrl(route("post.edit", $post->id))
      ->setMessage(__("base::form-validate.add-success"));
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("post::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder, Request $request)
  {
    $subject = $this->post->find($id);

    page_title()->setTitle(__("post::post.edit"));

    return $formBuilder
      ->create(PostForm::class, ["model" => $subject])
      ->renderForm();
  }

  /**
   * Update the specified resource in storage.
   * @param Request $request
   * @param int $id
   * @return Response
   */
  public function update(
    Request $request,
    $id,
    StoreCategoryService $categoryService,
    StoreTagService $tagService,
    BaseHttpResponse $response
  ) {
    $post = $this->post->update($id, $request->all());

    if ($post) {
      event(new UpdatedContentEvent($request->all(), $post));
      $categoryService->execute($request, $post);
      $tagService->execute($request, $post);

      return $response
        ->setPreviousUrl(route("post.index"))
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  public function restore(Request $request, BaseHttpResponse $response)
  {
    $post = $this->post->getFirstByWithTrash(["posts.id" => $request->id]);
    $this->post->restoreBy(["id" => $request->id]);
    event(new DeletedContentEvent($request->all(), $post, "restore"));

    return $response
      ->setPreviousUrl(route("post.index"))
      ->setMessage(__("base::form-validate.update-success"));
  }
  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $post = $this->post->find($id);
    $this->post->delete($id);
    event(new DeletedContentEvent($request->all(), $post));

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }
}
