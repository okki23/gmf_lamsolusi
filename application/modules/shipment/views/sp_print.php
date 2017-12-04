<!DOCTYPE html>
<html lang="en">
  <head>
    <title>SP - <?php echo $sp_no; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo base_url(); ?>assets/base.css" rel="stylesheet" type="text/css" />



    <!-- NOTHING IN THIS FILE SHOULD BE EDITED EXCEPT THESE PATHS TO YOUR THEME STYLESHEETS  -->

    <link href="<?php echo base_url(); ?>assets/styles/bauhaus.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/styles/bauhaus_print.css" media="print" rel="stylesheet" type="text/css" />

    <!-- NOTHING IN THIS FILE SHOULD BE EDITED EXCEPT THESE PATHS TO YOUR THEME STYLESHEETS  -->



  </head>
  <body onload='window.print(); window.close();'>

    <div id="invoice" class="pagestyle">
      <div id="invoice-info">
        <h2>
         NO  <strong><?php echo $sp_no; ?></strong>
        </h2>
        <h3>
          <?php echo $sp_date; ?>
        </h3>
       </div>

       <div class="vcard" id="client-details">
         <div class="fn">
           <?php echo $to; ?>
         </div>
         <div class="org">
           <?php echo $ata; ?>
         </div>
       </div>

       <table id="invoice-amount">
         <thead>
           <tr id="header_row">
             <th>NO</th>
             <th>AWB</th>
             <th>ATA Date</th>
             <td>BC16 Number</th>
             <th>BC16 Date</th>
           </tr>
         </thead>
         <tbody>
		 <?php $no=1; foreach($awb as $row){ ?>
           <tr class="item <?php $style = ($no%2==0)?'odd':''; echo $style;  ?>" >
             <td valign="middle"><?php echo $no; ?></td>
             <td><img src='<?php echo site_url('app/set_barcode/'.$row->awb); ?>' /></td>
             <td valign="middle"><?php echo $row->ata_date ?></td>
             <td valign="middle"><?php echo $row->bc_no ?></td>
             <td valign="middle"><?php echo $row->bc_date ?></td>
           </tr>
		 <?php $no++; } ?>
         </tbody>
       </table>

       <div id="comments">
         This is a valid proof of delivery. prepared by <?php echo str_replace('|',' ',$this->session->userdata('real_name')); ?>
       </div>

     </div>

   </body>
</html>
