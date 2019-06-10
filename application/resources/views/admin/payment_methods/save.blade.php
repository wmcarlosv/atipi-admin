@extends('adminlte::page')

@section('title', $title)

@section('content')

	@if($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h2>{{ $title }}</h2>
    	</div>
    	<div class="panel-body">

            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#payment_method">Metodo de Pago</a></li>
              <li><a data-toggle="tab" href="#fields">Campos</a></li>
            </ul>
            @if($action == 'new')
                {!! Form::open(['route' => 'payment_methods.store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            @else
                {!! Form::open(['route' => ['payment_methods.update',$data->id], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
            @endif
            <div class="tab-content">
              <div id="payment_method" class="tab-pane fade in active">
                <br />
                <div class="form-group">
                    <label for="name">Nombre: </label>
                    <input class="form-control" type="text" value="{{ @$data->name }}" name="name" id="name" />
                </div>
              </div>

              <div id="fields" class="tab-pane fade">
                <br />
                <button type="button" class="btn btn-success open-modal-field"><i class="fa fa-plus"> Agregar</i></button>
                <table class="table table-bordered table-striped list-fields">
                    <thead>
                        <th>Nombre</th>
                        <th>Valor</th>
                        <th>-</th>
                    </thead>
                    <tbody>
                        @if($action == 'update')
                            @foreach($data->fields as $f)
                                <tr>
                                    <td><input type="text" class="form-control" readonly="readonly" name="names[]" value="{{ $f->name }}"></td>
                                    <td><input type="text" class="form-control" readonly="readonly" name="values[]" value="{{ $f->value }}"></td>
                                    <td><button type='button' class='btn btn-danger delete-row'><i class='fa fa-times'></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
              </div>
            </div>

			<button class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
			<a class="btn btn-danger" href="{{ route('payment_methods.index') }}"><i class="fa fa-times"></i> Cancelar</a>
    		{!! Form::close() !!}
    	</div>
    </div>

    <!-- Fields Modal -->
    <div id="fields_modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Campo</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="fname">Nombre: </label>
                <input class="form-control" type="text" name="fname" id="fname">
            </div>
            <div class="form-group">
                <label for="value">Valor: </label>
                <input class="form-control" type="text" name="value" id="value">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success add-fields" data-dismiss="modal"><i class="fa fa-plus"></i> Agregar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
        </div>

      </div>
    </div>

@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $("button.open-modal-field").click(function(){
            $("#fields_modal").modal("show");
        });

        $("button.add-fields").click(function(){
            var fname = $("#fname").val();
            var value = $("#value").val();
            var html = "<tr>";
                html+= "<td><input type='text' readonly='readonly' class='form-control' name='names[]' value='"+fname+"' /></td>";
                html+= "<td><input type='text' readonly='readonly'  class='form-control' name='values[]' value='"+value+"' /></td>";
                html+= "<td><button type='button' class='btn btn-danger delete-row'><i class='fa fa-times'></i></button></td>";
            html+="</tr>";

            $("table.list-fields tbody").append(html);
            html = "";
            $("#fname,#value").val("");
            $("#fields_modal").modal("hide");
        });

        $("body").on('click','button.delete-row', function(){
            $(this).parent().parent().remove();
        });
    });
</script>
@stop