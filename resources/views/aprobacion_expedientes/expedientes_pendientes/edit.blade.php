@extends ('layouts.admin')
@section ('contenido')


    <div class="row text-uppercase">
        @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    {!!Form:: model($expediente, ['method'=>'PATCH', 'route'=>['expedientes_pendientes.update', $expediente->id]])!!}
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="id">ID</label>
                <p>{{$expediente->id}}</p>
            </div>
        </div>


        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label>Tipo Expediente</label>
                <p>{{$expediente->tipoexpediente->nombre}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="ot">OT</label>
                <p style="color: #23527c">{{$expediente->ot->codigo}} - {{$expediente->ot->obra}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="creador">Creador - Area</label>
                <p>{{$expediente->creador->name}} {{$expediente->creador->lastname}} -
                    {{$expediente->creador->funcionario ? $expediente->creador->funcionario->departamento->nombre : $expediente->creador->area->nombre}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="referencia">Referencia</label>
                <p>{{$expediente->referencia}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <p>{{$expediente->proveedor->name}} {{$expediente->proveedor->lastname}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="monto">Monto</label>
                <p>{{$expediente->monto}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="anterior">Area Anterior</label>
                <p>{{$history_anterior->area->nombre}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="fecha_creacion">Fecha creación</label>
                <p>{{$expediente->fecha_creacion}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="fecha_entrada">Fecha entrada</label>
                <p>{{$history->fecha_entrada}}</p>
            </div>
        </div>


        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="notas">Notas del Expediente</label>
                <p>{{$expediente->notas}}</p>
            </div>
        </div>

        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="notas">Regularización</label>
                <p>{{$history->observaciones_regularizacion}}</p>
            </div>
        </div>

        <div class=" col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
            <br>
            <div class="panel-default">
                <div class="panel-heading text-center" style="background-color: #8eb4cb">Aprobación</div>
                <div class="panel-body text-center">
                    <legend>Aprobar o Rechazar Expediente</legend>

                    <label>
                        <input type="radio" name="estado" value="aprobado" onclick="cerrar_todos()" checked> Aprobar
                    </label>
                    @if(in_array (Auth::user ()->role_id, [1,2]))
                        <label>
                            <input type="radio" name="estado" value="enviar_final" onclick="enviar_adelante()" > Enviar al final
                        </label>
                    @endif
                    <label>
                        <input type="radio" name="estado" value="rechazado" onclick="enviar_atras()"> Rechazar
                    </label>
                </div>
            </div>

        </div>

        <div class=" col-lg-6 col-sm-6 col-md-6 col-xs-12 ">
                <br>
                <div class="panel-default" id="enviar_area" style="display: none">
                    <div class="panel-heading text-center" style="background-color: #8eb4cb">Enviar a...</div>
                    <div class="panel-body text-center" >
                        <div class="form-group">
                            <label>
                                <input type="radio" id="radio_button" name="radio_button" value="area_actual" onclick="cerrar_select()" checked>Actual
                            </label>

                            <label>
                                <input type="radio" id="radio_button" name="radio_button" value="otra_area" onclick="mostrar_select()">Seleccionar Area
                            </label>

                            <div class="" style="display: none" id="select_area">
                                <select name="select_area_id" id="select_area_id" class="form-control text-uppercase selectpicker" data-live-search="true" title="Seleccione un area">
                                    @foreach($collect_anteriores as $area)
                                        <option value="{{$area->id}}" >{{$area->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea class="form-control" rows="2" name="observaciones" id="observaciones">Observaciones:</textarea>
                        </div>

                    </div>
                </div>

            </div >

        <div class=" col-lg-6 col-sm-6 col-md-6 col-xs-12 " style="display: none" id="enviar_final">
            <div class="panel-default" id="enviar_final"  >
                <div class="panel-heading text-center" style="background-color: #8eb4cb">Areas siguientes</div></div>
                <div class="panel-body text-center" >
                    <div class="form-group">
                        <div class="" id="select_area">
                            <select name="id_area_siguiente" id="id_area_siguiente" class="form-control text-uppercase selectpicker" data-live-search="true" title="Seleccione un area">
                                @foreach($collect_siguientes as $area)
                                    <option value="{{$area->id}}" >{{$area->nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea class="form-control" rows="2" name="observaciones_adelante" id="observaciones_adelante">Observaciones:</textarea>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group text-center">
                <button class="btn btn-primary" type="submit" id="bt_enviar" name="bt_enviar" onclick="">enviar</button>
                <button class="btn btn-danger" type="reset" onclick="cerrar_areas()">Cancelar</button>
            </div>
        </div>
    </div>

    {!!Form::close()!!}

    @push('scripts')
        <script>

            function mostrar_areas() {

                area = document.getElementById('enviar_area');
                area.style.display = '';
                
            }

            function cerrar_areas() {

                area = document.getElementById('enviar_area');
                area.style.display = 'none';
            }

            function mostrar_select() {

                select = document.getElementById('select_area');
                select.style.display = '';

                $("#select_area_id").prop('required', true);
            }

            function cerrar_select() {

                select = document.getElementById('select_area');
                select.style.display = 'none';
                $("#select_area_id").removeAttr('required');
            }

            function mostrar_areas_siguientes()
            {
                area = document.getElementById('enviar_final');
                area.style.display = '';
                $("#id_area_siguiente").prop('required', true);

            }

            function cerrar_areas_siguientes() {
                area = document.getElementById('enviar_final');
                area.style.display = 'none';
            }

            function cerrar_todos() {
                cerrar_areas();
                cerrar_areas_siguientes()
                $("#id_area_siguiente").removeAttr('required');
                $("#select_area_id").removeAttr('required');

            }

            function enviar_adelante() {
                cerrar_areas();
                mostrar_areas_siguientes();
                $("#select_area_id").removeAttr('required');
            }

            function enviar_atras() {
                cerrar_areas_siguientes();
                mostrar_areas()
            }

        </script>
    @endpush
@endsection