<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
		<li class="active">Edit Customer</li>
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
					<?php if(!empty($data_customer)){ ?>
						<form method="post" action="<?php echo base_url('customer/submit_edit/'.$data_customer->id_customer);?>">
							<div class="col-md-6">

								<div class="form-group">
									<label>Nama Customer</label>
									<select class="form-control" name="nama_cust" required="">
										<option value="">--PILIH DATA--</option>
										<?php foreach($list_kategori as $list_kategori_obj){ ?>										
											<option <?php if($list_kategori_obj->id_kategori==$data_customer->customer_reff){echo "selected";} ?> value="<?php echo $list_kategori_obj->id_kategori; ?>"><?php echo $list_kategori_obj->nama_kategori; ?></option>
										<?php } ?>
									</select>
							    </div>
						     </div>
						     <div class="col-md-6">
						     	<div class="form-group">
									<label>Email</label>
									<input required class="form-control" name="email" placeholder="email" value="<?php echo $data_customer->customer_email; ?>" >
							    </div>
						     </div>

						    <div class="col-md-6">

							    <div class="form-group">
									<label>No Telp</label>
									<input class="form-control" name="telepon" placeholder="telepon" value="<?php echo $data_customer->telepon; ?>" >
							    </div>
						    </div>
						     <div class="col-md-6">
						     	 <div class="form-group">
									<label>Nama Project</label>
									<select class="form-control" name="nama_project" required="">
										<option value="">--PILIH DATA--</option>
										<?php foreach($list_sub_kategori as $list_sub_kategori_obj){ ?>										
											<option <?php if($list_sub_kategori_obj->id_sub_kategori==$data_customer->project_id){echo "selected";} ?> value="<?php echo $list_sub_kategori_obj->id_sub_kategori; ?>"><?php echo $list_sub_kategori_obj->nama_sub_kategori. "( kategori : ".$list_sub_kategori_obj->nama_kategori." )"; ?></option>
										<?php } ?>
									</select>
							    </div>
						     </div>
						    <div class="col-md-6">
							    <div class="form-group">
									<label>Nama Teknisi</label>
									<select class="form-control" name="nama_teknisi" required="">
										<option value="">--PILIH DATA--</option>
										<?php foreach($list_teknisi as $list_teknisi_obj){ ?>										
											<option <?php if($list_teknisi_obj->id_teknisi==$data_customer->teknisi_id){echo "selected";} ?> value="<?php echo $list_teknisi_obj->id_teknisi; ?>"><?php echo $list_teknisi_obj->nik. "( ".$list_teknisi_obj->nama." -  ".$list_teknisi_obj->nama_kategori." )"; ?></option>
										<?php } ?>
									</select>
							    </div>
						    </div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Jumlah Token</label>
									<input class="form-control" name="token" placeholder="Jumlah token" type="number" value="<?php echo $data_customer->token; ?>" required>
							    </div>
							</div>

							<div class="col-md-6">
								<button class="btn btn-primary" type="submit">Update</button>
							</div>
						</form>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>