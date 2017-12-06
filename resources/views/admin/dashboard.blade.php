@extends('admin/layouts/main')

@section('content')
   <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>Dashboard</a>
            </li>
        </ol>
    </section>
      <section class="content paddingleft_right15">
         <div class="row">
             <div class="panel panel-primary ">
                 <div class="panel-heading clearfix">
                     <div class="form-inline">
                         <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"> <i class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                             Writers' efficiency
                         </h4>
                         <div class="pull-right">
                             <label class="hide" for="lang-select">Period</label>
                             <select class="form-control hide" id="lang-select" style="min-width: 150px">
                                 <option value="">week</option>
                                 <option value=""></option>
                             </select>
                         </div>
                     </div>

                 </div>
                 <br />
                 <div class="panel-body">
                     <table id="example" cellspacing="0" width="100%">
                         <thead>
                         <tr class="hide">
                             <th>Name</th>
                         </tr>
                         </thead>
                         <tbody>
                         @foreach ($groupedStatisticByPeriod as $weekDatePeriod => $weekDayStatistic)
                             <tr>
                                 <td>
                                     <table class="table table-bordered">
                                         <caption>{{ $weekDatePeriod }}</caption>
                                         <thead>
                                         <tr>
                                             <th></th>
                                             <th>Mon</th>
                                             <th>Tue</th>
                                             <th>Wed</th>
                                             <th>Thu</th>
                                             <th>Fri</th>
                                             <th>Sat</th>
                                             <th>Sun</th>
                                             <th>Total</th>
                                         </tr>
                                         </thead>
                                         <tbody>
                                         @foreach ($weekDayStatistic as $userName => $dayStatisticByUser)
                                             <tr class="data-by-period">
                                                 <th>{{ $userName }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::MONDAY]) ? $dayStatisticByUser[\Carbon\Carbon::MONDAY] : 0 }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::TUESDAY]) ? $dayStatisticByUser[\Carbon\Carbon::TUESDAY] : 0 }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::WEDNESDAY]) ? $dayStatisticByUser[\Carbon\Carbon::WEDNESDAY] : 0 }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::THURSDAY]) ? $dayStatisticByUser[\Carbon\Carbon::THURSDAY] : 0 }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::FRIDAY]) ? $dayStatisticByUser[\Carbon\Carbon::FRIDAY] : 0 }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::SATURDAY]) ? $dayStatisticByUser[\Carbon\Carbon::SATURDAY] : 0 }}</th>
                                                 <th>{{ isset($dayStatisticByUser[\Carbon\Carbon::SUNDAY]) ? $dayStatisticByUser[\Carbon\Carbon::SUNDAY] : 0 }}</th>
                                                 <th>{{ $dayStatisticByUser['total_item'] ?? 0 }}  </th>
                                             </tr>
                                         @endforeach
                                         </tbody>
                                     </table>
                                 </td>
                             </tr>
                         @endforeach
                         </tbody>
                     </table>

                 </div>
             </div>
         </div>    <!-- row-->
     </section>


@endsection
@section('footer_scripts')
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "searching": false,
                "iDisplayLength": 4,
                "lengthMenu": [1, 2, 3, 4],
                "aaSorting": [[0, "natural-asc"]],
                "info": false,
                "language": {
                    "lengthMenu": "Show _MENU_ weeks per page",
                    "zeroRecords": "Nothing found - sorry",
                    "info": "Showing pages _PAGE_ of _PAGES_",
                    "infoEmpty": "No weeks available",
                }
            });
        });
    </script>
    <script src="{{asset('js/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.js')}}"></script>
@stop