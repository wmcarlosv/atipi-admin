@extends('adminlte::page')

@section('title', $title)

@section('content')
	@include('flash::message')
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h2>{{ $title }}</h2>
    	</div>
    	<div class="panel-body">
    		<a href="{{ route('payment_methods.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo</a>
    		<br />
    		<br />
    		<table class="table table-bordered table-striped data-table">
    			<thead>
    				<th>ID</th>
    				<th>Nombre</th>
    				<th>Acciones</th>
    			</thead>
    			<tbody>
    				@foreach($data as $d)
    					<tr>
    						<td>{{ $d->id }}</td>
    						<td>{{ $d->name }}</td>
    						<td>
    							<a href="{{ route('payment_methods.edit',['id' => $d->id]) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Editar</a>
    							{!! Form::open(['route' => ['payment_methods.destroy',$d->id], 'method' => 'DELETE', 'style' => 'display:inline;']) !!}
    								<button class="btn btn-danger delete-row"><i class="fa fa-times"></i> Eliminar</button>
    							{!! Form::close() !!}
    						</td>
    					</tr>
    				@endforeach
    			</tbody>
    		</table>
    	</div>
    </div>
@stop
@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			$("table.data-table").DataTable();
			$('#flash-overlay-modal').modal();
			$("body").on('click','button.delete-row', function(){
				if(!confirm("Estas seguro de eliminar este Registro?")){
					return false;
				}
			});
		});
	</script>
@stop