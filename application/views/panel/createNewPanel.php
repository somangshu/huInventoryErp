<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>

<div class="main_content">

	<?php $this->load->view('common/menu'); ?>




	<div class="center_content">



		<?php //$this->load->view('common/leftMenu'); ?>

		<div class="right_content">



			<div class="form">
				<h2 style="text-align: center">Create New Panel</h2>
				<form action="/insertPanel" onkeypress="checkPanel()" onblur="checkPanel()" onsubmit=" return validateAddpanel()"
					name="addpanel" method="post" class="niceform">

					<fieldset>
						<dl>
							<dt>
								<label for="panel_parent">Select Parent Panel:</label><label for ="star" style="color:red;">*</label>
							</dt>
							<dd>
								<select size="1" name="panel_parent" id="panel_parent">
									<option value="0">Main Panel</option>
									<?php foreach ($mainPanelsArray as $temp){ ?>
									<option value="<?php echo $temp['panel_id']; ?>">
										<?php echo $temp['panel_name']; ?>
									</option>
									<?php } ?>
								</select>
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="panel_name">Panel Name:</label><label for ="star" style="color:red;">*</label>
							</dt>
							<dd>
								<input type="text" name="panel_name" id="panel_name" size="34" />
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="panel_url">Panel URL:</label><label for ="star" style="color:red;">*</label>
							</dt>
							<dd>
								<input type="text" name="panel_url" id="panel_url" size="34" />
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="panel_desc">Panel Description:</label>
							</dt>
							<dd>
								<textarea name="panel_desc" id="panel_desc" rows="5" cols="36"></textarea>
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="panel_status">Panel Status:</label>
							</dt>
							<dd>
								<select size="1" name="panel_status" id="panel_status">
									<option value="Yes">Active</option>
									<option value="No">Inactive</option>
								</select>
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="panel_type">Panel Type:</label>
							</dt>
							<dd>
								<select size="1" name="panel_type" id="panel_type">
									<option value="None">None</option>
									<option value="Display">Display</option>
								</select>
							</dd>
						</dl>
						<dl>
							<dt></dt>
							<?php if (isset($messageU)){ ?>
								<dd id="panelError" style="display: block;color:red;font-weight:bold;"><?php echo $messageU; ?></dd>
							<?php } else { ?>
							<dd id="panelError" style="display: none;"></dd>
							<?php } ?>
						</dl>
						<dl class="submit">
							<dt></dt>
							<dd style="width: 477px;">
								<input type="submit" name="addpanel" id="addpanel"
									value="Submit" /> <a href="/viewActivePanels"
									style="text-decoration: none; padding-left: 10px;"><input
									type="button" name="Cancel" id="Cancel" value="Cancel" /> </a>
							</dd>
						</dl>

						<dl>
							<?php if (isset($message)){ 
								echo $message;
							} ?>
						</dl>
						
					</fieldset>

				</form>
			</div>


		</div>
		<!-- end of right content-->


	</div>
	<!--end of center content -->




	<div class="clear"></div>
</div>
<!--end of main content-->


<?php $this->load->view('common/footer'); ?>