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
	<h4><b>Kepada <?php echo $email; ?> ,Notifikasi ticket <?php echo $level; ?></b></h4>
	<p>Kamu memiliki ticket baru yang belum dibaca dengan id <b><?php echo $id_ticket; ?></b></p>
	<br>
	<p>Berikut adalah seluruh ticket yang belum dibaca :</p>
	<table style="width:100%">
		<tr>
			<td >No</td>
			<td >ID ticket</td>
			<td> Urgensi</td>
			<td> Foto</td>
			<td >Tanggal ticket</td>
			<td> Nama Project Client</td>
			<td> Sub masalah</td>
			<td >Summary</td>
		</tr>
		<?php $num=1; foreach($list_email_unread as $q){ ?>
			<tr>
				<td ><?php echo $num; ?></td>
				<td ><?php echo $q->id_ticket; ?></td>
				<td ><?php echo $q->jenis_urgensi; ?></td>
				<td >
					<?php if(!empty($q->user_file)){ ?>
						<img src="<?php echo base_url('assets/images/'.$q->user_file) ?>" style="width:100px">
					<?php } ?>
				</td>
				<td ><?php echo $q->tanggal; ?></td>
				<td ><?php echo $q->nama_kategori; ?></td>
				<td ><?php echo $q->nama_sub_kategori; ?></td>
				<td ><?php echo $q->problem_summary; ?></td>
			</tr>

		<?php $num++;} ?>
	</table>
	<?php ///print_r($list_email_unread); ?>
</body>
</html>