@extends('aeo_zeo.layout.app')
@section('title')
	AEO / ZEO Dashboard
@endsection
@section('head')
	
@endsection
@section('body')
<div class="row">
    <div class="">
      <h3>Authorization</h3>
      <hr />
    </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
          <div style="border-radius: 15px;" class="card">
            <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/school-admin-icon.png">
            <div style="background-color: rgb(255, 166, 0); padding: 5px; text-align: center;" class="">
              <h4>Authorization Registration</h4>
            </div>
          </div>
      </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
        <div style="border-radius: 15px;" class="card">
          <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/parent.png">
          <div style="background-color: orange; padding: 5px; text-align: center;" class="">
            <h4>Schools Contacts</h4>
          </div>
        </div>
      </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
        <div style="border-radius: 15px;" class="card">
          <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/school-admin-icon.png">
          <div style="background-color: orange; padding: 5px; text-align: center;" class="">
            <h4>Get OSSI Number</h4>
          </div>
        </div>
      </div>
  
      
  </div>
  <!--/ stats -->
  <!--/ project charts -->
  <div class="row">
    <div class="">
      <h3>Examinations</h3>
      <hr />
    </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
          <div style="border-radius: 15px;" class="card">
            <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/view-result.png">
            <div style="background-color: rgb(255, 166, 0); padding: 5px; text-align: center;" class="">
              <h4>Unity Secondary Schools' Entrance Examination</h4>
            </div>
          </div>
      </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
        <div style="border-radius: 15px;" class="card">
          <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/school-admin-icon.png">
          <div style="background-color: orange; padding: 5px; text-align: center;" class="">
            <h4>Unity Secondary Schools' Entrance Examination</h4>
          </div>
        </div>
      </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
        <div style="border-radius: 15px;" class="card">
          <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/view-result.png">
          <div style="background-color: orange; padding: 5px; text-align: center;" class="">
            <h4>Primary School Certificate Examination in Public Secondary Schools</h4>
          </div>
        </div>
      </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
        <div style="border-radius: 15px;" class="card">
          <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/school-admin-icon.png">
          <div style="background-color: orange; padding: 5px; text-align: center;" class="">
            <h4>Basic Education Certificate Entrance Examination</h4>
          </div>
        </div>
      </div>
      
      
  </div>
  
  <!--/ project charts -->
  <div class="row">
    <div class="">
      <h3>Results</h3>
      <hr />
    </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
          <div style="border-radius: 15px;" class="card">
            <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/result_checker.png">
            <div style="background-color: rgb(255, 166, 0); padding: 5px; text-align: center;" class="">
              <h4>Check Student Result</h4>
            </div>
          </div>
      </div>
      <div   class="col-md-3 col-sm-4 col-xs-12">
        <div style="border-radius: 15px;" class="card">
          <img class="ui fuild image" height="200px" width="100%" src="{{ env('BASE_PATH') }}images/icons/elearn-connect.png">
          <div style="background-color: orange; padding: 5px; text-align: center;" class="">
            <h4>e-Learning</h4>
          </div>
        </div>
      </div>
     
  </div>
  
@endsection