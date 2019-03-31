<?php
	/**
	* Plugin Name: Make It Rain
	* Description: with this script you can throw money/paper at air on click event or can be use customized for make it rain in one or multiple section in site . make money rain(script animation (not gif!)) everywhere in your site that you want. 
	*/
	
	add_action('admin_menu', 'rich_pig_plugin_create_menu');
	function rich_pig_plugin_create_menu() {
		//create new top-level menu
		add_menu_page('Make It Rain', 'Make It Rain', 'administrator', __FILE__, 'rich_pig_plugin_settings_page' , plugins_url('/images/icon.png', __FILE__) );

		//call register settings function
		add_action( 'admin_init', 'register_rich_pig_plugin_settings' );
	}
	function register_rich_pig_plugin_settings() {
		if (!get_option('makeitrain-include-jquery')){
			add_option( 'makeitrain-include-jquery',"yes","","yes");
			add_option( 'makeitrain-money-type',"money-green","","yes");
			add_option( 'makeitrain-time-speed',75,"","yes");
			add_option( 'makeitrain-mode',1,"","yes");
			add_option( 'makeitrain-size',0.5,"","yes");
			add_option( 'makeitrain-tag','a',"","no");
			add_option( 'makeitrain-css','custom',"","no");
			add_option( 'makeitrain-rain-selector','.site-title',"","no");
			add_option( 'makeitrain-rain-count','6',"","no");
			add_option( 'makeitrain-rain-speed',1000,"","no");
			add_option( 'makeitrain-rain-offset','0 0 0 0',"","no");
			add_option( 'makeitrain-custom','document.addEventListener("DOMContentLoaded", function() {
				$(\'.custom\').click(function (){
					 new BlackMoney(
						 document.body,
						 window.makeitrain.time,
						 {
								x : 50,
								y : 50
						 },
						 window.makeitrain.getPath(\'money-green\'),
						 1,
						 1
					);
				});
				});',"","no");
		}
		

		//register our settings
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-include-jquery',array('default'=>'yes') );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-money-type',array('default'=>'money-green') );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-time-speed',array('default'=>75 ));
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-mode',array('default'=>1 ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-size',array('default'=>0.5 ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-tag',array('default'=>'a' ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-css',array('default'=>'' ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-rain-selector',array('default'=>'.site-title' ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-rain-count',array('default'=>'6' ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-rain-speed',array('default'=>1000 ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-rain-offset',array('default'=>'0 0 0 0' ) );
		register_setting( 'rich-pig-plugin-settings-group', 'makeitrain-custom',array('default'=>'document.addEventListener("DOMContentLoaded", function() {
			$(\'.custom\').click(function (){
				 new BlackMoney(
					 document.body,
					 window.makeitrain.time,
					 {
							x : 50,
							y : 50
					 },
					 window.makeitrain.getPath(\'money-green\'),
					 1,
					 1
				);
			});
			});' ) );
	}
	function rich_pig_plugin_settings_page() {
	?>
		<div class="wrap">
		<h1>Make It Rain</h1>

		<form method="post" action="options.php">
			<?php settings_fields( 'rich-pig-plugin-settings-group' ); ?>
			<?php do_settings_sections( 'rich-pig-plugin-settings-group' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row">Include Jquery</th>
					<td>
						<select name="makeitrain-include-jquery">
							<?php $types = ['yes'=>'Enable', 'no'=>'Disable']; ?>
							<?php foreach ($types as $key => $val){ ?>
								<option value="<?= $key ?>" <?php if(esc_attr( get_option('makeitrain-include-jquery') ) == $key) echo 'selected'; ?>><?= $val ?></option>
							<?php } ?>
						</select>
						<br>
						<p class="description">if jquery already exist on your page set disable this option.</p>
					</td>
				</tr>
				<tr valign="top">
				<th scope="row">Paper Type</th>
				<td>
					<select name="makeitrain-money-type">
						<?php $types = [
							'random'             => 'Random',
							'money-colorful'     => 'Money - Colorful',
							'money-black'        => 'Money - Black',
							'money-grey'         => 'Money - Grey',
							'money-blue'         => 'Money - Blue',
							'money-green'        => 'Money - Green',
							'money-gold'         => 'Money - Gold',
							'money-orange'       => 'Money - Orange',
							'money-red'          => 'Money - Red',
							'money-purple'       => 'Money - Purple',
							'paper-colorful'     => 'Paper - Colorful',
							'paper-black'        => 'Paper - Black',
							'paper-blue'         => 'Paper - Blue',
							'paper-green'        => 'Paper - Green',
							'paper-grey'         => 'Paper - Grey',
							'paper-orange'       => 'Paper - Orange',
							'paper-purple'       => 'Paper - Purple',
							'paper-red'          => 'Paper - Red',
							'paper-white'        => 'Paper - White',
							'paper-yellow'       => 'Paper - Yellow',
							'paper-dot-white'    => 'Paper - White(Doted)',
							'custom'    => 'Custom',
						]; ?>
						<?php foreach ($types as $key => $val){ ?>
							<option value="<?= $key ?>" <?php if(esc_attr( get_option('makeitrain-money-type') ) == $key) echo 'selected'; ?>><?= $val ?></option>
						<?php } ?>
					</select>
				</td>
				</tr>
				<tr valign="top">
				<th scope="row">Frame Rate</th>
				<td>
					<input name="makeitrain-time-speed" value="<?=get_option('makeitrain-time-speed') ?>"><br>
					<p class="description">frame rate in millisecond</p>
				</td>
				</tr>
				<tr valign="top">
					<th scope="row">Size</th>
					<td>
						<input name="makeitrain-size" value="<?=get_option('makeitrain-size') ?>"><br>
						<p class="description">a number between 0 to 1 (default : 0.5)</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">Mode</th>
					<td>
						<select id="makeitrain-mode" name="makeitrain-mode" onchange="showHideModeSection()">
							<?php $types = [
									1 => 'Every Click',
									2 => 'Tag Base',
									3 => 'Css Base',
									4 => 'Custom',
									5 => 'Rain'
							]; ?>
							<?php foreach ($types as $key => $val){ ?>
								<option value="<?= $key ?>" <?php if(esc_attr( get_option('makeitrain-mode') ) == $key) echo 'selected'; ?>><?= $val ?></option>
							<?php } ?>
						</select>
						<div id="mode-1" style="display: none;">
							<p class="description">Every click turn into money .</p>
						</div>
						<div id="mode-2"  style="display: none;">
							<table style="width: 450px; background-color: rgba(255,255,255,0.4); padding: 5px; margin-top: 5px;">
								<tr valign="top">
									<th scope="row">Select</th>
									<td>
										<input name="makeitrain-tag" value="<?=get_option('makeitrain-tag') ?>"><br>
										<p class="description">example : put "a" for &lt;a>link&lt;/a></p>
									</td>
								</tr>
							</table>
						</div>
						<div id="mode-3"  style="display: none;">
							<table style="width: 450px; background-color: rgba(255,255,255,0.4); padding: 5px; margin-top: 5px;">
								<tr valign="top">
									<th scope="row">Css Classname</th>
									<td>
										<input name="makeitrain-css" value="<?=get_option('makeitrain-css') ?>">
									</td>
								</tr>
							</table>
						</div>
						<div id="mode-4"  style="display: none;">
							<table style="width: 450px; background-color: rgba(255,255,255,0.4); padding: 5px; margin-top: 5px;">
								<tr valign="top">
									<th scope="row">Code</th>
									<td>
										<textarea cols="50" rows="5" name="makeitrain-custom"><?=get_option('makeitrain-custom') ?></textarea>
									</td>
								</tr>
							</table>

						</div>
						<div id="mode-5"  style="display: none;">
							<table style="width: 450px; background-color: rgba(255,255,255,0.4); padding: 5px; margin-top: 5px;">
								<tr valign="top">
									<th scope="row">Selector</th>
									<td>
										<input name="makeitrain-rain-selector" value="<?=get_option('makeitrain-rain-selector') ?>"><br>
										<p class="description">example : input[type=text]</p>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Count Paper in Period</th>
									<td>
										<input name="makeitrain-rain-count" value="<?=get_option('makeitrain-rain-count') ?>">
										<p class="description">example : 6</p>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Speed</th>
									<td>
										<input name="makeitrain-rain-speed" value="<?=get_option('makeitrain-rain-speed') ?>">
										<p class="description">example : 1000 (ms)</p>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Offset</th>
									<td>
										<input name="makeitrain-rain-offset" value="<?=get_option('makeitrain-rain-offset') ?>">
										<p class="description">example : -50 0 50 100</p>
										<p class="description">numbers from left : top , right , bottom , left</p>
									</td>
								</tr>
							</table>
						</div>
						<script>
							function showHideModeSection(){
								for(var i =1;i<6;i++){
									document.getElementById('mode-'+i).style.display = 'none';
								}
								document.getElementById('mode-'+document.getElementById('makeitrain-mode').value).style.display = 'block';
							}
							showHideModeSection();
						</script>
					</td>
				</tr>
			</table>

			
			<?php submit_button(); ?>

		</form>
		</div>
	<?php } ?>
	
	<?php
	add_action( 'wp_head', 'my_header_scripts' );
	function my_header_scripts(){
	?>
		<?php if (get_option('makeitrain-include-jquery')=='yes'){ ?>
			<script src="<?= plugins_url('js/jquery.min.js', __FILE__)?>" type="application/javascript"></script>
		<?php } ?>
		<script src="<?= plugins_url('js/makeitrain.min.js', __FILE__)?>" type="application/javascript"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function(event) {
				window.makeitrain = {
					base : '<?= plugins_url('/images/', __FILE__)?>',
					type : '<?= get_option('makeitrain-money-type') ?>',
					time : new BlackTimeClass(<?=get_option('makeitrain-time-speed') ?>),
					size : <?= get_option('makeitrain-size') ?>,
					dir : 1,
					getPath : function(fileName){
						return this.base + fileName+'.png';
					},
					generateRandomNumber : function (min , max) {
						let random_number = Math.random() * (max-min) + min;
						return Math.floor(random_number);
					},
					getDir : function(){
						if (this.dir === 1)
							this.dir = -1;
						else
							this.dir = 1;
						return this.dir;
					},
					getType : function(){
						let money = [ 'money-black', 'money-grey', 'money-blue', 'money-green', 'money-gold', 'money-orange', 'money-red', 'money-purple'];
						let paper = [ 'paper-black', 'paper-blue', 'paper-green', 'paper-grey', 'paper-orange', 'paper-purple', 'paper-red', 'paper-white', 'paper-yellow', 'paper-dot-white' ,];
						if (this.type==='money-colorful')
							return this.getPath(money[this.generateRandomNumber(0,money.length)]);
						else if (this.type==='paper-colorful')
							return this.getPath(paper[this.generateRandomNumber(0,paper.length)]);
						else if (this.type==='random'){
							let random = money.concat(paper);
							return this.getPath(random[this.generateRandomNumber(0,random.length)]);
						}
						else
							return this.getPath(this.type)
					}
				};
			});
		</script>
		<?php
		$makeItRainMode = get_option('makeitrain-mode');
		?>

		<?php if ($makeItRainMode==1){ ?>
			<script src="<?= plugins_url('js/makeitrain.mode'.$makeItRainMode.'.js', __FILE__)?>" type="application/javascript"></script>
		<?php } ?>
		<?php if ($makeItRainMode==2){ ?>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					window.makeitrain.tag = '<?= get_option('makeitrain-tag') ?>';
				});
			</script>
			<script src="<?= plugins_url('js/makeitrain.mode'.$makeItRainMode.'.js', __FILE__)?>" type="application/javascript"></script>
		<?php } ?>
		<?php if ($makeItRainMode==3){ ?>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					window.makeitrain.css = '<?= get_option('makeitrain-css') ?>';
				});
			</script>
			<script src="<?= plugins_url('js/makeitrain.mode'.$makeItRainMode.'.js', __FILE__)?>" type="application/javascript"></script>
		<?php } ?>
		<?php if ($makeItRainMode==4){ ?>
			<script>
				<?= get_option('makeitrain-custom') ?>
			</script>
		<?php } ?>
		<?php if ($makeItRainMode==5){ ?>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					window.makeitrain.rainSelector = '<?= get_option('makeitrain-rain-selector') ?>';
					window.makeitrain.rainCount = '<?= get_option('makeitrain-rain-count') ?>';
					window.makeitrain.rainSpeed = parseInt('<?= get_option('makeitrain-rain-speed') ?>');
					window.makeitrain.rainOffset = '<?= trim(get_option('makeitrain-rain-offset')) ?>'.split(' ').map(a=>parseInt(a));
				});
			</script>
			<script src="<?= plugins_url('js/makeitrain.mode'.$makeItRainMode.'.js', __FILE__)?>" type="application/javascript"></script>
		<?php } ?>
	<?php } ?>
	
	