@extends('admin/layouts/main')

@section('content')
    <section class="content-header">
        <h1>Website Events Statistic</h1>
        <ol class="breadcrumb">
            <li>
                <a href="#"> <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    Statistic
                </a>
            </li>
        </ol>
    </section>
    <section class="content paddingleft_right15">
        <div class="row">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <div class="form-inline">
                        <h4 class="panel-title pull-left" style="padding-right: 20px;padding-top: 5px"><i
                                    class="livicon" data-name="list-ul" data-size="16" data-loop="true" data-c="#fff"
                                    data-hc="white"></i>
                            List Events Statistic
                        </h4>
                        <div class="pull-right"></div>
                    </div>

                </div>
                <br/>
                <div class="panel-body">
                    <table id="example" cellspacing="0" width="100%">
                        <thead>
                        <tr class="hide">
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($filterDataWithNotExistingDayAndCategory as $monthName => $weekDayStatistic)
                            <tr>
                                <td>
                                    <table class="table table-bordered">
                                        <tbody>
                                        @foreach ($weekDayStatistic as $role => $dayStatisticByUser)
                                            @if($loop->first)
                                                <tr class="active">
                                                    <td>{{ $monthName. '/'. $dayStatisticByUser['year'] }}</td>
                                                    @foreach ($dayStatisticByUser as $dayNumber => $value)
                                                        @if($loop->last) @continue @endif
                                                        <td>{{ $dayNumber }}</td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>{{ $role }}</td>
                                                @foreach ($weekDayStatistic[$role] as $userName => $dayStatisticByUser)
                                                    @if($loop->last) @continue @endif
                                                    <td>{{ $dayStatisticByUser }}</td>
                                                @endforeach
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
                    "lengthMenu": "Show _MENU_ months per page",
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