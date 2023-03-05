@extends('layouts.app')
@section('content')

<p class="text-center fs-6 mt-2 fs-1 fw-bold">Claim Forms <br></p>
<div class="container">
<div class="accordion " id="accordionExample">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          <span class="fs4">Milleage Claim</span>
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <div class="container ">
            <div class="container-fluid">
                <h3 class="fw-bold text-center text-uppercase pt-3 pb-2">MILLEAGE CLAIM</h3>
                    <table class="table table-bordered" width="500" >
                        <tr class="bg-light">
                            <th class="text-center" >No</th>
                            <th class="text-center" width:" 1%">Date</th>
                            <th class="text-center col-2">Project</th>
                            <th class="text-center" style="width: 10%;">Vehicle</th>
                            <th class="text-center col-3">Origin</th>
                            <th class="text-center col-3 ">Destination</th>
                            <th class="text-center "></th>
                            <th class="text-center" style="width: 10%;">Total(RM)</th>
                            <th class="text-center col-1" style="width: 100%;">Distance(KM)</th>
                            <th class="text-center col-2 ">Action</th>
                           
                        </tr>
    
                        @if (count($milleages) > 0)
                        <?php $i = 0?>
                            @foreach ($milleages as $milleage)
                            <tr>
                                <td class="text-center">{{++$i}}.</td>
                                <td><input type="date" class="form-control" value="{{$milleage->date}}" disabled></td>
                                {{-- <td><input class="form-select" value="{{$milleage->project}}" disabled></select></td> --}}
                                @if (!(is_null($milleage->project)))
                                    @foreach ($projectx as $project)
                                        @if ($project->code === $milleage->project)
                                            <td><input class="form-select" value="{{$project->name}}" disabled></select></td>

                                        @endif
                                    @endforeach
                                @else
                                <td><input class="form-select" value="{{$milleage->project}} " disabled></select></td>
                                @endif
                                <td><input class="form-select" value="{{$milleage->vehicle}}" disabled></select></td>
                                <td colspan="2">
                                    <div class="d-flex gap-1">
                                        <input type="text" class="form-control" value="{{$milleage->origin}}" disabled>
                                        <i class="fa-solid fa-circle-arrow-right mx-2 text-primary my-auto"></i>
                                        <input type="text" class="form-control" value="{{$milleage->destination}}"  disabled>
                                    </div>
                                        <p class="text-center pt-2 m-0 p-0" style="font-size: 0.8rem">Detail: {{$milleage->detail}}</p>
                                </td>
                                <td class="text-center"><button type ="button" class="btn btn-primary"disabled><b><i class="fa-solid fa-calculator"></i></b></button></td>
                                <td><input type="text" class="form-control text-center" name="milleage" value="{{$milleage->total}}"  disabled/></td>
                                <td><input type="text" class="form-control text-center" value="{{$milleage->distance}}"  disabled/></td>
                                <td class="text-center">
                                <a href ="{{ route('milleage.destroy', ['id' => $milleage->id]) }}" name="add" class="btn btn-outline-danger">-</a>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        {!! Form::open(['action' => '\App\Http\Controllers\MilleageController@store', 'method'=>'POST','enctype' => 'multipart/form-data', 'onsubmit'=>'return validate()']) !!}
                        <tr>
                            <td class="text-center"></td>
                            <td width="1%"><input type="date" name="date" class="form-control" value="20/22/2022" required></td>
                            <td><select id="type" name="project" class="form-select">
                                <option value="">Project</option>
                                @foreach ($projects as $project)
                                    <option value="{{$project->code}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                            </td>
                            <td><select id="vehicle" name="vehicle" class="form-select" required onchange="resetTotal()">
                                <option value="" disabled selected>Choose vehicle</option>
                                <option value="car"selected>car</option>
                                <option value="motor">motor</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="origin" id="departure" placeholder="Enter your origin" required></td>
                            <td><input type="text" class="form-control" name="destination" id="destination" placeholder="Enter your destination " required></td>
                            <td class="text-center"><button type ="button" class="btn btn-primary" id="calc" name="calc"  onclick="calculate()"><b><i class="fa-solid fa-calculator"></i></b></button></td>
                            <td><input type="text" class="form-control text-center input" name="milleage" id ="milleage" value="0.00" readonly/></td>
                            <td><input type="text" class="form-control text-center" name="distance" id ="distance" value="0.00" readonly/></td>
                            <td><button data-bs-toggle="modal" data-bs-target="#addMilleage" name="NEW" class="btn btn-outline-primary button">+</button></td>
                                <!-- Modal -->
                                <div class="modal fade" id="addMilleage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-center" id="exampleModalLabel">TRIP DETAILS</b></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row g-3 text-start">
                                                <div class="col-md-12">
                                                    <label for="skill_summary" class="form-label">Trip Detail</label>
                                                    <input type="text" class="form-control" name="detail" placeholder="Describe the detail of your trip" required>
                                                </div>       
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary fw-bold"><b>Add Claim</b></button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            
                        </tr>
                        {!! Form::close() !!} 
                    </table>
            </div>
        </div>
        </div>
      </div>
    </div>
    <script>
        function validate(){
            var milleage = (document.getElementById('milleage').value);

            if ((milleage == 0)){
                alert("Please click calculate button first.");
                return false;
            }

            else return true;
        }

        function resetTotal(){
            let milleage = document.getElementById("milleage");
            let distance = document.getElementById("distance");

            milleage.value = 0.00;
            $('#milleage').html(milleage.value);
            distance.value = 0.00;
            $('#distance').html(distance.value);

        }
    </script>
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Claim Form
        </button>
      </h2>
      <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <div class="container  mt-5">
            <div class="container-fluid ">
    
                <h3 class="fw-bold text-center text-uppercase pt-3 pb-2">Make A New Claim</h3>
                    <table class="table table-bordered" id="dynamicAddRemove">
                        <tr>
                            <th class="text-center" style="width: 1%;">No</th>
                            <th class="text-center col-1" style="width: 2%;">Date</th>
                            <th class="text-center col-1 ">Project</th>
                            <th class="text-center col-3 ">Detail</th>
                            <th class="text-center col-1 ">Amount (RM)</th>
                            <th class="text-center  col-1">Receipt</th>
                            <th class="text-center  col-1">Type</th>
                            <th class="text-center col-1" style="width: 1%;">Action</th>
                        </tr>
    
                        @if (count($claims)>0)
                        <?php $count = 0;?>
                            @foreach($claims as $claim)
                                <tr>
                                    <td class="text-center">{{++$count}}.</td>
                                    <td><input type="date" id="indexDate" name="date" value="{{$claim->date}}" class="form-control" disabled/></td>
                                    
                                    @if (!empty($claim->project))
                                        @foreach ($projects as $project)
                                            @if ($project->code === $claim->project)
                                                <td><input type="text" name="project" value="{{$project->name}}" class="form-select" disabled></td>
                                            @endif
                                        @endforeach
                                    @else
                                    <td><input class="form-select" value="" disabled></select></td>

                                    @endif
                                    
                                    <td><input type="text" name="detail" value="{{$claim->detail}}" class="form-control" disabled/></td>
                                    <td><input type="number" step="0.01" min="0" name="amount" value="{{$claim->amount}}" class="form-control" disabled/></td>
                                    <td><input type="file" name="receipt" class="form-control" disabled/></td>
                                    <td><input type="text" id="type" name="type" class="form-select" value="{{$claim->type}}" disabled></td>
                                    
                                    <td class="text-center"><a href="{{ route('claim.destroy', ['id' => $claim->id]) }}" type="submit" name="add" id="dynamic-ar" class="btn btn-outline-danger">-</a></td>
                                </tr>
                            @endforeach
                        @endif
    
                        {!! Form::open(['action' => '\App\Http\Controllers\ClaimController@store', 'method'=>'POST','enctype' => 'multipart/form-data']) !!}
                            <tr>
                                <td class="text-center"></td>
                                <td><input type="date" id="indexDate"name="date" placeholder="Enter Date" class="form-control" required/></td>
                                <td><select id="type" name="project" class="form-select">
                                    <option value="">Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{$project->code}}">{{$project->name}}</option>
                                    @endforeach
                                </select>
                                </td>
                                <td><input type="text" name="detail" placeholder="Enter subject" class="form-control" required/></td>
                                <td><input type="number" step="0.01" min="0" name="amount" placeholder="RM" class="form-control" required/></td>
                                <td><input type="file" name="receipt" class="form-control" required/></td>
                                <td><select id="type" name="type" class="form-select" required>
                                    <option value="">Claim</option>
                                    <option value="parking">Parking, Toll and Taxi</option>
                                    <option value="accomodation">Accomodation</option>
                                    <option value="equipment">Project Equipment</option>
                                    <option value="meal">Meals</option>
                                    <option value="office">Office Expenses</option>
                                    <option value="others">Others</option>
                                </select>
                                </td>
                                
                                <td class="text-center"><button type="submit" name="add" id="dynamic-ar" class="btn btn-outline-primary">+</button></td>
                            </tr>
                        {!! Form::close() !!} 
                    </table>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
  <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-2">
    <a href="{{ route('claim.edit', ['id' => $id]) }}" class="btn btn-success btn-block fw-bold mb-3" type="button">Submit Claim</a>
</div>
</div>
    

<script>
    claimdate.max = new Date().toISOString().split("T")[0];

    function switchText(){
    var obj1 = $('#departure').val();
    var obj2 = $('#destination').val();

    var temp = obj1;
    obj1 = obj2;
    obj2 = temp;
    
    // Save the swapped values to the input element.
    document.getElementById("departure").value = obj1;
    document.getElementById("destination").value = obj2;

    
        
    }

    var milleage = 0;
    function calculateDistance(origin, destination) {
    var service = new google.maps.DistanceMatrixService();
    service.getDistanceMatrix(
    {
    origins: [origin],
    destinations: [destination],
    travelMode: google.maps.TravelMode.DRIVING,
    unitSystem: google.maps.UnitSystem.IMPERIAL,
    avoidHighways: false,
    avoidTolls: false
    }, callback);
    }

    function callback(response, status) {
    if (status != google.maps.DistanceMatrixStatus.OK) {
    $('#result').html(err);
    } else {
    var origin = response.originAddresses[0];
    var destination = response.destinationAddresses[0];
    if (response.rows[0].elements[0].status === "ZERO_RESULTS") {
        $('#distance').html("Invalid route.");
    } else {
        var distance = response.rows[0].elements[0].distance;
        var distance_value = distance.value/1000;
        distance_value = (distance_value).toFixed(2);
        
        if ($("#vehicle option:selected" ).val()=="car"){
            milleage = (distance_value*0.7).toFixed(2);
            $('#distance').html("Distance: " + distance_value + " km." + "<br>"+ "Milleage claim: RM" + milleage);
        }
        

        else if ($("#vehicle option:selected" ).val() =="motor"){
            milleage = (distance_value*0.4).toFixed(2);
            $('#distance').html("Distance: " + distance_value + " km." + "<br>"+ "Milleage claim: RM" + milleage);
        }

        else{
            alert ("Choose vehicle.");
            $('#distance').html(milleage);
        }
        

        
        document.getElementById("milleage").value = milleage;
        document.getElementById("distance").value = distance_value;
    }
    }
    }

    function calculate(){
    event.preventDefault();
    var origin = $('#departure').val();
    var destination = $('#destination').val();
    // var vehicle = $('input[name="vehicle"]:checked').val();
    var distance_text = calculateDistance(origin, destination);

    };
    </script>
    
@endsection

