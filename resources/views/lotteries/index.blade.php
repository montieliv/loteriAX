@extends('layouts.app')

@section('content')
<div class="row">
    <h1>Bienvenido! 
    <a href="{{ route('lotteries.create') }}" class="btn btn-primary mb-3">Crear Nuevo Sorteo</a>
    <a href="/" class="btn btn-danger mb-3">Inicio</a></h1>
    <div class="table table-bordered">
        <table class="table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Orden de las Cartas</th>
                    <th>Costos</th>
                    <th>Premios</th>
                    <th>Status</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lotteries as $lottery)
                <tr>
                    <td>{{ $lottery->date->format('d-m-Y') }}</td>
                    <td> <textarea rows="4" cols="35" readonly>{{ $lottery->order_cards }}</textarea></td>
                    <td> <textarea rows="4" cols="35" readonly>{{ $lottery->cost_cards }}</textarea></td>
                    <td> <textarea rows="4" cols="35" readonly>{{ $lottery->prize_cards }}</textarea> 
                    <td>{{ ucfirst($lottery->status) }}<br> Sorteo #{{ $lottery->id}}</td>
                    <td>
                        <a href="{{ route('lotteries.show', $lottery) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('lotteries.edit', $lottery) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('lotteries.destroy', $lottery) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection