<!-- BODY -->

<?php include 'config.php'; ?>

<?php 
	$av_table = array();

	$i = 0;
		while (isset($_ENV[strval($i).'_AV_ACT']))
		{
			if ( ($_ENV[strval($i).'_AV_ACT'] == 1) )
			{
				if (($_ENV[strval($i).'_AV_TYP'] == 0) || ($_ENV[strval($i).'_AV_TYP'] == "0") )
				{
					$now = new DateTime();
					$last_upd 		= new DateTime(explode(' ', check_lastupdate($_ENV[strval($i).'_AV_PTN']), 2)[0]);
					$days_since_last_upd	= $now->diff($last_upd);
					$days_since_last_upd 	= $days_since_last_upd->format('%a');
				}
				else {
					$last_upd 				= new DateTime();
					$days_since_last_upd	= $last_upd->diff($last_upd);
					$days_since_last_upd 	= $days_since_last_upd->format('%a');
				}
				array_push(	
					$av_table, 
					array(
						"AV_TYP" => $_ENV[strval($i).'_AV_TYP'],
						"AV_ACT" => $_ENV[strval($i).'_AV_ACT'],
						"AV_NAM" => $_ENV[strval($i).'_AV_NAM'],
						"AV_DES" => $_ENV[strval($i).'_AV_DES'][$_SESSION['lang']],
						"AV_CMD" => $_ENV[strval($i).'_AV_CMD'], 
						"AV_PTN" => $_ENV[strval($i).'_AV_PTN'], 
						"AV_OK"  => $_ENV[strval($i).'_AV_OK'], 
						"AV_NOK" => $_ENV[strval($i).'_AV_NOK'], 
						"AV_DGN" => $_ENV[strval($i).'_AV_DGN'],
							
						"AV_STA" => check_avstate($_ENV[strval($i).'_AV_CMD']),
						"AV_LUP" => $last_upd,
						"AV_DUP" => $days_since_last_upd
					)
				);
			}
			$i++;
		}
?>

<center>

<div class="container">
	<span style='font-size: 20px; font-weight: bold;'><?php echo $_ENV["Home0"][$_SESSION['lang']] ?></span>
	
	<table border=0>
	    <tr>
		<td><center><span style='font-size: 16px; '><?php echo $_ENV["Home1"][$_SESSION['lang']] .  strval(count($av_table)) . $_ENV["Home2"][$_SESSION['lang']] ?></span></center></td>
		<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
		<td><img src="<?php echo $_ENV["company_logo"]; ?>" alt="[Client LOGO]" /></td>
	    </tr>
	</table>
