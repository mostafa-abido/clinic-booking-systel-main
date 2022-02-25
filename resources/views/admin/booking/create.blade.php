@extends('admin.layouts.master')
@section('content')
<!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Booking
                                <a href="{{route('admin.booking')}}" class="float-right btn btn-success btn-sm">View All</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            @include('admin.includes.alerts.errors')
                            @include('admin.includes.alerts.success')
                            <div class="table-responsive">
                                <form method="post" enctype="multipart/form-data" action="{{route('admin.booking.store')}}">
                                    @csrf
                                    <table class="table table-bordered" >
                                        <tr>
                                            <th>CheckIn Date <span class="text-danger">*</span></th>
                                            <td><input type="date" name="checkin_date" class="form-control checkin-date" />
                                                @error('checkin_date')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Checkout Date <span class="text-danger">*</span></th>
                                            <td><input type="date" name="checkout_date" class="form-control" />
                                                @error('checkout_date')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th>Total Adults <span class="text-danger">*</span></th>
                                            <td><input name="total_adults" type="number" class="form-control" />
                                                @error('total_adults')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <th> price</th>
                                            <td><input name="price" type="number" class="form-control"/>
                                                @error('total_children')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <input type="hidden" name="roomprice" class="room-price" value="" />
                                                <input type="submit" class="btn btn-primary" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".checkin-date").on('blur',function(){
                var _checkindate=$(this).val();
                // Ajax
                $.ajax({
                    url:"{{url('admin/booking')}}/available-rooms/"+_checkindate,
                    dataType:'json',
                    beforeSend:function(){
                        $(".room-list").html('<option>--- Loading ---</option>');
                    },
                    success:function(res){
                        var _html='';
                        $.each(res.data,function(index,row){
                            _html+='<option data-price="'+row.roomtype.price+'" value="'+row.room.id+'">'+row.room.title+'-'+row.roomtype.title+'</option>';
                        });
                        $(".room-list").html(_html);

                        var _selectedPrice=$(".room-list").find('option:selected').attr('data-price');
                        $(".room-price").val(_selectedPrice);
                        $(".show-room-price").text(_selectedPrice);
                    }
                });
            });

            $(document).on("change",".room-list",function(){
                var _selectedPrice=$(this).find('option:selected').attr('data-price');
                $(".room-price").val(_selectedPrice);
                $(".show-room-price").text(_selectedPrice);
            });

        });
    </script>
@endsection

@endsection
