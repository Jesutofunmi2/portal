@extends('student.layout.app')
@section('title')
	Student Dashboard
@endsection
@section('head')
	
@endsection
@section('body')

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