</div>
	<br /><br /><br />
	
	    <style>
        #container{
            max-width: 480px;
            width: 100%;
            margin: 20px auto;
        }
        #demo_box{
            width: 480px;
        }
        .fa{
            font-size: 50px;
            line-height: 70px;
        }
        .fa-bars{
            color: #3498db;
        }
        pre{
            font-family: Consolas,Liberation Mono,Courier,monospace;
            font-size: 13px;
        }
        @media screen and (orientation: portrait){
            pre{
                overflow-x: scroll;
            }
        }
    </style>

    <center>
        <div style="width:50px;" id="demo_box">
        	<?php
			    $state = true;
			    $update= true;
			    
			    foreach ($av_table as $av){
					if (!$av["AV_STA"])
					    $state = false;
					    
					if ($av["AV_DUP"] >= $av["AV_DGN"])
					    $update = false;
			    }
			    
			    if ($state)
				  if (!$update)
					echo '<span class="pop_ctrl"><i style="color:orange" class="fa fa-flag"></i></span>';
				  else
					echo '<span class="pop_ctrl"><i style="color:green" class="fa fa-flag"></i></span>';
			    else
				  echo '<span class="pop_ctrl"><i style="color:red" class="fa fa-flag"></i></span>';

				if (is_admin() or $_ENV['MOD_DETAILS'] == "on")
				{
					echo '<ul id="demo_ul">';

					foreach ($av_table as $av){
						if ($av["AV_TYP"] == 0) {
							if ($av["AV_DUP"] >= $av["AV_DGN"])
						    {
							    if ($_SESSION['lang'] == 0)
							    	echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"] . ' <br />' . $_ENV["Home11"][$_SESSION['lang']] . ' <b><span style=font-size:14px;color:orange;>' . $av["AV_LUP"]->format('d/m/Y') . '</span>' . '\', html: true, timer: 5000 });"><div><i class="fa fa-antivirus"></i></div><div>'.$av["AV_NAM"].'</div></li>';
							    else
								    echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"] . ' <br />' . $_ENV["Home11"][$_SESSION['lang']] . ' <b><span style=font-size:14px;color:orange;>' . $av["AV_LUP"]->format('m-d-Y') . '</span>' . '\', html: true, timer: 5000 });"><div><i class="fa fa-antivirus"></i></div><div>'.$av["AV_NAM"].'</div></li>';
							}
						    else
						    {	  
							    if ($_SESSION['lang'] == 0)
								    echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"] . ' <br />' . $_ENV["Home11"][$_SESSION['lang']] . ' <b><span style=font-size:14px;color:green;>' . $av["AV_LUP"]->format('d/m/Y') . '</span>' . '\', html: true, timer: 5000 });"><div><i class="fa fa-antivirus"></i></div><div>'.$av["AV_NAM"].'</div></li>';
							    else
								    echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"] . ' <br />' . $_ENV["Home11"][$_SESSION['lang']] . ' <b><span style=font-size:14px;color:green;>' . $av["AV_LUP"]->format('m-d-Y') . '</span>' . '\', html: true, timer: 5000 });"><div><i class="fa fa-antivirus"></i></div><div>'.$av["AV_NAM"].'</div></li>';
							}						    
						}
					}

					foreach ($av_table as $av)
						if ($av["AV_TYP"] == 2)
					    	echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"]. '\', html: true, timer: 5000 });"><div><i class="fa fa-file-ok"></i></div><div>'.$av["AV_NAM"].'</div></li>';

					foreach ($av_table as $av)
						if ($av["AV_TYP"] == 3) 
					    	echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"].'\', html: true, timer: 5000 });"><div><i class="fa fa-file-nok"></i></div><div>'.$av["AV_NAM"].'</div></li>';

					foreach ($av_table as $av)
						if ($av["AV_TYP"] == 1) 
					    	echo '<li id='.str_replace(' ', '', $av["AV_NAM"]).' class="demo_li" onclick="swal({ title: \''.$av["AV_NAM"].'\', text: \''.$av["AV_DES"].'\', html: true, timer: 5000 });"><div><i class="fa fa-script"></i></div><div>'.$av["AV_NAM"].'</div></li>';
				}

		    ?>
            
            </ul>
        </div>
    </center>


    <script>
		    (function ($) {

		    $.fn.popmenu = function (options) {

		        var settings = $.extend({
		            'controller': true,
		            'width': '500px',
		            'background': '#1b3647',
		            'focusColor': '#d06503',
		            'borderRadius': '10px',
		            'top': '175',
		            'left': '220',
		            'iconSize': '125px',
		            //'color': '#f0f',
		            'border': '0px'
		        }, options);
		        if (settings.controller === true) {
		            var temp_display = 'none';
		        } else {
		            var temp_display = 'block';
		        }
		        var tar = $(this);
		        var tar_body = tar.children('ul');
		        var tar_list = tar_body.children('li');
		        var tar_a = tar_list.children('a');
		        var tar_ctrl = tar.children('.pop_ctrl');


		        function setIt() {
		            tar_body.css({
		                'display': temp_display,
		                'position': 'absolute',
		                'margin-top': -settings.top,
		                'margin-left': -settings.left,
		                'background': settings.background,
		                'width': settings.width,
		                'float': 'left',
		                'padding': '0',
		                'border-radius': settings.borderRadius,
		                'border': settings.border
		            });
		            
		            tar_list.css({
		                'display': 'block',
		                //'color': '#f00',
		                'float': 'left',
		                'width': settings.iconSize,
		                'height': settings.iconSize,
		                'text-align': 'center',
		                'border-radius': settings.borderRadius
		            });
		            tar_a.css({
		                'text-decoration': 'none',
		                //'color': settings.color
		            });
		            tar_ctrl.hover(function () {
		                tar_ctrl.css('cursor', 'pointer');
		            }, function () {
		                tar_ctrl.css('cursor', 'default')
		            });
		            tar_ctrl.click(function (e) {
		                e.preventDefault();
		                tar_body.show('slow');
		                $(document).mouseup(function (e) {
		                    var _con = tar_body;
		                    if (!_con.is(e.target) && _con.has(e.target).length === 0) {
		                        _con.hide();
		                    }
		                    //_con.hide(); some functions you want
		                });
		            });
		            tar_list.hover(function () {
		                $(this).css({
		                    'background': settings.focusColor,
		                    'cursor': 'pointer'
		                });
		            }, function () {
		                $(this).css({
		                    'background': settings.background,
		                    'cursor': 'default'
		                });
		            });
		        }
		        return setIt();

		    };

		}(jQuery));
        $(function(){
            $('#demo_box').popmenu();
        })
    </script>

    <b><span style='font-size: 16px; '><?php echo $_ENV["Home4"][$_SESSION['lang']] ?></span><span style='font-size: 16px; '>
	<?php
	    if (count($av_table) > 0) {
	?>
		    <?php
			    $state = true;
			    $update= true;
			    
			    foreach ($av_table as $av){
				if (!$av["AV_STA"])
				    $state = false;
				    
				if ($av["AV_DUP"] >= $av["AV_DGN"])
				    $update = false;
			    }
			    
			    if ($state)
				  if (!$update)
					echo $_ENV["Home6"][$_SESSION['lang']];
				  else
					echo $_ENV["Home5"][$_SESSION['lang']];
			    else
				  echo $_ENV["Home7"][$_SESSION['lang']];
		    ?>
	    
	    
	<?php }
	else
	{
		echo $_ENV["Home5"][$_SESSION['lang']];
	} ?>
	</span></b>

	<script>

		<?php
			foreach ($av_table as $av){
				echo "document.getElementById('".str_replace(' ', '', $av["AV_NAM"])."').style.color='green';";

				if ($av["AV_DUP"] >= $av["AV_DGN"])
					echo "document.getElementById('".str_replace(' ', '', $av["AV_NAM"])."').style.color='orange';";
				if (!$av["AV_STA"])
				    echo "document.getElementById('".str_replace(' ', '', $av["AV_NAM"])."').style.color='red';";
			}
		?>
	</script>
	<br/><?php 
		if (is_admin() or $_ENV['CHX_VERSION'] == "on")
			echo $_ENV["Home12"][$_SESSION['lang']] . "<a onclick=\"change_content('./changelog.php');\" style='cursor:pointer'>2.2.0</a>" . $_ENV["Home13"][$_SESSION['lang']]; 

	?><br/>&nbsp;
	
</center>
