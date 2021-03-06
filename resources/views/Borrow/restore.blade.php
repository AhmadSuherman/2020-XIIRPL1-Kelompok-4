<title>Inventory | Daftar Pengembalian</title>
@extends('layouts.master')

@section('content')

<body>
  <div class="row">
    <div class="col-md-12">
      <h4>Daftar Pengembalian Barang</h4>
      <div class="box box-warning">
        <div class="box-header">
          <p>
            <button class="btn btn-sm btn-flat btn-warning btn-refresh"><i class="fa fa-refresh"></i> Refresh</button>
            <!--  <a target="_blank" href="{{ url('Borrows/pdf/') }}" class="btn btn-sm btn-flat btn-success"><i class="fa fa-download"></i> Export PDF</a> -->
            <a href="{{ url('/print') }}" target="_blank" class="btn btn-sm btn-flat btn-default"><i class="fa fa-print"></i> Print</a>
          </p>
        </div>
        <div class="box-body">
          <form action="{{ url('all-delete') }}" method="POST">
            {!! csrf_field() !!}
            <p><button type="submit" class="btn btn-danger" id="bulk-delete" style="display:none">Delete</button></p>
            <div class="table-responsive">
              <table class="table myTable">
                <thead>
                  <tr>
                    <th>NO</th>
                    <td><input type="checkbox" id="selectall" class="checked" /></td>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Pinjam</th>
                    <th>Status</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Perizinan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($histories as $e=>$history)
                  @if($history->status != 1 AND $history->status != 0)

                  <tr>
                    <td>{{$e+1}}</td>
                    <td><input type="checkbox" onClick="checkbox_is_checked()" name="id[]" value="{{$history->id}}" class="check-all"></td>
                    <td>{{$history->username}}</td>
                    <td>{{$history->class}}</td>
                    <td>{{$history->item_name}}</td>
                    <td>{{$history->total_borrow}}</td>

                    @if($history->status == 0)
                    <td><label class="label label-warning">Menunggu Verifikasi</label></td>
                    @endif

                    @if($history->status == 1)
                    <td><label class="label label-success">Sedang Di Pinjam</label></td>
                    @endif

                    @if($history->status == 3)
                    <td><label class="label label-danger">Barang Hilang</label></td>
                    @endif

                    @if($history->status == 2)
                    <td><label class="label label-primary">Sudah Di Kembalikan</label></td>
                    @endif

                    @if($history->date_borrow == NULL)
                    <td> - </td>
                    @else
                    <td>{{ date('d M Y H:i:s', strtotime($history->date_borrow )) }}</td>
                    @endif

                    @if($history->date_return == NULL)
                    <td> - </td>
                    @else
                    <td>{{ date('d M Y H:i:s', strtotime($history->date_return )) }}</td>
                    @endif
                    <td>{{$history->licensor}}</td>


                  </tr>
                  @endif
                  @endforeach
                </tbody>

              </table>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>

</body>
@endsection

@section('scripts')

<script type="text/javascript">
  $(document).ready(function() {

    // btn refresh
    $('.btn-refresh').click(function(e) {
      e.preventDefault();
      $('.preloader').fadeIn();
      location.reload();
    })

  })

  $(function() {
    $("#selectall").click(function() {
      if ($("#selectall").is(':checked')) {
        $("input[type=checkbox]").each(function() {
          $(this).attr("checked", true);
        });
        $("#bulk-delete").show();

      } else {
        $("input[type=checkbox]").each(function() {
          $(this).attr("checked", false);
        });
        $("#bulk-delete").hide();
      }
    });
  });

  function checkbox_is_checked() {

    if ($(".check-all:checked").length > 0) {
      $("#bulk-delete").show();
    } else {
      $("#bulk-delete").hide();
    }
  }
</script>

@endsection