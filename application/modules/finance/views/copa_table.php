<?php $timestamp = time();?>
<div id="info-copa-table-<?php echo $timestamp; ?>"></div>

<script>
$(document).ready(function(){





  var ds_copa_lock = new kendo.data.DataSource({
    transport: {
      read:  {
        type:"POST",
        dataType: "json",
        url: '<?php echo site_url('finance/get_copa'); ?>',
        data: <?php echo json_encode($filter); ?>
      },
    },
    pageSize: 100,
    schema: {
      parse: function(response){
        return response.data;
      },
      model: {
        fields: {
          request_id: { editable: false },
          request_type: { editable: false },
          request_date: { editable: false },
          curency: { editable: false },
          total_cost: { editable: false },
          copa: { type: "number", editable: true }
        }
      }
    }
  });

  $('#info-copa-table-<?php echo $timestamp; ?>').kendoGrid({
    dataSource: ds_copa_lock,
    filterable: true,
    sortable: true,
    pageable: true,
    scrollable: true,
    filterable: false,
    rowTemplate: kendo.template($("#copaGrid-<?php echo $timestamp; ?>").html()),
    dataBound: function(e) {
      this.collapseRow(this.tbody.find("tr.k-master-row").first());
      var grid = e.sender;
      if (grid.dataSource.total() == 0) {
        var colCount = grid.columns.length;
        $(e.sender.wrapper)
          .find('tbody')
          .append('<tr class="kendo-data-row"><td colspan="' + colCount + '" class="no-data" style="text-align:center">&mdash;&mdash; Data Kosong &mdash;&mdash;</td></tr>');
      }
    },
    columns: [
      {
				filterable: false,
				title:"<input id='myCheckbox' type='checkbox' onClick='toggle(this)' /> All<br/>",
				width: 50,
			},
      {field:'request_id',title:"Request ID", width:50,filterable: false},
      {field:'request_type',title:"Request Type", width:150,filterable: false},
      {field:'request_date',title:"Request Date", width:50,filterable: false},
      {field:'curency',title:"Curency", width:80,filterable: false},
      {field:'total_cost',title:"Selling Price", width:80,filterable: false},
      {field:'copa',title:"COPA", width:100,filterable: false},
      {field:'copa',title:"COPA Status", width:100,filterable: false},
    ]
  });


});

function toggle(source) {
  checkboxes = document.getElementsByClassName('requestId');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script id="copaGrid-<?php echo $timestamp; ?>" type="text/x-kendo-tmpl">
<tr>
  <td style=" padding: 5px; text-align:center;">
    <input type="checkbox" class='requestId' name="requestId[]" value="#: request_id #">
  </td>
  <td style=" padding: 5px;">#: request_id #</td>
  <td style=" padding: 5px;">#: request_type #</td>
  <td style=" padding: 5px;">#: request_date #</td>
  <td style=" padding: 5px;">#: curency #</td>
  <td style=" padding: 5px;">#: total_cost #</td>
  <td style=" padding: 5px;">#: copa #</td>
  <td style=" padding: 5px;">
    # if(copa_lock=='no'){ #
      <span class='label label-success'>Un Lock</span>
    # }else{ #
      <span class='label label-danger'>Lock</span>
    #}#
  </td>
<tr>
</script>
