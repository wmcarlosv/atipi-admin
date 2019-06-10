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
              <li class="active"><a data-toggle="tab" href="#channel">Canal</a></li>
              <li><a data-toggle="tab" href="#links">Links</a></li>
            </ul>
            @if($action == 'new')
                {!! Form::open(['route' => 'channels.store', 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
            @else
                {!! Form::open(['route' => ['channels.update',$data->id], 'method' => 'PUT', 'autocomplete' => 'off', 'files' => true]) !!}
            @endif
            <div class="tab-content">
              <div id="channel" class="tab-pane fade in active">
                <br />
                <div class="form-group">
                    <label for="name">Nombre: </label>
                    <input class="form-control" type="text" value="{{ @$data->name }}" name="name" id="name" />
                </div>
                <div class="form-group">
                    <label for="description">Descripci&oacute;n: </label>
                    <textarea class="form-control" name="description" id="description">{{ @$data->description }}</textarea>
                </div>
                @if($action == 'new')
                <div class="form-group">
                    <label for="cover">Portada: </label>
                    <input class="form-control" type="file" name="cover" id="cover" />
                </div>
                @else
                    @if(isset($data->cover) and !empty($data->cover))
                        <div class="cover-content">
                            <label>Portada:</label>
                            <br />
                            <img src="{{ asset('application/storage/app/'.$data->cover) }}" class="img-thumbnail" width="150" height="150">
                            <button type="button" class="btn btn-danger delete-cover"><i class="fa fa-times"></i></button>
                        </div>
                        <br />
                        <div class="form-group hiden-cover" style="display: none;">
                            <label for="cover">Portada: </label>
                            <input class="form-control" type="file" name="cover" id="cover" />
                        </div>
                    @else
                        <div class="form-group">
                            <label for="cover">Portada: </label>
                            <input class="form-control" type="file" name="cover" id="cover" />
                        </div>
                    @endif
                @endif
                <div class="form-group">
                    <label for="country_id">Pais: </label>
                    <select class="form-control" name="country_id" id="country_id">
                        <option>-</option>
                        @foreach($countries as $c)
                            <option value='{{ $c->id }}' @if(@$data->country_id == $c->id) selected = 'selected' @endif>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="category_id">Categoria: </label>
                    <select class="form-control" name="category_id" id="category_id">
                        <option>-</option>
                        @foreach($categories as $c)
                            <option value='{{ $c->id }}' @if(@$data->category_id == $c->id) selected = 'selected' @endif>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
              </div>
              <div id="links" class="tab-pane fade">
                <br />
                <button class="btn btn-success open-links-modal" type="button"><i class="fa fa-plus"></i> Agregar</button>
                <table class="table table-bordered table-striped list-links">
                    <thead>
                        <th>Url</th>
                        <th>-</th>
                    </thead>
                    <tbody>
                        @if($action == 'update')
                            @foreach($data->links as $l)
                                <tr>
                                    <td><input type='text' name='links[]' readonly='readonly' class='form-control' value='{{ $l->url }}' /></td>
                                    <td><button type='button' class='btn btn-danger delete-row'><i class='fa fa-times'></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
              </div>
            </div>
			<button class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
			<a class="btn btn-danger" href="{{ route('channels.index') }}"><i class="fa fa-times"></i> Cancelar</a>
    		{!! Form::close() !!}
    	</div>
    </div>

    <!-- Links Modal -->
    <div id="links_modal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Agregar Links</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <label for="link">Link</label>
                <input class="form-control" type="text" name="link" id="link" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-success add-links"><i class="fa fa-plus"></i> Agregar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
          </div>
        </div>

      </div>
    </div>
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $("button.delete-cover").click(function(){
            if(confirm("Esta seguro de eliminar este Cover?")){
                var url = "{{ route('channels.show',['id' => @$data->id]) }}";
                $.get(url, function( response ){
                    var r = JSON.parse(response);
                    if(r.deleted == "yes"){
                        alert("Cover eliminado con Exito!!");
                        $("div.cover-content").hide();
                        $("div.hiden-cover").show();
                    }
                });
            }
        });

        $("button.open-links-modal").click(function(){
            $("#links_modal").modal("show");
        });

        $("button.add-links").click(function(){
            var link = $("#link").val();
            var html = "<tr>";
                html+= "<td><input type='text' name='links[]' readonly='readonly' class='form-control' value='"+link+"' /></td>";
                html+= "<td><button type='button' class='btn btn-danger delete-row'><i class='fa fa-times'></i></button></td>";
                html+= "</tr>";
                $("table.list-links tbody").append(html);
                html = "";
                $("#link").val("");
                $("#links_modal").modal("hide");
        });

        $("body").on('click','button.delete-row', function(){
            $(this).parent().parent().remove();
        });

    });
</script>
@stop