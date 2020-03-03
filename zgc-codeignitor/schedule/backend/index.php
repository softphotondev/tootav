<?php 
session_start();
/* Include class files */
include(dirname(dirname(__FILE__))."/constants.php");

/* Redirect if user logged in */
if(isset($_SESSION['login_type'])) { 
	if($_SESSION['login_type'] == "customer") { 
		?>
		<script>
		window.location.href = "<?php echo SITE_URL; ?>backend/my-appointments.php";
		</script>
		<?php  
		exit;
	} else if($_SESSION['login_type'] == "admin") { 
		?>
		<script>
		window.location.href = "<?php echo SITE_URL; ?>backend/appointments.php";
		</script>
		<?php  
		exit;
	} else if($_SESSION['login_type'] == "staff") { 
		?>
		<script>
		window.location.href = "<?php echo SITE_URL; ?>backend/s-appointments.php";
		</script>
		<?php  
		exit;
	}else{}
}

include(dirname(dirname(__FILE__))."/classes/class_settings.php");

/* Create object of classes */
$obj_database->check_admin_setup_detail($conn);

$obj_settings = new rzvy_settings();
$obj_settings->conn = $conn;

$company_name = $obj_settings->get_option("rzvy_company_name");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="shortcut icon" type="image/png" href="<?php  echo SITE_URL; ?>includes/images/favicon.ico" />
		<?php 
		$rzvy_seo_ga_code = $obj_settings->get_option('rzvy_seo_ga_code');
		$rzvy_seo_meta_tag = $obj_settings->get_option('rzvy_seo_meta_tag');
		$rzvy_seo_meta_description = $obj_settings->get_option('rzvy_seo_meta_description');
		$rzvy_seo_og_meta_tag = $obj_settings->get_option('rzvy_seo_og_meta_tag');
		$rzvy_seo_og_tag_type = $obj_settings->get_option('rzvy_seo_og_tag_type');
		$rzvy_seo_og_tag_url = $obj_settings->get_option('rzvy_seo_og_tag_url');
		$rzvy_seo_og_tag_image = $obj_settings->get_option('rzvy_seo_og_tag_image'); 
		?>
		
		<title><?php if($rzvy_seo_meta_tag != ""){ echo $rzvy_seo_meta_tag; }else{ echo $obj_settings->get_option("rzvy_company_name"); } ?></title>
		
		<?php 
		if($rzvy_seo_meta_description != ''){ 
			?>
			<meta name="description" content="<?php echo $rzvy_seo_meta_description; ?>">
			<?php 
		} 
		if($rzvy_seo_og_meta_tag != ''){ 
			?>
			<meta property="og:title" content="<?php  echo $rzvy_seo_og_meta_tag; ?>" />
			<?php 
		} 
		if($rzvy_seo_og_tag_type != ''){ 
			?>
			<meta property="og:type" content="<?php echo $rzvy_seo_og_tag_type; ?>" />
			<?php 
		} 
		if($rzvy_seo_og_tag_url != ''){ 
			?>
			<meta property="og:url" content="<?php echo $rzvy_seo_og_tag_url; ?>" />
			<?php 
		} 
		if($rzvy_seo_og_tag_image != '' && file_exists("../uploads/images/".$rzvy_seo_og_tag_image)){ 
			?>
			<meta property="og:image" content="<?php  echo SITE_URL; ?>uploads/images/<?php echo $rzvy_seo_og_tag_image; ?>" />
			<?php 
		} 
		if($rzvy_seo_ga_code != ''){ 
			?>
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $rzvy_seo_ga_code; ?>"></script>
			<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', '<?php echo $rzvy_seo_ga_code; ?>');
			</script>
			<?php  
		} 
		?>
		<!-- Bootstrap core CSS-->
		<link href="<?php echo SITE_URL; ?>includes/vendor/bootstrap/css/bootstrap.min.css?<?php echo time(); ?>" rel="stylesheet">
		<!-- Custom fonts for this template-->
		<link href="<?php echo SITE_URL; ?>includes/vendor/font-awesome/css/font-awesome.min.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
		<!-- Custom styles for this template-->
		<link href="<?php echo SITE_URL; ?>includes/css/rzvy-login.css?<?php echo time(); ?>" rel="stylesheet">
		
		<?php include("bdp_lr_css.php"); ?>
	</head>
	<body class="rzvy">
		<div id="rzvy-loader-overlay" class="rzvy_main_loader rzvy_hide_loader">
			<div id="rzvy-loader" class="rzvy_main_loader rzvy_hide_loader">
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-dot"></div>
				<div class="rzvy-loader-loading"></div>
			</div>
		</div>
		
		<!-- Brand and toggle get grouped for better mobile display -->
		<?php include(dirname(dirname(__FILE__))."/header1.php"); ?>
		
		<section class="container rzvy-login-main p-3 mt-5">
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4 rzvy-login-form-block p-4 m-1">
						<h2 class="text-center"><?php if(isset($rzvy_translangArr['login_now'])){ echo $rzvy_translangArr['login_now']; }else{ echo $rzvy_defaultlang['login_now']; } ?></h2>
						<form id="rzvy_login_form" name="rzvy_login_form">
							<div class="form-group">
								<label for="rzvy_login_email"><?php if(isset($rzvy_translangArr['email'])){ echo $rzvy_translangArr['email']; }else{ echo $rzvy_defaultlang['email']; } ?></label>
								<input type="text" class="form-control" id="rzvy_login_email" name="rzvy_login_email" placeholder="<?php if(isset($rzvy_translangArr['enter_email'])){ echo $rzvy_translangArr['enter_email']; }else{ echo $rzvy_defaultlang['enter_email']; } ?>" value="<?php echo isset($_COOKIE['rzvy_email'])?$_COOKIE['rzvy_email'] : ""; ?>" />
							</div>
							<div class="form-group">
								<label for="rzvy_login_password"><?php if(isset($rzvy_translangArr['password'])){ echo $rzvy_translangArr['password']; }else{ echo $rzvy_defaultlang['password']; } ?></label>
								<input type="password" class="form-control" id="rzvy_login_password" name="rzvy_login_password" placeholder="<?php if(isset($rzvy_translangArr['enter_password'])){ echo $rzvy_translangArr['enter_password']; }else{ echo $rzvy_defaultlang['enter_password']; } ?>" value="<?php echo isset($_COOKIE['rzvy_password'])?$_COOKIE['rzvy_password'] : ""; ?>" />
								<label id="rzvy-login-error" class="error"><?php if(isset($rzvy_translangArr['sorry_rong_email_address_or_password'])){ echo $rzvy_translangArr['sorry_rong_email_address_or_password']; }else{ echo $rzvy_defaultlang['sorry_rong_email_address_or_password']; } ?></label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" id="rzvy_login_remember_me" name="rzvy_login_remember_me" <?php if(isset($_COOKIE['rzvy_remember_me'])){ echo "checked"; } ?> />
									<small><?php if(isset($rzvy_translangArr['remember_me'])){ echo $rzvy_translangArr['remember_me']; }else{ echo $rzvy_defaultlang['remember_me']; } ?></small>
								</label>
							</div>
							<div class="row mt-2">
								<button type="submit" id="rzvy_login_btn" class="btn float-right w-100"><?php if(isset($rzvy_translangArr['login'])){ echo $rzvy_translangArr['login']; }else{ echo $rzvy_defaultlang['login']; } ?></button>
							</div>
						</form>
					</div>
					<div class="col-md-4"></div>
				</div>
			</div>
		</section>
		<!-- Bootstrap core JavaScript-->
		<script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/jquery/jquery.validate.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/bootstrap/js/bootstrap.min.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/vendor/sweetalert/sweetalert.js?<?php echo time(); ?>"></script>
		<!-- Custom scripts for all pages-->
		<script>
			var generalObj = { 'site_url' : '<?php echo SITE_URL; ?>', 'ajax_url' : '<?php echo AJAX_URL; ?>', 'please_enter_email' : "<?php if(isset($rzvy_translangArr['please_enter_email'])){ echo $rzvy_translangArr['please_enter_email']; }else{ echo $rzvy_defaultlang['please_enter_email']; } ?>" 
			, 'please_enter_valid_email' : "<?php if(isset($rzvy_translangArr['please_enter_valid_email'])){ echo $rzvy_translangArr['please_enter_valid_email']; }else{ echo $rzvy_defaultlang['please_enter_valid_email']; } ?>" 
			, 'email_already_exist' : "<?php if(isset($rzvy_translangArr['email_already_exist'])){ echo $rzvy_translangArr['email_already_exist']; }else{ echo $rzvy_defaultlang['email_already_exist']; } ?>" 
			, 'please_enter_password' : "<?php if(isset($rzvy_translangArr['please_enter_password'])){ echo $rzvy_translangArr['please_enter_password']; }else{ echo $rzvy_defaultlang['please_enter_password']; } ?>" 
			, 'please_enter_minimum_8_characters' : "<?php if(isset($rzvy_translangArr['please_enter_minimum_8_characters'])){ echo $rzvy_translangArr['please_enter_minimum_8_characters']; }else{ echo $rzvy_defaultlang['please_enter_minimum_8_characters']; } ?>" 
			, 'please_enter_maximum_20_characters' : "<?php if(isset($rzvy_translangArr['please_enter_maximum_20_characters'])){ echo $rzvy_translangArr['please_enter_maximum_20_characters']; }else{ echo $rzvy_defaultlang['please_enter_maximum_20_characters']; } ?>"
			, 'please_enter_retype_new_password' : "<?php if(isset($rzvy_translangArr['please_enter_retype_new_password'])){ echo $rzvy_translangArr['please_enter_retype_new_password']; }else{ echo $rzvy_defaultlang['please_enter_retype_new_password']; } ?>"
			, 'new_password_and_retype_new_password_mismatch' : "<?php if(isset($rzvy_translangArr['new_password_and_retype_new_password_mismatch'])){ echo $rzvy_translangArr['new_password_and_retype_new_password_mismatch']; }else{ echo $rzvy_defaultlang['new_password_and_retype_new_password_mismatch']; } ?>"
			, 'your_password_reset_successfully_try_login_to_enjoy_services' : "<?php if(isset($rzvy_translangArr['your_password_reset_successfully_try_login_to_enjoy_services'])){ echo $rzvy_translangArr['your_password_reset_successfully_try_login_to_enjoy_services']; }else{ echo $rzvy_defaultlang['your_password_reset_successfully_try_login_to_enjoy_services']; } ?>"
			, 'reset_qm' : "<?php if(isset($rzvy_translangArr['reset_qm'])){ echo $rzvy_translangArr['reset_qm']; }else{ echo $rzvy_defaultlang['reset_qm']; } ?>"
			, 'opps' : "<?php if(isset($rzvy_translangArr['opps'])){ echo $rzvy_translangArr['opps']; }else{ echo $rzvy_defaultlang['opps']; } ?>"
			, 'something_went_wrong_please_try_again' : "<?php if(isset($rzvy_translangArr['something_went_wrong_please_try_again'])){ echo $rzvy_translangArr['something_went_wrong_please_try_again']; }else{ echo $rzvy_defaultlang['something_went_wrong_please_try_again']; } ?>"
			, 'reset_password_link_sent_successfully_at_your_registered_email_address' : "<?php if(isset($rzvy_translangArr['reset_password_link_sent_successfully_at_your_registered_email_address'])){ echo $rzvy_translangArr['reset_password_link_sent_successfully_at_your_registered_email_address']; }else{ echo $rzvy_defaultlang['reset_password_link_sent_successfully_at_your_registered_email_address']; } ?>"
			, 'oops_error_occurred_please_try_again' : "<?php if(isset($rzvy_translangArr['oops_error_occurred_please_try_again'])){ echo $rzvy_translangArr['oops_error_occurred_please_try_again']; }else{ echo $rzvy_defaultlang['oops_error_occurred_please_try_again']; } ?>"
			, 'invalid_email_address' : "<?php if(isset($rzvy_translangArr['invalid_email_address'])){ echo $rzvy_translangArr['invalid_email_address']; }else{ echo $rzvy_defaultlang['invalid_email_address']; } ?>"
			};
		</script>
		<script src="<?php echo SITE_URL; ?>includes/js/rzvy-login.js?<?php echo time(); ?>"></script>
		<script src="<?php echo SITE_URL; ?>includes/js/rzvy-set-languages.js?<?php echo time(); ?>"></script>
	</body>	
</html>