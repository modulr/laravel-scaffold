@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <div class="col-12">
            <h2 class="mb-3">Horario</h2>
            <table class="table table-bordered table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Horario</th>
                    <th scope="col">Lunes</th>
                    <th scope="col">Martes</th>
                    <th scope="col">Miércoles</th>
                    <th scope="col">Jueves</th>
                    <th scope="col">Viernes</th>
                    <th scope="col">Sabado</th>
                    <th scope="col">Domingo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $row)
                @if ($loop->first)
                <tr class="table-info">
                    <th scope="row">{{ $row->schedule}}</th>
                    <td class="{{ $row->monday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->monday}}</td>
                    <td class="{{ $row->tuesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->tuesday}}</td>
                    <td class="{{ $row->wednesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->wednesday}}</td>
                    <td class="{{ $row->thursday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->thursday}}</td>
                    <td class="{{ $row->friday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->friday}}</td>
                    <td class="{{ $row->saturday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->saturday}}</td>
                    <td class="{{ $row->sunday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->sunday}}</td>
                </tr>
                @endif
                @if ($row->schedule == 'Mañana 8:00am/1:00pm')
                <tr class="table-warning">
                    <th scope="row">{{ $row->schedule}}</th>
                    <td class="{{ $row->monday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->monday}}</td>
                    <td class="{{ $row->tuesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->tuesday}}</td>
                    <td class="{{ $row->wednesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->wednesday}}</td>
                    <td class="{{ $row->thursday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->thursday}}</td>
                    <td class="{{ $row->friday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->friday}}</td>
                    <td class="{{ $row->saturday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->saturday}}</td>
                    <td class="{{ $row->sunday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->sunday}}</td>
                </tr>
                @endif
                @if ($row->schedule == 'Medio día 12:00pm/5:00pm')
                <tr class="table-danger">
                    <th scope="row">{{ $row->schedule}}</th>
                    <td class="{{ $row->monday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->monday}}</td>
                    <td class="{{ $row->tuesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->tuesday}}</td>
                    <td class="{{ $row->wednesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->wednesday}}</td>
                    <td class="{{ $row->thursday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->thursday}}</td>
                    <td class="{{ $row->friday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->friday}}</td>
                    <td class="{{ $row->saturday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->saturday}}</td>
                    <td class="{{ $row->sunday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->sunday}}</td>
                </tr>
                @endif
                @if ($row->schedule == 'Tarde 5:00pm/10:00pm')
                <tr class="table-success">
                    <th scope="row">{{ $row->schedule}}</th>
                    <td class="{{ $row->monday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->monday}}</td>
                    <td class="{{ $row->tuesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->tuesday}}</td>
                    <td class="{{ $row->wednesday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->wednesday}}</td>
                    <td class="{{ $row->thursday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->thursday}}</td>
                    <td class="{{ $row->friday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->friday}}</td>
                    <td class="{{ $row->saturday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->saturday}}</td>
                    <td class="{{ $row->sunday == 'DISPONIBLE' ? 'font-weight-bold' : '' }}">{{ $row->sunday}}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
