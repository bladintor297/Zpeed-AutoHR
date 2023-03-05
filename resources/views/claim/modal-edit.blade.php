    {{-- Update Modal for Claim --}}
    <div class="modal fade" id="updateClaim{{$claim->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Update Claim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action = "{{route('claim.update', $claim->id)}}" method="GET" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="ref" class="form-label">Staff:</label>
                        <input type="text" class="form-control" name="staff" value="{{$staff->name}}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="ref" class="form-label">Claim Ref:</label>
                        <input type="text" class="form-control" name="ref" value="{{$claim->ref_id}}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date:</label>
                        <input type="date" class="form-control" name="date" value="{{$claim->date}}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="project" class="form-label">Project:</label>
                        <select type="text" class="form-select" name="project" value="{{$claim->project}}" required>
                            @if (is_null($claim->project))
                                <option value="" selected>No Project</option>
                            @else
                                <option value="">NO PROJECT</option>
                            @endif

                            @foreach ($projectx as $project)
                                @if ($project->code === $claim->project)
                                  <option value="{{$project->code}}" selected>{{$project->name}}</option>

                                @else
                                    <option value="{{$project->code}}">{{$project->name}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="date" class="form-label">Detail:</label>
                        <input type="text" class="form-control" name="detail" value="{{$claim->detail}}">
                    </div>
                    <input type="hidden" class="form-control" value="c" name="type">
                </div>
                
                
            </div>
            <div class="modal-footer">
                {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
            </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Reject Modal for Claim --}}
    <div class="modal fade" id="rejectClaim{{$claim->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Reject Claim</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action = "{{route('claim.rejectOne', $claim->id)}}" method="GET" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="ref" class="form-label">Staff:</label>
                        <input type="text" class="form-control" name="staff" value="{{$staff->name}}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="ref" class="form-label">Claim Ref:</label>
                        <input type="text" class="form-control" name="ref" value="{{$claim->ref_id}}" disabled>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered">
                              <tr>
                                <th scope="col">Date</th>
                                <td scope="col">{{$claim->date}}</td>
                              </tr>
                              <tr>
                                <th scope="col">Detail</th>
                                <td scope="col">{{$claim->detail}}</td>
                              </tr>
                              <tr>
                                <th>Trip</th>
                                <td scope="col">
                                    <div class="d-grid text-center" style="font-size: 0.7rem">
                                        <span>{{$claim->origin}}</span> 
                                        <span class="text-primary"><i class="fa-solid fa-circle-arrow-down mx-2"></i></span> 
                                        <span>{{$claim->destination}} </span>
                                    </div>
                                </td>
                              </tr>
                              <tr>
                                <th>Project</th>
                                <td scope="col">
                                    @foreach ($projectx as $project)
                                        @if ($project->code === $claim->project)
                                            {{$project->name}}
                                        @endif
                                    @endforeach
                                </td>
                              </tr>
                          </table>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label for="ref" class="form-label">Reject this claim?</label>
                        <input type="text" class="form-control" name="reject_reason" placeholder="Specify your reject reason" required>
                    </div>
                    <input type="hidden" class="form-control" value="c" name="type">
                </div>
                
                
            </div>
            <div class="modal-footer">
                {{Form::submit('Confirm', ['class'=>'btn btn-danger fw-bold'])}}
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
            </div>
                </form>
            </div>
        </div>
    </div>