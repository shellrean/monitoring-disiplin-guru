<div class="row">
  <div class="col-lg-12"> 
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Data guru
      </div>
      <div class="card-body">
        <div class="table-responsive-sm">
        <table class="table table-bordered table-striped table-sm" id="appTable" style="min-width: 520px">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Sekolah</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        </div>
      </div>
      <div class="card-footer">
        
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    let table = $('#appTable').DataTable( {
      "ajax"  : '<?= base_url('panel/data_guru'); ?>',
      "order" : [[2, 'asc' ]],
      "columns": [
        {
          "data"    : null,
          "width"   : "50px",
          "sClass"  : "text-center",
          "orderable": false
        },
        { "data"    : "sekolah" },
        { "data"    : "aksi",
          "orderable": false,
        },
      ]
    });

    table.on( 'order.dt search.dt', function() {
       table.column(0, { search : 'applied', order:'applied'}).nodes().
        each( function(cell, i) {
          cell.innerHTML = i+1;
        });
    }).draw();   
  })
</script>