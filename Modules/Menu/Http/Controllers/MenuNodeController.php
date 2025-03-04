<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Routing\Controller;
//use Modules\Menu\Entities\Categories;
use Modules\Menu\Repositories\MenuInterface;
use Modules\Menu\Repositories\MenuNodeInterface;

class MenuNodeController extends Controller
{
    /**
     * @var MenusInterface
     */
    protected $menuNode;

    public function __construct(MenuNodeInterface $menuNode)
    {
        $this->menuNode = $menuNode;
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view("menu::cmspanel.menu.index");
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view("menu::create");
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view("menu::show");
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view("menu::edit");
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($request->ajax()) {
            if ($id) {
                $request->merge([
                    "title" => $request->has("name")
                        ? $request->name
                        : $request->title,
                ]);
                $updated = $this->menuNode->update($id, $request->all());
            }
            if ($updated) {
                $success = true;
                $message = "Cập nhật thành công";
            } else {
                $success = false;
                $message = "Cập nhật thất bại";
            }
            //return Response::json(array_merge($request->all(), ['id' => $id]), 200);
            return Response::json(
                [
                    "success" => $success,
                    "message" => $message,
                    "data" => $request->all(),
                    "id" => $id,
                ],
                200
            );
            //
            //       $this->_helper->json([
            //         'success' => $success,
            //         'message' => $message,
            //         'data' => $request->all(),
            //         'id' => $id,
            //       ]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateSort(Request $request)
    {
        if ($request->has("dataString")) {
            $this->menuNode->updateSort($request["dataString"]);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function import(Request $request)
    {
        if ($request->ajax()) {
            //	if($request->has('data'))

            //$data = apply_filters(MENU_SIDEBAR_IMPORT, $request);
            $data = apply_filters(MENU_SIDEBAR_IMPORT, $request);

            return Response::json($data);
        }
    }

    public function addExternalUrl(Request $request)
    {
        if ($request->ajax()) {
           // return Response::json($request->all());
         $rows = [
             "menu_id" => $request->menu_id,
             "parent_id" => "0",
             "related_id" => 0,
             "type" => 'external-link',
             "url" => $request->url,
             "title" => $request->title,
             "target" => $request->target,
             "icon" => $request->icon,
             "css" => $request->css,
             "has_child" => 0
         ];
         $menunode = app(MenuNodeInterface::class)->create($rows);

         $source = array_merge($menunode->toArray(), [
             "urlUpdate" => modal(
                 "/" . BACKEND . "/menunode/modal",
                 "<i class='fa fa-pencil bigger-130 font-weight-bold'></i> Sửa",
                 [
                     "class" => "",
                     "data-keyboard" => "false",
                     "title" => "Sửa menu",
                     "data-post-id" => $menunode->id,
                 ]
             ),
             "urlDelete" =>
                 '<a onclick="deleteMenuNode(this);" class="red" data-url="/' .
                 BACKEND .
                 "/menunode/delete/" .
                 $menunode->id .
                 '"><i class="fa fa-trash bigger-130"></i></a>',
         ]);


            return Response::json($source);
        }
    }

    public function modal(Request $request)
    {
        $options = [];
        if ($request->ajax()) {
            if ($request->has("id")) {
                $options = $this->menuNode->find($request->id)->toArray();
            }

            $options["data_target"] = [
                "_self" => "_self",
                "_blank" => "_blank",
                "_directUrl" => "_directUrl",
            ];

            $modal_form = view("menu::modal.menunode-edit", $options)->render();
            return Response::json([$modal_form], 200);
        }
    }

    public function test()
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->menuNode->delete($id);

        return Response::json(
            [
                "success" => $id,
            ],
            200
        );
    }
}
