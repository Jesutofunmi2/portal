
<style>
    .student_reciept{
        widows: 100%;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        background-position-x: 647px !important;
    }
    @print{
        .print-none{
            display: none !important;
        }
    }
</style>
<section class="ui raised segment" style="max-width: 1200px; margin: 20px auto;box-shadow: 0px 0px 0px transparent !important;border-style: none !important;">

  @if ($data && count($data))
    @foreach ($data as $student)
      <div class="student_reciept" style="background: url('/eportal/public/images/header-logo.png')">
        <table style="width:100%; padding:5px; border:2px solid; margin-top:5px;">
          @if ($student['status'])
            <tr >
              <td width="20%" style="border:1px;">
                <img src="{{env('BASE_PATH_2').$student['passport']}}" style="border-radius: 4px;">
              </td>
              <td width="80%" style="border:1px;">
                <table width="100%">
                  <tr>
                    <td style="text-align:center; border:1px solid;">
                      Digital Payment Receipt
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <h2>{{ $student['fullname'] }}</h2>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>OSSI Number:</strong> <span>{{$student['regnum']}}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Pin:</strong> <span>{{$student['pin']}}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Serial:</strong> <span>{{$student['serial']}}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Session:</strong> <span>{{$student['session']}}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Status:</strong> <span style="color:green;">Paid</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <strong>Amount:</strong> <span>₦{{$student['amount']}}</span>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <small>Reciept was generated {{$student['created_at']}}</small>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          @else
              <tr>
                <td colspan="2">
                  <h3>{{ $student['message'] }}</h3>
                </td>
              </tr>
          @endif
          
        </table>
      </div>
    @endforeach
    

  @else
    <div class="ui icon negative message">
      <i class="info circle icon"></i>
      <div class="content">
        <div class="header">
        Sorry, No Reciept found.
        </div>
      </div>
    </div>
  @endif
	  
</section>
<style>
.ext{
    width: 100% !important;
}
.ext .card{
    width: 100% !important;
}
.ext .card .item{
    text-align: left;
    padding: 13px;
}
.ext .card .content{
    text-align: right;
    float: right;
}
</style>
<script>
window.onload = function printDiv() 
{
    print();
}
</script>