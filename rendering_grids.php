<?php
session_start();
$cfile_name = "rendering_grids";
include_once "header_login.php";
if (empty($_SESSION['EMPLOYEE_EMAIL'])) {
   header('location:index.php');
}
include_once "functions/inventory_functions.php";
include_once "functions/vendors_functions.php";
?>
<head>
   <title>Data Grid </title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/bootstrap-chosen.css" />
   <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
   <link rel="stylesheet" type="text/css" href="assets/datatables/jquery.dataTables.min.css" />
   <link rel="stylesheet" type="text/css" href="assets/datatables/responsive.bootstrap.min.css" />
   <style>
      .bg-light {
         border-radius: 5px;
         background-color: #f2f2f2;
         padding: 20px;
      }

      .dataTables_wrapper {
         margin-top: 15px;
      }

      .dt-buttons {
         display: inline-block;
         padding-bottom: 8px;
      }

      .dataTables_wrapper .dataTables_filter input {
         -webkit-appearance: none;
         border: 1px solid #CCC;
         height: 28px;
      }

      #loading,
      #loading2 {
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         position: fixed;
         display: block;
         opacity: 0.5;
         background-color: #586674;
         z-index: 99;
         text-align: center;
      }

      #loading-image {
         position: absolute;
         top: 40%;
         left: 50%;
         z-index: 100;
      }

      thead {
         background: #00948b;
         color: white;
      }
   </style>
   <script src="js/chosen.jquery.js"></script>
   <script type="text/javascript" src="assets/datatables/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="assets/datatables/dataTables.bootstrap.min.js"></script>
   <script type="text/javascript" src="assets/datatables/dataTables.responsive.min.js"></script>
   <script type="text/javascript" src="assets/datatables/jquery.dataTables.min.js"></script>
   <script type="text/javascript" src="assets/datatables/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="assets/datatables/buttons.flash.min.js"></script>
   <script type="text/javascript" src="assets/datatables/jszip.min.js"></script>
   <script type="text/javascript" src="assets/datatables/pdfmake.min.js"></script>
   <script type="text/javascript" src="assets/datatables/vfs_fonts.js"></script>
   <script type="text/javascript" src="assets/datatables/buttons.html5.min.js"></script>
   <script type="text/javascript">
   var datatable;
   $(document).ready(function () {
    var tableId = new URLSearchParams(window.location.search).get('table');
    
    $('#updateBtn').on('click', function() {
        var tableId = new URLSearchParams(window.location.search).get('table');
        if (tableId!=null) {
            loadTableHeadersAndData(tableId);
        }});

    $('#table').val(tableId).trigger('chosen:updated');
    if(tableId!=null){
        loadTableHeadersAndData(tableId);
    }
   

      
      $(".chosen-select").chosen();

     
      function handleTableChange() {
         var value = $('#table').val();
         if (value) {
            location.href = `rendering_grids.php?table=${value}`;
         }
      }

      function loadTableHeadersAndData(tableId) {
         $.ajax({
            url: 'inventory_ajaxload.php?type=TablesData&table_id=' + tableId,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
               console.log(response);
               if (response.error) {
                  console.error(response.error);
                  return;
               }

              
               if ($.fn.DataTable.isDataTable('#datatable-responsive')) {
                   $('#datatable-responsive thead tr').empty();
                  datatable.clear().draw(); 
               } else {
                  
                  datatable = $('#datatable-responsive').DataTable({
                     responsive: false,
                     fixedHeader: true,
                     scrollY: 600,  
                     scrollX: true,  
                     deferRender: true,
                     searchable: false,
                     orderable: true,
                     ordering: true,
                     order: [[0, 'desc']],
                     pageLength: 500,
                     dom: 'frtip', 
                     columns: response.columns.map(function (col) {
                        return { title: col, data: col }; 
                     })
                  });

                  
                  response.columns.forEach(function (col) {
                     $('#datatable-responsive thead tr').append('<th>' + col + '</th>');
                  });
               }

              
               datatable.rows.add(response.data); 
               datatable.columns.adjust(); 
               datatable.draw(); 
            },
            error: function (xhr, status, error) {
               console.error('Error loading table data:', error);
            },
         });
      }

      
      $("#table").change(function () {
         handleTableChange();
      });
   });
</script>
</head>
<div class="content">
   <h2 class="heading">Select the Table</h2>
   <div class="row">
      <div class="col-md-1"><b>Table :</b></div>
      <div class="col-md-3">
      <select class="chosen-select form-control" id="table" onchange="handleTableChange(this.value);">
    <option value="nbs_receipt_header">nbs_receipt_header</option>
    <option value="nbs_receipt_detail">nbs_receipt_detail</option>
    <option value="nbs_rendering">nbs_rendering</option>
    <option value="nbs_rendering_order_price">nbs_rendering_order_price</option>
</select>
      </div>
      <button class=" button" id="updateBtn">Update</button>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div id="loading" style="display:none;">
            <img id="loading-image" src="images/ajax-loader.gif" alt="Loading...">
         </div>
         <table class="table table-bordered table-striped dataTable" id="datatable-responsive">
         <thead>
      <tr></tr>
   </thead>
   <tbody></tbody>
         </table>
      </div>
   </div>
</div>
<?php
include_once "footer.php";
?>