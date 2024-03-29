<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Channel;
use App\Country;
use App\Category;
use App\Link;
use Auth;
use DB;

class ChannelsController extends Controller
{
    private $view = 'admin.channels.';
    private $route = "channels.index";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Channel::all();
        return view($this->view."index",['title' => 'Canales','data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        $categories = Category::all();
        return view($this->view."save",['title' => 'Nuevo Canal', 'action' => 'new', 'countries' => $countries,'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
            'category_id' => 'required'
        ]);

        DB::BeginTransaction();

        $object = new Channel();
        $object->user_id = Auth::user()->id;
        $object->name = $request->input('name');
        $object->description = $request->input('description');
        if($request->hasFile('cover')){
            $object->cover = $request->cover->store('channels/covers');
        }else{
            $object->cover = NULL;
        }
        $object->category_id = $request->input('category_id');
        $object->country_id = $request->input('country_id');

        if($object->save()){
            $channel_id = $object->id;
            $errors = 0;
            $links = $request->input('links');
            if(count($links) > 0){
                for($i=0;$i<count($links);$i++){
                    $object = new Link();
                    $object->channel_id = $channel_id;
                    $object->url = $links[$i];
                    $object->position = ($i+1);
                    if(!$object->save()){
                        $errors++;
                    }
                }
            }
        }else{
           flash()->overlay('Error al tratar de insertar el Registro!!','Error'); 
        }

        if($errors > 0){
            DB::roolback();
            flash()->overlay('Error al tratar de insertar el Registro!!','Error');
        }else{
            DB::commit();
            flash()->overlay('Registro insertado con Exito!!','Exito');
        }

        return redirect()->route($this->route);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $object = Channel::findorfail($id);
        Storage::delete($object->cover);
        $object->cover = NULL;
        if($object->update()){
            $r = ['deleted' => 'yes'];
        }else{
            $r = ['deleted' => 'no'];
        }

        print json_encode($r);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Channel::findorfail($id);
        $countries = Country::all();
        $categories = Category::all();
        return view($this->view."save",['title' => 'Editar Canal','action' => 'update', 'data' => $data,'countries' => $countries,'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
            'category_id' => 'required'
        ]);

        DB::BeginTransaction();

        $object = Channel::findorfail($id);
        $object->user_id = Auth::user()->id;
        $object->name = $request->input('name');
        $object->description = $request->input('description');
        if($request->hasFile('cover')){
            $object->cover = $request->cover->store('channels/covers');
        }
        $object->category_id = $request->input('category_id');
        $object->country_id = $request->input('country_id');

        if($object->save()){
            $channel_id = $object->id;
            $errors = 0;
            $links = $request->input('links');
            if(count($links) > 0){
                $object->links()->delete();
                for($i=0;$i<count($links);$i++){
                    $object = new Link();
                    $object->channel_id = $channel_id;
                    $object->url = $links[$i];
                    $object->position = ($i+1);
                    if(!$object->save()){
                        $errors++;
                    }
                }
            }
        }else{
           flash()->overlay('Error al tratar de actualizar el Registro!!','Error'); 
        }

        if($errors > 0){
            DB::roolback();
            flash()->overlay('Error al tratar de actualizar el Registro!!','Error');
        }else{
            DB::commit();
            flash()->overlay('Registro actualizado con Exito!!','Exito');
        }

        return redirect()->route($this->route);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = Channel::findorfail($id);
        Storage::delete($object->cover);
        if($object->delete()){
            flash()->overlay('Registro Eliminado con Exito!!','Exito');
        }else{
            flash()->overlay('Error al tratar de eliminar el Registro','Error');
        }

        return redirect()->route($this->route);
    }
}
