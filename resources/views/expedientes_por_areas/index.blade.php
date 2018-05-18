@extends ('layouts.admin')
@section ('contenido')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado de Expedientes </h3>

            @include('expedientes_por_areas.search')
            <br>
        </div>
    </div>

    <div class="row text-uppercase">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color: #8eb4cb">
                        <th>id</th>
                        <th>Tipo</th>
                        <th>OT</th>
                        <th>Referencia</th>
                        <th>Creador</th>
                        <th>Estado</th>
                        <th class="text-center">Opciones</th>

                    </thead>
                        @foreach ($expedientes as $expediente)
                            @if(in_array (Auth::user ()->role_id, [1,2]))
                                <!-- Para que los administradores vean los expedientes creados -->
                                    <tr >
                                        <td>{{$expediente->id}}</td>
                                        <td>{{$expediente->tipoexpediente->nombre}}</td>
                                        <td> {{$expediente->ot->codigo}} {{$expediente->ot->obra}}</td>
                                        <td>{{$expediente->referencia}}</td>
                                        <td>{{$expediente->creador->name}} {{$expediente->creador->lastname}}</td>
                                        @if($expediente->histories->last()->estado == 'aprobado')
                                            <td class="text-green">Aprobado</td>
                                        @elseif($expediente->histories->last()->estado == 'rechazado')
                                            <td class="text-danger">Rechazado</td>
                                        @else
                                            <td class="text-info">Pendiente</td>
                                        @endif
                                        <td class="text-center">
                                            <a href="{{URL::action('ExpedienteController@show',$expediente->id)}}"><button class="btn btn-primary">Detalles</button></a>
                                        </td>
                                    </tr>
                            @else
                                @if($expediente->creador->funcionario)
                                    @if($expediente->creador->funcionario->departamento->dependencia_id == Auth::user ()->area->id)
                                    <!-- Para que los gerentes vean los expedientes creados por los funcionarios (no jefes) de su gerencia -->
                                        <tr >
                                            <td>{{$expediente->id}}</td>
                                            <td>{{$expediente->tipoexpediente->nombre}}</td>
                                            <td> {{$expediente->ot->codigo}} {{$expediente->ot->obra}}</td>
                                            <td>{{$expediente->referencia}}</td>
                                            <td>{{$expediente->creador->name}} {{$expediente->creador->lastname}}</td>
                                            @if($expediente->histories->last()->estado == 'aprobado')
                                                <td class="text-green">Aprobado</td>
                                            @elseif($expediente->histories->last()->estado == 'rechazado')
                                                <td class="text-danger">Rechazado</td>
                                            @else
                                                <td class="text-info">Pendiente</td>
                                            @endif
                                            <td class="text-center">
                                                <a href="{{URL::action('ExpedienteController@show',$expediente->id)}}"><button class="btn btn-primary">Detalles</button></a>
                                            </td>
                                        </tr>
                                    @endif

                                    @if($expediente->creador->funcionario->departamento_id == Auth::user ()->area->id)
                                    <!--Para que los jefes vean los expedientes creados por sus funcionarios-->
                                        <tr >
                                            <td>{{$expediente->id}}</td>
                                            <td>{{$expediente->tipoexpediente->nombre}}</td>
                                            <td> {{$expediente->ot->codigo}} {{$expediente->ot->obra}}</td>
                                            <td>{{$expediente->referencia}}</td>
                                            <td>{{$expediente->creador->name}} {{$expediente->creador->lastname}}</td>
                                            @if($expediente->histories->last()->estado == 'aprobado')
                                                <td class="text-green">Aprobado</td>
                                            @elseif($expediente->histories->last()->estado == 'rechazado')
                                                <td class="text-danger">Rechazado</td>
                                            @else
                                                <td class="text-info">Pendiente</td>
                                            @endif
                                            <td class="text-center">
                                                <a href="{{URL::action('ExpedienteController@show',$expediente->id)}}"><button class="btn btn-primary">Detalles</button></a>
                                            </td>
                                        </tr>
                                    @endif
                                @elseif($expediente->creador->area)
                                    @if($expediente->creador->area->dependencia_id == Auth::user ()->area->id)
                                        <!--para que el gerente pueda ver los expedientes creados por los jefes de su gerencia-->
                                            <tr >
                                                <td>{{$expediente->id}}</td>
                                                <td>{{$expediente->tipoexpediente->nombre}}</td>
                                                <td> {{$expediente->ot->codigo}} {{$expediente->ot->obra}}</td>
                                                <td>{{$expediente->referencia}}</td>
                                                <td>{{$expediente->creador->name}} {{$expediente->creador->lastname}}</td>
                                                @if($expediente->histories->last()->estado == 'aprobado')
                                                    <td class="text-green">Aprobado</td>
                                                @elseif($expediente->histories->last()->estado == 'rechazado')
                                                    <td class="text-danger">Rechazado</td>
                                                @else
                                                    <td class="text-info">Pendiente</td>
                                                @endif
                                                <td class="text-center">
                                                    <a href="{{URL::action('ExpedienteController@show',$expediente->id)}}"><button class="btn btn-primary">Detalles</button></a>
                                                </td>
                                            </tr>
                                    @endif
                                @endif
                            @endif
                        @endforeach

                </table>
            </div>
            {{$expedientes->links()}}
        </div>

    </div>

@endsection