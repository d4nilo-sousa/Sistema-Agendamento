@extends('layout')

@section('content')


<div class="card shadow">
    <div class="card-header bg-secondary">
    <h1 class="text-white fw-bold">📝Agendamentos</h1>
</div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Data</th>
                    <th>Manhã</th>
                    <th>Aulas</th>
                    <th>Espaço</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>21/05/2025</td>
                    <td>
                        <input type="checkbox">
                        <input type="checkbox">
                        <input type="checkbox">
                        <input type="checkbox">
                        <input type="checkbox">
                        <input type="checkbox">
                    </td>
                    <td>Laboratório 04</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection