<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethod;
use App\Field;
use DB;

class PaymentMethodsController extends Controller
{
    private $view = 'admin.payment_methods..';
    private $route = "payment_methods.index";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PaymentMethod::all();
        return view($this->view."index",['title' => 'Metodos de Pago','data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->view."save",['title' => 'Nuevo Metodo de Pago', 'action' => 'new']);
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
            'name' => 'required'
        ]);

        DB::beginTransaction();

        $object = new PaymentMethod();
        $object->name = $request->input('name');

        if($object->save()){
            $errors = 0;
            $payment_method_id = $object->id;
            $names = $request->input('names');
            $values = $request->input('values');

            if(!empty($names)){
                for($i = 0; $i < count($names); $i++){
                    $object = new Field();
                    $object->payment_method_id = $payment_method_id;
                    $object->name = $names[$i];
                    $object->value = $values[$i];

                    if(!$object->save()){
                        $errors++;
                    }
                }   
            }
            
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PaymentMethod::findorfail($id);
        return view($this->view."save",['title' => 'Editar Metodo de Pago','action' => 'update', 'data' => $data]);
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
            'name' => 'required'
        ]);

        DB::beginTransaction();

        $object = PaymentMethod::findorfail($id);
        $object->name = $request->input('name');

        if($object->save()){
            $errors = 0;
            $payment_method_id = $object->id;
            $names = $request->input('names');
            $values = $request->input('values');

            if(!empty($names)){

                $object->fields()->delete();

                for($i = 0; $i < count($names); $i++){
                    $object = new Field();
                    $object->payment_method_id = $payment_method_id;
                    $object->name = $names[$i];
                    $object->value = $values[$i];

                    if(!$object->save()){
                        $errors++;
                    }
                }   
            }
            
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
        $object = PaymentMethod::findorfail($id);
        if($object->delete()){
            flash()->overlay('Registro Eliminado con Exito!!','Exito');
        }else{
            flash()->overlay('Error al tratar de eliminar el Registro','Error');
        }

        return redirect()->route($this->route);
    }
}
