
    <div class="container  mt-5">
        <div class="container-fluid ">

            <h3 class="fw-bold text-center text-uppercase pt-3 pb-2">Make A New Claim</h3>
                <table class="table table-bordered" id="dynamicAddRemove">
                    <tr>
                        <th class="text-center" style="width: 1%;">No</th>
                        <th class="text-center col-1" style="width: 2%;">Date</th>
                        <th class="text-center col-1 ">Project</th>
                        <th class="text-center col-3 ">Detail</th>
                        <th class="text-center col-1 ">Amount</th>
                        <th class="text-center  col-1">Receipt</th>
                        <th class="text-center  col-1">Type</th>
                        <th class="text-center col-1" style="width: 1%;">Action</th>
                    </tr>

                    @if (count($claims)>0)
                        @foreach($claims as $claim)
                            <tr>
                                <td class="text-center">0.</td>
                                <td><input type="date" id="indexDate"name="date" placeholder="Enter Date" class="form-control" required/></td>
                                <td><select id="type" name="project" value="{{$claim->project}}" class="form-select"></td>
                                <td><input type="text" name="detail" placeholder="Enter subject" class="form-control" required/></td>
                                <td><input type="number" min="0" name="amount" placeholder="RM" class="form-control" required/></td>
                                <td><input type="file" name="receipt" class="form-control" required/></td>
                                <td><select id="type" name="type" class="form-select" value="{{$claim->type}}" required></td>
                                
                                <td class="text-center"><button type="submit" name="add" id="dynamic-ar" class="btn btn-outline-primary">+</button></td>
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
                                    <option value="{{$project}}">{{$project}}</option>
                                @endforeach
                            </select>
                            </td>
                            <td><input type="text" name="detail" placeholder="Enter subject" class="form-control" required/></td>
                            <td><input type="number" min="0" name="amount" placeholder="RM" class="form-control" required/></td>
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

