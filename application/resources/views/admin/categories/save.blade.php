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
    			{!! Form::open(['route' => 'categories.store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    		@else
    			{!! Form::open(['route' => ['categories.update',$data->id], 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    		@endif
    			<div class="form-group">
    				<label for="name">Nombre: </label>
    				<input class="form-control" type="text" value="{{ @$data->name }}" name="name" id="name" />
    			</div>
    			<button class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
    			<a class="btn btn-danger" href="{{ route('categories.index') }}"><i class="fa fa-times"></i> Cancelar</a>
    		{!! Form::close() !!}
    	</div>
    </div>
@stop