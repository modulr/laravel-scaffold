@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <div class="col-12 col-md-10">
            <h1>TRÁEME</h1>
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
                <tr class="table-info">
                    <th scope="row">Coordinadoras 8:00am/10:00pm</th>
                    <td>Ashley Martinez 6271036390</td>
                    <td>Ashley Martinez</td>
                    <td>Aglae Olage 6271329888</td>
                    <td>Ema Gonzalez 6141038904</td>
                    <td>Ema Gonzalez</td>
                    <td>Ema Gonzalez</td>
                    <td>Aglae Olage</td>
                </tr>
                <tr class="table-warning">
                    <th scope="row">Mañana 8:00am/1:00pm</th>
                    <td><strong>DISPONIBLE</strong></td>
                    <td>Eduardo Torres 6271114573</td>
                    <td>Eduardo Torres</td>
                    <td>Eduardo Torres</td>
                    <td>Eduardo Torres</td>
                    <td></td>
                    <td>Eduardo Torres</td>
                </tr>
                <tr class="table-warning">
                    <th scope="row"></th>
                    <td>Ivan Trujillo 6271217227</td>
                    <td>Ivan Trujillo</td>
                    <td>Ivan Trujillo</td>
                    <td>Ivan Trujillo</td>
                    <td>Ivan Trujillo</td>
                    <td>Ivan Trujillo</td>
                    <td></td>
                </tr>
                <tr class="table-warning">
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Luis Carlos 6271424323</td>
                    <td>Luis Carlos</td>
                    <td>Eduardo Mares</td>
                    <td>Eduardo Mares</td>
                </tr>
                <tr class="table-danger">
                    <th scope="row">Medio día 12:00pm/5:00pm</th>
                    <td>Kevin Ramirez 6271192425</td>
                    <td>Kevin Ramirez</td>
                    <td>Kevin Ramirez</td>
                    <td>Kevin Ramirez</td>
                    <td>Carlos Cazares 6271129136</td>
                    <td>Carlos Cazares</td>
                    <td>Carlos Cazares</td>
                </tr>
                <tr class="table-danger">
                    <th scope="row"></th>
                    <td>Eduardo Villanueva 6271104286</td>
                    <td>Eduardo Villanueva</td>
                    <td>Eduardo Villanueva</td>
                    <td>Eduardo Villanueva</td>
                    <td>Eduardo Villanueva</td>
                    <td><strong>DISPONIBLE</strong></td>
                    <td>Kevin Ramirez</td>
                </tr>
                <tr class="table-success">
                    <th scope="row">Tarde 5:00pm/10:00pm</th>
                    <td>Eduardo Mares 6275172213</td>
                    <td>Eduardo Mares</td>
                    <td>Eduardo Mares</td>
                    <td>Eduardo Mares</td>
                    <td><strong>DISPONIBLE</strong></td>
                    <td>Luis Carlos</td>
                    <td>Luis Carlos</td>
                </tr>
                <tr class="table-success">
                    <th scope="row"></th>
                    <td>Luigi Castillo 6271031150</td>
                    <td>Luigi Castillo</td>
                    <td>Luigi Castillo</td>
                    <td>Luigi Castillo</td>
                    <td>Luigi Castillo</td>
                    <td><strong>DISPONIBLE</strong></td>
                    <td>Luigi Castillo</td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
