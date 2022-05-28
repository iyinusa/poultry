    <div class="rightside">
        <div class="page-head">
            <h1>Feeds</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Feeds</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php echo form_open_multipart('feeds'); ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-upload"></i>
                                <h3>New Feed</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            
                            <?php
								$all_branch = '';
								
								//get all branch
								if(!empty($allbranch)){
									foreach($allbranch as $branch){
										if(!empty($e_branch_id)){
											if($e_branch_id == $branch->id){
												$b_sel = 'selected="selected"';	
											} else {$b_sel = '';}
										} else {$b_sel = '';}
										
										$all_branch .= '<option value="'.$branch->id.'" '.$b_sel.'>'.$branch->name.'</option>';
									}
								}
							?>
                            
                            <div class="box-body" style="overflow:auto;">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                <div class="col-lg-12">
                                	<div class="form-group">
                                        <input type="hidden" name="feed_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                        
                                        <label>Date</label>
                                        <input type="text" name="reg_date" placeholder="dd/mm/yyyy" class="form-control" value="<?php if(!empty($e_reg_date)){echo $e_reg_date;} ?>" required="required" /><br />
                                        
                                        <label>Branch</label>
                                        <select name="branch_id" class="form-control">
											<option>...Select Branch</option>
											<?php echo $all_branch; ?>
                                        </select>
                                        <br />
                                        
                                        <label>Feed Name</label>
                                        <input type="text" name="name" placeholder="Feed Name" class="form-control" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required="required" /><br />
                                        
                                        <label>Feed Details</label>
                                        <textarea name="details" class="form-control"><?php if(!empty($e_details)){echo $e_details;} ?></textarea>
                                        <br />
                                        
                                        <label>Quantity</label>
                                        <input type="text" name="qty" placeholder="Feed Quantity" class="form-control" value="<?php if(!empty($e_qty)){echo $e_qty;} ?>" required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-success">Update Record <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                
                
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Feeds Report</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								if(!empty($allup)){
									foreach($allup as $up){
										$branh_name = '';
										$gbranch = $this->user->query_rec_single('id', $up->branch_id, 'bz_branch');
										if(!empty($gbranch)){
											foreach($gbranch as $gb){
												$branh_name = $gb->name;
											}
										}
										
										$dir_list .= '
											<tr>
												<td>'.$up->reg_date.'</td>
												<td>'.$branh_name.'</td>
												<td>'.$up->name.'</td>
												<td>'.$up->qty.'</td>
												<td>
													<a href="'.base_url().'feeds?edit='.$up->id.'" class="btn btn-primary btn"><i class="fa fa-pencil"></i> Edit</a>
													<a href="'.base_url().'feeds?del='.$up->id.'" class="btn btn-danger btn"><i class="fa fa-times"></i> Delete</a>
												</td>
											</tr>
										';	
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>BRANCH</th>
                                        <th>FEED</th>
                                        <th>QTY</th>
                                        <th width="150">MANAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php echo $dir_list; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>