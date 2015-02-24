<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>

<div class="main_content">

	<?php $this->load->view('common/menu'); ?>




	<div class="center_content">



		<?php //$this->load->view('common/leftMenu'); ?>

		<div class="right_content">

			<div class="form">
				<h2 style="text-align: center">Create New Role</h2>
				<form action="/insertRole"  onsubmit=" return validateAddrole()" name="addrole" method="post"
					class="niceform">

					<fieldset>

						<dl>
							<dt>
								<label for="role_name">Role Name:</label><label for ="star" style="color:red;">*</label>
							</dt>
							<dd>
								<input type="text" name="role_name" id="role_name"
									 size="34" />
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="role_desc">Role Description:</label>
							</dt>
							<dd>
								<textarea name="role_desc" id="role_desc" rows="5" cols="36"></textarea>
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="role_status">Role Status:</label>
							</dt>
							<dd>
								<select size="1" name="role_status" id="role_status">
									<option value="Yes">Active</option>
									<option value="No">Inactive</option>
								</select>
							</dd>
						</dl>
						<dl>
							<dt></dt>
							<?php if (isset($messageU)){ ?>
								<dd id="roleError" style="display: block;color:red;font-weight: bold;"><?php echo $messageU; ?></dd>
							<?php } else { ?>
							<dd id="roleError" style="display: none;"></dd>
							<?php } ?>
						</dl>
						<dl class="submit">
							<dt></dt>
							<dd style="width: 477px;">
								<input type="submit" name="addrole" id="addrole"
									onclick=" return validateAddrole()" value="Submit" /> <a
									href="/viewActiveRoles"
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