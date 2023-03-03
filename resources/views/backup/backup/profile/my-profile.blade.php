@extends('layouts.app')
@section('content')

<div class="container">
    <p class="text-center fs-6 mt-2 fs-1 fw-bold">My Profile<br></p>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card" >
                <h5 class="mb-2 border-bottom fw-bold me-5 ms-2 mt-3">Profile Picture</h5>
                    @if ($staff->picture === $defaultImage)
			    <img src="{{$staff->picture}}"
		    @else
			    <img src='{{asset('storage/upload/profile/'.$staff->picture)}}'
                    @endif

                    class="card-img-top" alt="...">
                <div class="card-body">
                    {!! Form::open(['action' => ['\App\Http\Controllers\ProfileController@update', $staff->staff_id], 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                        <div class="row g-0 mb-2 me-1">
                            <div class="col-10" >
                                <input id="picture" type="file" class="form-control"  name="picture" accept=".pdf, .jpeg, .jpg, .png" required>
                            </div>
                            <div class="col-2">
                                {{Form::hidden('_method','PUT')}}
                                <button type="submit" class="badge bg-primary fw-bold h-100 px-2 ms-1"><i class="fa-solid fa-upload"></i></button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="card mt-2 overflow-auto" style="height: 17em" >
                <h5 class="mb-2 border-bottom fw-bold me-5 ms-2 mt-3">My Certificates <button data-bs-target="#cert{{$staff->staff_id}}" data-bs-toggle="modal" class="badge bg-primary fw-bold mb-1">+</button></h5>
                @if (count($certificates)>0)
                    @php $i = 0 @endphp
                    <div class="mx-4 mb-2">
                        @foreach ($certificates as $cert)
                        <div class="d-flex justify-content-start py-1">
                            <div class="col-1 me-1">{{++$i}}.</div>
                            <div class="col-9 me-2">{{$cert->name}}</div>
                            <div class="col-1 mx-1">
                                <a href="{{ route('certificate.destroy', ['id' => $cert->id]) }}"><i class="fa-solid fa-circle-xmark text-danger"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <span class="me-5 ms-4 my-3">No certificates added.</span>
                @endif
            </div>

            {{-- Certificate Modal --}}
            <div class="modal fade" id="cert{{$staff->staff_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Add New Certificate</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {!!Form::open(['action' => ['\App\Http\Controllers\CertificateController@store'], 'method' => 'POST', 'enctype' => 'multipart/form-data'])!!}
                        <div class="row g-2">
                            <div class="col-md-12">
                                <label for="resign_remark" class="form-label">Course Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter course name" required>
                            </div> 
                            <div class="col-md-4">
                                <label for="date" class="form-label">Course Date:</label>
                                <input type="date" class="form-control" name="date" required>
                            </div>
                            <div class="col-md-8">
                                <label for="file" class="form-label">Certificate Image</label>
                                <input type="file" class="form-control" name="file" required>
                            </div>
                            <input type="hidden" class="form-control" value="{{$staff->staff_id}}" name="staff_id">
                        </div>
                        
                        
                    </div>
                    <div class="modal-footer">
                        {{Form::submit('Add Certificate', ['class'=>'btn btn-primary fw-bold'])}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                    </div>
                    {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-body scroll">
                    <h5 class="mb-2 border-bottom fw-bold ">My Profile</h5>
                    <div class="row g-2">
                        <div class="form-group col-md-4" >
                            {{Form::label('name', 'Full Name')}}
                            {{Form::text('name', $staff->name, ['class' => 'form-control','placeholder' => 'Enter staff full name...', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-3" >
                            {{Form::label('nric', 'NRIC (without "-")')}}
                            {{Form::text('nric', $staff->nric, ['class' => 'form-control', 'placeholder' => 'Enter staff NRIC number...', 'maxlength' => '12', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-5" >
                            {{Form::label('email', 'Email')}}
                            {{Form::text('email', $staff->email, ['class' => 'form-control', 'placeholder' => 'Enter staff primary email...', 'disabled'])}}
                        </div>
                    </div>
                    <div class="row g-2 mt-0">
                        <div class="form-group col-md-2" >
                            {{Form::label('marry', 'Marital Status')}}
                            {{Form::select('marry', ['1' => 'Single', '2' => 'Married', '3' => 'Divorced'], $staff->marrital_status, 
                            ['class'=> 'form-select', 'id' => 'inputGroupSelect01', 'disabled']);}}
                        </div>
                        <div class="form-group col-md-2" >
                            {{Form::label('child', 'Children')}}
                            {{Form::select('child', ['0'=> '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => 'More than 10'], $staff->child, 
                            ['class'=> 'form-select', 'id' => 'inputGroupSelect01', 'disabled']);}}
                        </div>
                        <div class="form-group col-md-2" >
                            {{Form::label('phone', 'Phone Number')}}
                            {{Form::text('phone', $staff->phone, ['class' => 'form-control', 'placeholder' => 'Enter staff phone number...', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-3" >
                            {{Form::label('status', 'Start Date')}}
                            {{Form::date('startdate', $staff->start_date, ['class'=> 'form-control', 'disabled']);}}
                        </div>
                        <div class="form-group col-md-3" >
                            {{Form::label('status', 'Employment Status')}}
                            {{Form::select('status', ['0'=> 'On Probation', '1' => 'Permanent', '2' => 'Resigned'], $staff->status, ['class'=> 'form-select', 'id' => 'inputGroupSelect01', 'disabled']);}}
                        </div>
                        
                    </div>
                    <div class="row g-2 mt-0">
                        <div class="form-group col-md-3" >
                            {{Form::label('designation', 'Designation')}}
                            {{Form::text('designation', $staff->designation, ['class' => 'form-control', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-3" >
                            {{Form::label('role', 'Role')}}
                            {{Form::select('role', ['3'=> 'Regular Staff', '2' => 'Supervisor', '1' => 'System Admin'], $staff->role, ['class'=> 'form-select', 'id' => 'inputGroupSelect01', 'disabled']);}}
                        </div>
                        <div class="form-group col-md-4" >
                            {{Form::label('supervisor', 'Supervisor')}}
                            {{Form::text('supervisor', $staff->supervisor, ['class' => 'form-control', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-2" >
                            {{Form::label('epf', 'EPF Number')}}
                            {{Form::text('epf', $staff->epf, ['class' => 'form-control', 'disabled'])}}
                        </div>
                        
                    </div>
                    <div class="row g-2 mt-0 mb-3">
                        <div class="form-group col-md-12" >
                            {{Form::label('address', 'Address')}}
                            {{Form::text('address', $staff->address, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                    <h5 class="mt-4 mb-0 border-bottom fw-bold">Banking Details</h5>
                    <div class="row g-2 mt-0 mb-3">
                        <div class="form-group col-md-5" >
                            {{Form::label('bank', 'Bank Name')}}
                            {{Form::select('bank', [
                                ''=> "",
                                'CIMB Bank Berhad'=>'CIMB Bank Berhad',
                                'Affin Bank Berhad'=>'Affin Bank Berhad',
                                'Al-Rajhi Banking & Investment Corp'=>'Al-Rajhi Banking & Investment Corp',
                                'Alliance Bank Malaysia Berhad'=>'Alliance Bank Malaysia Berhad',
                                'AmBank Berhad'=>'AmBank Berhad',
                                'Bank Islam Malaysia'=>'Bank Islam Malaysia',
                                'Bank Kerjasama Rakyat Malaysia Berhad'=>'Bank Kerjasama Rakyat Malaysia Berhad',
                                'Bank Muamalat'=>'Bank Muamalat',
                                'Bank of America'=>'Bank of America',
                                'Bank of China (Malaysia) Berhad'=>'Bank of China (Malaysia) Berhad',
                                'Bank Pertanian Malaysia Berhad (Agrobank)'=>'Bank Pertanian Malaysia Berhad (Agrobank)',
                                'Bank Simpanan Nasional Berhad'=>'Bank Simpanan Nasional Berhad',
                                'BNP Paribas Malaysia'=>'BNP Paribas Malaysia',
                                'Bangkok Bank Berhad'=>'Bangkok Bank Berhad',
                                'BigPay Malaysia Sdn Bhd'=>'BigPay Malaysia Sdn Bhd',
                                'China Const BK (M) BHD'=>'China Const BK (M) BHD',
                                'Citibank Berhad'=>'Citibank Berhad',
                                'Deustsche Bank (Msia) Berhad'=>'Deustsche Bank (Msia) Berhad',
                                'Finexus Cards Sdn. Bhd.'=>'Finexus Cards Sdn. Bhd.',
                                'Hong Leong Bank'=>'Hong Leong Bank',
                                'HSBC Bank Malaysia Berhad'=>'HSBC Bank Malaysia Berhad',
                                'Industrial & Commercial Bank of China'=>'Industrial & Commercial Bank of China',
                                'J.P Morgan Chase Bank Berhad'=>'J.P Morgan Chase Bank Berhad',
                                'Kuwait Finance House (Malaysia) Bhd'=>'Kuwait Finance House (Malaysia) Bhd',
                                'Maybank/Maybank Islamic'=>'Maybank/Maybank Islamic',
                                'MBSB Bank'=>'MBSB Bank',
                                'Mizuho Bank (Malaysia) Berhad'=>'Mizuho Bank (Malaysia) Berhad',
                                'MUFG Bank (Malaysia) BHD'=>'MUFG Bank (Malaysia) BHD',
                                'OCBC Bank (Malaysia) BHD'=>'OCBC Bank (Malaysia) BHD',
                                'Public Bank'=>'Public Bank',
                                'RHB Bank'=>'RHB Bank',
                                'Standard Chartered Bank'=>'Standard Chartered Bank',
                                'Sumitomo Mitsui Banking Coporation'=>'Sumitomo Mitsui Banking Coporation',
                                'Touch N GO eWallet'=>'Touch N GO eWallet',
                                'United Overseas Bank Berhad'=>'United Overseas Bank Berhad',
                            ], $staff->bank_name, 
                            ['class'=> 'form-select', 'id' => 'inputGroupSelect01', 'disabled']);}}
                        </div>
                        <div class="form-group col-md-4" >
                            {{Form::label('bank_acc', 'Bank Account Number')}}
                            {{Form::text('bank_acc', $staff->bank_acc, ['class' => 'form-control', 'disabled'])}}
                        </div> 
                        <div class="form-group col-md-3" >
                            {{Form::label('tax', 'Income Tax (If any)')}}
                            <a href="#" data-toggle="tooltip" title="Income tax in Malaysia is a progressive tax, which means that the amount of tax paid increases as income increases."><i class="fa-solid fa-circle-info"></i></a> 
                            {{Form::text('tax', $staff->income_tax, ['class' => 'form-control', 'disabled'])}}
                        </div>                        
                    </div>
                    <h5 class="mt-4 mb-0 border-bottom fw-bold">Qualification Details</h5>
                    <div class="row g-2 mt-0 mb-3">
                        <div class="form-group col-md-6" >
                            {{Form::label('qualification', 'Highest Qualification')}}
                            <a href="#" data-toggle="tooltip" title="Your highest quaification, e.g. Diploma in Networking Security"><i class="fa-solid fa-circle-info"></i></a>
                            {{Form::text('qualification', $staff->qualification, ['class' => 'form-control', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-4" >
                            {{Form::label('university', 'University')}}
                            {{Form::text('university', $staff->university, ['class' => 'form-control', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-2" >
                            {{Form::label('year', 'Grad Year')}}
                            {{Form::text('year', $staff->year, ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                    <h5 class="mt-4 mb-0 border-bottom fw-bold">Leave Entitlement</h5>
                    <div class="row g-2 mt-0 mb-3">

                        <div class="form-group col-md-6" >
                            {{Form::label('al', 'Annual Leave')}}
                            {{Form::text('al', $staff->ent_al.' days', ['class' => 'form-control', 'min' => '0', 'disabled'])}}
                        </div>
                        <div class="form-group col-md-6" >
                            {{Form::label('ml', 'Medical Leave')}}
                            {{Form::text('ml', $staff->ent_ml.' days', ['class' => 'form-control', 'disabled'])}}
                        </div>
                    </div>
                    <input type="hidden" name="staff_id" value="{{$staff->staff_id}}">
                        <div class="d-grid gap-2 col-md-12 mx-auto">
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dropup-center dropup">
  
        <a class="btn btn-outline-dark floating-btn rounded-pill px-4 me-4 shadow-lg" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="fw-bold"><i class="fa-solid fa-bars"></i></span>
        </a>
      
        <ul class="dropdown-menu dropdown-menu-dark"> 
            {{-- href="/generate-cv/{{$staff->staff_id}}" --}}
          <li><button class="dropdown-item text-white" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-file-pdf"></i>&nbsp; Generate CV</button></li>
          <li><a class="dropdown-item text-white" href="/change-password"><i class="fa-solid fa-lock"></i>&nbsp; Change Password</a></li>
          
        </ul>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Describe your skills summary</b></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form target="_blank" action="{{route('generate-cv', $staff->staff_id)}}" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="skill_summary" class="form-label">Skills Summary</label>
                            <textarea class="form-control" name="skill_summary" maxlength="400" placeholder="Describe your skills summary" rows="7" required></textarea>
                        </div>       
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary fw-bold"><b>Generate My CV</b></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><b>Close</b></button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
</div>

<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
    </script>


@endsection
