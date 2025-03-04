<?php
namespace Modules\Page\Http\Controllers;

use Auth;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Page\Repositories\PageInterface;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Page\Tables\PageTable;
use Modules\Base\Forms\FormBuilder;
use Modules\Page\Forms\PageForm;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
//use Modules\Base\Supports\TelegramLogs;

class PageController extends Controller
{
  use HasDeleteManyItemsTrait;
  /**
   * @var PageInterface
   */
  protected $page;

  public function __construct(PageInterface $page)
  {
    $this->page = $page;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(PageTable $table)
  {
    // dd(config('page.page_index'));
    page_title()->setTitle(__("Page::page.list"));
    return $table->renderTable();
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(FormBuilder $formBuilder)
  {
    page_title()->setTitle(__("Page::page.add"));
    return $formBuilder->create(PageForm::class)->renderForm();
  }

  /**
   * Store a newly created resource in storage.
   * @param Request $request
   * @return Response
   */
  public function store(Request $request, BaseHttpResponse $response)
  {
    $requests = $request->request;
    $requests->add(["user_id" => Auth::user()->id]);
    $page = $this->page->create($request->all());

    event(new CreatedContentEvent($request->all(), $page));

    return $response
      ->setPreviousUrl(route("page.index"))
      ->setNextUrl(route("page.edit", $page->id))
      ->setMessage(__("Base::form-validate.add-success"));
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Response
   */
  public function show($id)
  {
    return view("Page::show");
  }

  /**
   * Show the form for editing the specified resource.
   * @param int $id
   * @return Response
   */
  public function edit($id, FormBuilder $formBuilder)
  {
    $subject = $this->page->find($id);

    page_title()->setTitle(__("Page::page.edit"));

    return $formBuilder
      ->create(PageForm::class, ["model" => $subject])
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
    $page = $this->page->update($id, $request->all());

    if ($page) {
      event(new UpdatedContentEvent($request->all(), $page));
      return $response
        ->setPreviousUrl(route("page.index"))
        ->setMessage(__("base::form-validate.update-success"));
    }
  }

  public function restore(Request $request, BaseHttpResponse $response)
  {
    $page = $this->page->getFirstByWithTrash(["pages.id" => $request->id]);
    $this->page->restoreBy(["id" => $request->id]);
    event(new DeletedContentEvent($request->all(), $page, "restore"));

    return $response
      ->setPreviousUrl(route("page.index"))
      ->setMessage(__("Base::form-validate.update-success"));
  }
  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Response
   */
  public function destroy(Request $request, $id)
  {
    $page = $this->page->find($id);
    $this->page->delete($request->id);
    event(new DeletedContentEvent($request->all(), $page));

    return Response::json(
      [
        "success" => true,
      ],
      200
    );
  }

  public function deletes(Request $request, BaseHttpResponse $response)
  {
    return $this->executeDeleteItems($request, $response, $this->page);
  }

  public function test()
  {
    //  $page = Page::withTrashed()->find(46);

    //  $page->forceDelete();
  }
}
