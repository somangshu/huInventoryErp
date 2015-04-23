<?php $this->load->view('common/pagehead');?>
<?php $this->load->view('common/header'); ?>

<div class="main_content">

	<?php $this->load->view('common/menu'); ?>

	<div class="center_content">

		<?php //$this->load->view('common/leftMenu'); ?>

		<div class="right_content">



			<div class="form">
				<h2 style="text-align: center">Create New User</h2>
				<form action="/insertUser" name="adduser"  onsubmit="return validateAdduser()"  method="post"
					class="niceform">

					<fieldset>
						<dl>
							<dt>
								<label for="username">User Id</label><label for ="star" style="color:red;">*</label>
							</dt>
							<dd>
								<input type="text" name="username" id="username" size="34" />
							</dd>
							<dd>For example: example@valyoo.in</dd>
						</dl>
						<dl>
							<dt>
								<label for="user_role">Select User Role:</label>
							</dt>
							<dd>
								<select size="1" name="user_role" id="user_role">
									<?php foreach ($allRolesArray as $temp){ ?>
									<option value="<?php echo $temp['role_id']; ?>">
										<?php echo $temp['role_name']?>
									</option>
									<?php } ?>
								</select>
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="user_status">Select User Status:</label>
							</dt>
							<dd>
								<select size="1" name="user_status" id="user_status">
									<option value="Yes">Active</option>
									<option value="No">Inactive</option>
								</select>
							</dd>
						</dl>
						<dl>
							<dt>
								<label for="user_description">User Description:</label>
							</dt>
							<dd>
								<textarea name="user_description" id="user_description" rows="5"
									cols="36"></textarea>
							</dd>
						</dl>
						<dl>
							<dt></dt>
							<?php if (isset($messageU)){ ?>
								<dd id="userNameError" style="display: block;color:red;font-weight: bold;"><?php echo $messageU; ?></dd>
							<?php } else { ?>
							<dd id="userNameError" style="display: none;"></dd>
							<?php } ?>
						</dl>
						<dl class="submit">
							<dt></dt>
							<dd style="width: 486px;">
								<input type="submit" name="adduser" id="adduser"
									value="Submit" /> <a
									href="/viewActiveUsers"
									style="text-decoration: none; padding-left: 10px;"> <input
									type="button" name="Cancel" id="Cancel" value="Cancel" />
								</a>
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
