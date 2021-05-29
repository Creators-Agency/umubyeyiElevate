<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::get();
        return response()->json([
            'message' => "fetched all menu for Focus id ", 
            'payload' => $menus,
            'status' => 201
        ]);
    }
    public function byFocus($program_id)
    {
        $menus = Menu::where(['program_id'=>$program_id])->get();
        return response()->json([
            'message' => "fetched all menu for Focus id ".$program_id, 
            'payload' => $menus,
            'status' => 201
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(REQUEST $request)
    {
        $parent = Menu::find($request->parent_id);
        if ($parent!=null) {
            $level = $parent->level + 1;
        } else{
            $level =0;
        }
        $menu = new Menu();
        $menu->menu_name = $request->menu_name;
        $menu->parent_id = $request->parent_id;
        $menu->status = $request->status;
        $menu->program_id = $request->program_id;
        $menu->user_id = $request->user_id;
        $menu->level = $level;
        if($menu->save()){
            $menu = Menu::orderBy('id','DESC')->first();
            return response()->json([
                'message' => 'Successfuly Fetched  Menu',
                'payload' => $menu,
                'status' => 201,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a Menu',
                'payload' => $request,
                'status' => 501,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $menu = Menu::find($id);
        $menu->menu_name = $request->menu_name;
        $menu->parent_id = $request->parent_id;
        $menu->status = $request->status;
        $menu->program_id = $request->program_id;
        $menu->user_id = $request->user_id;
        if($menu->save()){
            $menu = Menu::where(['id'=>$id])->first();
            return response()->json([
                'message' => 'Successfuly updated  Menu',
                'payload' => $menu,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to create a Menu',
                'payload' => $request,
                'status' => 500,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::find($id);
        $menu->status = 0;
        $menu->save();
        $fetch_menu = Menu::where(['id'=>$id])->first();
        if($menu){
            return response()->json([
                'message' => 'Successfuly deleted  Menu',
                'payload' => $fetch_menu,
                'status' => 200,
            ]);
        }else{
            return response()->json([
                'message' => 'Failed to delete a Menu',
                'payload' => $fetch_menu,
                'status' => 500,
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function delte(Menu $menu)
    {
        //
    }
}