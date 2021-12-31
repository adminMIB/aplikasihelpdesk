<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">New Customer</li>
	</ol>
</div><!--/.row-->
<br>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading"><svg class="glyph stroked male user "><use xlink:href="#stroked-male-user"/></svg>
				<a href="#" style="text-decoration:none; font-color:white">Customer</a></div>
				<?php echo $this->session->flashdata("msg");?>
				<div class="panel-body">
					<form method="post" action="<?php echo base_url('ticket/submit_new_user2');?>">
						<div class="col-md-6">

							<div class="form-group">
								<label>Nama Customer</label>
								<select class="form-control" name="nama_cust" required="">
									<option value="">--PILIH DATA--</option>
									<?php foreach($list_kategori as $list_kategori_obj){ ?>										
										<option value="<?php echo $list_kategori_obj->id_kategori; ?>"><?php echo $list_kategori_obj->nama_kategori; ?></option>
									<?php } ?>
								</select>
						    </div>
					     </div>
					     <div class="col-md-6">
					     	<div class="form-group">
								<label>Email</label>
								<input class="form-control" name="email" placeholder="email" value="" required>
						    </div>
					     </div>

					    <div class="col-md-6">

						    <div class="form-group">
								<label>No Telp</label>
								<input class="form-control" name="telepon" placeholder="telepon" value="" required>
						    </div>
					    </div>
					     <div class="col-md-6">
					     	 <div class="form-group">
								<label>Nama Project</label>
								<select class="form-control" name="nama_project" required="">
									<option value="">--PILIH DATA--</option>
									<?php foreach($list_sub_kategori as $list_sub_kategori_obj){ ?>										
										<option value="<?php echo $list_sub_kategori_obj->id_sub_kategori; ?>"><?php echo $list_sub_kategori_obj->nama_sub_kategori. "( kategori : ".$list_sub_kategori_obj->nama_kategori." )"; ?></option>
									<?php } ?>
								</select>
						    </div>
					     </div>
					     <div class="col-md-6">

						    <div class="form-group">
								<label>SLA Tiket</label>
								<input class="form-control" name="sla" placeholder="SLA Tiket" value="" required>
						    </div>
					    </div>
					    <div class="col-md-6">
						    <div class="form-group">
								<label>Nama Teknisi</label>
								<select class="form-control" name="nama_teknisi" required="">
									<option value="">--PILIH DATA--</option>
									<?php foreach($list_teknisi as $list_teknisi_obj){ ?>										
										<option value="<?php echo $list_teknisi_obj->id_teknisi; ?>"><?php echo $list_teknisi_obj->nik. "( ".$list_teknisi_obj->nama." -  ".$list_teknisi_obj->nama_kategori." )"; ?></option>
									<?php } ?>
								</select>
						    </div>
					    </div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Jumlah Token</label>
								<input class="form-control" name="token" placeholder="Jumlah token" type="number" value="" required>
						    </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Password</label>
								<input class="form-control" name="password" placeholder="Password" type="password" value="" required>
						    </div>
						</div>
						<div class="col-md-6">
							<button class="btn btn-primary" type="submit">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>