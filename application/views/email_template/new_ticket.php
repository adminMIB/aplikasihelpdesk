<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding:2px;
}
</style>
<body>

	<p>Kamu memiliki ticket baru yang belum dibaca dengan id <b><?php echo $id_ticket; ?></b></p>
	<table style="width:100%">
		<tr>
			<td style="font-weight: bold">Nama Customer</td>
			<td style="font-weight: bold">Ringkasan masalah</td>
			<td style="font-weight: bold"> Deskripsi</td>
			<td style="font-weight: bold"> Foto</td>
			<td style="font-weight: bold">Tanggal ticket</td>
		</tr>
	<tr>
			<td ><?php echo $customer_name; ?></td>
			<td ><?php echo $problem_summary; ?></td>
			<td ><?php echo $problem_detail; ?></td>
			<td >
				<?php if(!empty($user_file)){ ?>
					<img src="<?php echo base_url('assets/images/'.$user_file) ?>" style="width:100px">
				<?php } ?>
			</td>
			<td ><?php echo $tanggal; ?></td>
		</tr>
	</table>
	<br><br>
	<p><i>Silahkan mengunjungi dashboard untuk melihat ticket lebih detail</i></p>
</body>
</html>