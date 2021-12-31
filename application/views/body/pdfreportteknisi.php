<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Surat Kesepakatan</title>
  <link rel="stylesheet" href="<?php echo base_url(). "assets/";?>css/bootstrap.min.css">
</head>

<body>
<div class="row" align="center">

	<h1>REPORT TIKET TEKNISI </h1>


	<table class="table table-striped" id="tableorder" align="center" border="1" cellpadding="10" cellspacing="0" width="100%">


		 <tr>
  	<th>NO</th>
  	<th>TANGGAL PROSES</th>
  	<th>Customer</th>
    <th width="30px">TIKET</th>
  	<th>PROGRESS</th>
  </tr>

  <?php $no = 0; foreach($datareportteknisi as $row) : $no++;?>
   <tr>
   	<td><?php echo $no;?></td>
  	<td><?php echo $row->tanggal_proses;?></td>
  	<td>BP BATAM</td>
  	<td width="20px">Server Land 3 Down</td>
    <td>
  
  
    <span><?php echo $row->progress;?> % Complete (Progress)</span>
  
  
    </td>
  </tr>
<?php endforeach;?>
</table>

</div>
</body>
</html>