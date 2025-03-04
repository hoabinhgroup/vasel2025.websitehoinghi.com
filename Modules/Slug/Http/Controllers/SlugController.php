<?php

namespace Modules\Slug\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Slug\Http\Requests\SlugRequest;
use Modules\Slug\Services\SlugService;
use Modules\Slug\Repositories\SlugInterface;

class SlugController extends Controller
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @var SlugService
     */
    protected $slugService;

    /**
     * SlugController constructor.
     * @param SlugInterface $slugRepository
     * @param SlugService $slugService
     */
    public function __construct(
        SlugInterface $slugRepository,
        SlugService $slugService
    ) {
        $this->slugRepository = $slugRepository;
        $this->slugService = $slugService;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        dd(1);
        return view("slug::index");
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view("slug::create");
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(SlugRequest $request)
    {
        return $this->slugService->create(
            $request->input("name"),
            $request->input("slug_id"),
            $request->input("model")
        );
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view("slug::show");
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view("slug::edit");
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
