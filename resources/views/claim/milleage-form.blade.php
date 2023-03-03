
    <div class="container ">
        <div class="container-fluid">
            <h3 class="fw-bold text-center text-uppercase pt-3 pb-2">MILLEAGE CLAIM</h3>
                <table class="table table-bordered" >
                    <tr class="bg-light">
                        <th class="text-center" style="width: 2%;">No</th>
                        <th class="text-center" style="width: 10%;">Date</th>
                        <th class="text-center" style="width: 10%;">Vehicle</th>
                        <th class="text-center col-3">Origin</th>
                        <th class="text-center col-3 ">Destination</th>
                        <th class="text-center col-1 ">Compute</th>
                        <th class="text-center" style="width: 10%;">Total (RM)</th>
                        <th class="text-center" style="width: 10%;">Distance (KM)</th>
                        <th class="text-center col-2 ">Action</th>
                       
                    </tr>

                    @if (count($milleages) > 0)
                    <?php $i = 0?>
                        @foreach ($milleages as $milleage)
                        <tr>
                            <td class="text-center">{{++$i}}.</td>
                            <td><input type="date" class="form-control" value="{{$milleage->date}}" disabled></td>
                            <td><input class="form-select" value="{{$milleage->vehicle}}" disabled></select>
                            </td>
                            <td><input type="text" class="form-control" value="{{$milleage->origin}}" disabled></td>
                            <td><input type="text" class="form-control" value="{{$milleage->destination}}"  disabled></td>
                            <td class="text-center"><button type ="button" class="btn btn-primary"disabled><b>Calculate</b></button></td>
                            <td><input type="text" class="form-control text-center" name="milleage" value="{{$milleage->total}}"  disabled/></td>
                            <td><input type="text" class="form-control text-center" value="{{$milleage->distance}}"  disabled/></td>
                            <td class="text-center">
                            <a href ="{{ route('milleage.destroy', ['id' => $milleage->id]) }}" name="add" class="btn btn-outline-danger">-</a>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    {!! Form::open(['action' => '\App\Http\Controllers\MilleageController@store', 'method'=>'POST','enctype' => 'multipart/form-data']) !!}
                    <tr>
                        <td class="text-center"></td>
                        <td><input type="date" name="date" class="form-control" value="20/22/2022" required></td>
                        <td><select id="vehicle" name="vehicle" class="form-select" required>
                            <option value="" disabled selected>Choose vehicle</option>
                            <option value="car"selected>Car</option>
                            <option value="motor">Motor</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" name="origin" id="departure" placeholder="Enter your departure place" required></td>
                        <td><input type="text" class="form-control" name="destination" id="destination" placeholder="Enter your destination place" required></td>
                        <td class="text-center"><button type ="button" class="btn btn-primary" id="calc" name="calc"  onclick="calculate()"><b>Calculate</b></button></td>
                        <td><input type="text" class="form-control text-center input" name="milleage" id ="milleage" value="0.00"/></td>
                        <td><input type="text" class="form-control text-center" name="distance" id ="distance" value="0.00" /></td>
                        <td class="text-center">
                            <button type="submit" name="NEW" class="btn btn-outline-primary button">+</button>
                        </td>
                    </tr>
                    {!! Form::close() !!} 
                </table>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                </div> 
        </div>
    </div>
    
