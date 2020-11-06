@extends('admin.layouts.admin_master')

@section('title')
Pending Forms
@endsection

@section('content')

<div class="card container-fluid">
    <div class="card-body">
        <h3 class="title-5 m-b-35">Pending Forms</h3>

        <div class="table-responsive">

            <table id="datatable" class="table  table-striped table-data2">
                <thead>
                    <tr>

                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Staff ID</th>
                        <th>Department</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending_view as $item)

                    <tr>
                        {{--to get the closet value or ID to the delete button--}}
                        <input type="hidden" class="delete_abc" value="{{ $item->id }}">
                        <td>{{ $item->name }}</td>
                        <td>
                            <span class="block-email">{{ $item->email }}</span>
                        </td>
                        <td class="desc">{{ $item->StaffID }}</td>
                        <td>{{ $item->department }}</td>
                        <td>{{ $item->updated_at }}</td>

                        @if($item->status =='approved')
                        <td><span class="status--process">{{ $item->status }}</span></td>
                        @else
                        <td><span class="status--denied">pending</span></td>
                        @endif

                        <td>
                            <div class="table-data-feature">
                                <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                    <i class="zmdi zmdi-mail-send"></i>
                                </button>
                                <a href="{{url('pending_edit/'.$item->id)}}"><button class="item" data-toggle="tooltip"
                                        data-placement="top" title="Edit">
                                        <i class="zmdi zmdi-edit"></i>
                                    </button></a>
                                <button class="item a_pending_delete" data-toggle="tooltip" data-placement="top"
                                    title="Delete">
                                    <i class="zmdi zmdi-delete"></i>
                                </button>
                                <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                    <i class="zmdi zmdi-more"></i>
                                </button>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    /*confirm and delete with id or value closest to the button*/

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.a_pending_delete').click(function (e) {
        e.preventDefault();

        /*to get the closet value or ID to the delete button*/
        /*if you want to get the text type  .text()*/
        var delete_xyz = $(this).closest("tr").find('.delete_abc').val();

        swal({
            title: "Are you sure?",
            text: "Once canceled, you will not be able to recover this appointment!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {

                    var data = {
                        "_token": $('input[name=_token]').val(),
                        "id": delete_xyz,
                    }

                    $.ajax({
                        type: "DELETE",
                        url: '/a_pending_delete/'+delete_xyz,
                        data: data,
                        success: function (response) {

                            swal(response.status, {
                                icon: "success",
                            })

                                .then((result) => {
                                    location.reload();
                                });
                        }
                    });


                } else {
                    swal("Your appointment is safe!");
                }
            });

    });



    });
</script>

@endsection