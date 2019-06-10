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
    		@if($action == 'new')
    			{!! Form::open(['route' => 'channels.store', 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
    		@else
    			{!! Form::open(['route' => ['channels.update',$data->id], 'method' => 'PUT', 'autocomplete' => 'off', 'files' => true]) !!}
    		@endif
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
    			<button class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
    			<a class="btn btn-danger" href="{{ route('channels.index') }}"><i class="fa fa-times"></i> Cancelar</a>
    		{!! Form::close() !!}
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
    });
</script>
@stop