<?php 
    include 'config.php'; 
    
    if (!is_admin())
		exit(1);
	
    if (isset($_POST['0_AV_TYP']))
    {
    	$response_array['status'] = true;

    	if (!check_csrf_token($_POST["CSRF_TOKEN"]))
    	{
    		$response_array['status'] = "CSRF Protection";
    	}
    	else
    	{
		      $configFile = fopen("./modules-config.php", "w");
		      fputs($configFile, "<?php \n\n // Informations related to Modules\n");

		      $mimesok = "";
		      if (isset($_POST['3_AV_OK']))
				$mimesok = htmlentities($_POST['3_AV_OK'], ENT_QUOTES);
			      
		      $mimesnok = "";
		      if (isset($_POST['4_AV_NOK']))
				$mimesnok = htmlentities($_POST['4_AV_NOK'], ENT_QUOTES);     

			  $i = 0;
			  $j = 0;
		      while (isset($_POST[strval($j).'_AV_TYP'])) {
			  	if (!empty($_POST[strval($j).'_AV_NAM'])) {
			      
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_TYP\'] = "' . htmlentities($_POST[strval($j).'_AV_TYP'], ENT_QUOTES) . '";'. "\n");
					  $act = (isset($_POST[strval($j).'_AV_ACT'])) ? 1 : 0;
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_ACT\'] = ' . $act  . ';'. "\n");
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_NAM\'] = "' . htmlentities($_POST[strval($j).'_AV_NAM'], ENT_QUOTES) . '";' . "\n");
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_DES\'][0] = "' . htmlentities($_POST[strval($j).'_AV_FRD'], ENT_QUOTES) . '";' . "\n");
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_DES\'][1] = "' . htmlentities($_POST[strval($j).'_AV_END'], ENT_QUOTES) . '";' . "\n");
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_CMD\'] = "' . htmlentities($_POST[strval($j).'_AV_CMD'], ENT_QUOTES) . '";' . "\n");
					  fputs($configFile, '$_ENV[\''.strval($i).'_AV_PTN\'] = "' . htmlentities($_POST[strval($j).'_AV_PTN'], ENT_QUOTES) . '";' . "\n");

					  if ($i == 3)
					  {
					  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_OK\']  = "/' . str_replace("/","\/",str_replace(",","|", $mimesok))  . '/";' . "\n");
					  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_NOK\']  = "";' . "\n");
					  }
					  else
					  {
					  	if ($i == 4)
					  	{
					  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_OK\']  = "";' . "\n");
					  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_NOK\']  = "/' . str_replace("/","\/",str_replace(",","|", $mimesnok))  . '/";' . "\n");
					  	}
					  	else
					  	{
					  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_OK\']  = "' . htmlentities($_POST[strval($j).'_AV_OK'], ENT_QUOTES)  . '";' . "\n");
					  		fputs($configFile, '$_ENV[\''.strval($i).'_AV_NOK\'] = "' . htmlentities($_POST[strval($j).'_AV_NOK'] , ENT_QUOTES). '";' . "\n");
					  	}
					  }

					  if ($_POST[strval($j).'_AV_TYP'] == 0)
					  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_DGN\'] = "' . htmlentities($_POST[strval($j).'_AV_DGN'], ENT_QUOTES) . '";' . "\n\n");
					  else
					  	fputs($configFile, '$_ENV[\''.strval($i).'_AV_DGN\'] = "' . 1 . '";' . "\n\n");

					$i++;
				}
				$j++;
		      }
		      
		      fputs($configFile, "\n\n?>\n");
		      fclose($configFile);
		}
		 
		header('Content-type: application/json');
		echo json_encode($response_array);
		exit(0);
    }
?>

	    <div id='modulesmgtdiv' style="display:none;" >
	    	<center><b><h4 style="margin-top:20px;cursor:pointer" onclick="$('#modulesmgtdiv').toggle();"><?php echo $_ENV["Accounts43"][$_SESSION['lang']]; ?></h4></b></center>
	    	<br/>
			  <table style="margin-left:-275px" id='modulesmgt' name='modulesmgt' border=1 >
			    <tr>
			      <th style='padding: 10px; width: 150px;'><center><?php echo $_ENV["Modules0"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 95px;'><center><?php echo $_ENV["Modules1"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 150px;'><center><?php echo $_ENV["Modules2"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 100px;'><center><?php echo $_ENV["Modules3"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 200px;'><center><?php echo $_ENV["Modules4"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 150px;'><center><?php echo $_ENV["Modules5"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 150px;'><center><?php echo $_ENV["Modules6"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 150px;'><center><?php echo $_ENV["Modules7"][$_SESSION['lang']]; ?></center></th>
			      <th style='padding: 10px; max-width: 150px;'><center><?php echo $_ENV["Modules8"][$_SESSION['lang']]; ?></center></th>
			    </tr>
			    
			    
			    <tr>
			      <td><center>
				  <select id='0_AV_TYP' name='0_AV_TYP' disabled=true>
				      <option value='0' selected>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' id='0_AV_ACT' <?php if ($_ENV['0_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='0_AV_NAM' value='ClamAV' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='0_AV_FRD' readonly>Analyse antivirale ClamAV.</textarea><br/><textarea id='0_AV_END' readonly>ClamAV antiviral analysis.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='0_AV_CMD' value='/usr/bin/clamdscan --fdpass [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='0_AV_PTN' value='/var/lib/clamav/*.c*d' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='0_AV_OK' value='/\:\ OK/' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='0_AV_NOK' value='/\:\s*(.*)\ FOUND/' readonly/></center></td>
			      <td><center>
				  <select id='0_AV_DGN'>
				      <option value='1' <?php if ($_ENV['0_AV_DGN'] == 1) echo "selected=true"; ?>>1 day</option>
				      <option value='7' <?php if ($_ENV['0_AV_DGN'] == 7) echo "selected=true"; ?>>1 week</option>
				      <option value='10' <?php if ($_ENV['0_AV_DGN'] == 10) echo "selected=true"; ?>>10 days</option>
				      <option value='15' <?php if ($_ENV['0_AV_DGN'] == 15) echo "selected=true"; ?>>15 days</option>
				      <option value='31' <?php if ($_ENV['0_AV_DGN'] == 31) echo "selected=true"; ?>>1 month</option>
				  </select></center>
				</td>
			    </tr>
			    
			    
			    <tr>
			      <td><center>
				  <select id='1_AV_TYP' name='1_AV_TYP' disabled=true>
				      <option value='0' selected>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' id='1_AV_ACT' <?php if ($_ENV['1_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='1_AV_NAM' value='Sophos' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='1_AV_FRD' readonly>Analyse antivirale Sophos.</textarea><br/><textarea id='1_AV_END' readonly>Sophos antiviral analysis.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='1_AV_CMD' value='/opt/cyberhawk/scan-sophos-sssp.sh [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='1_AV_PTN' value='/opt/sophos-av/lib/sav/*.ide' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='1_AV_OK' value='/The\ function\ call\ succeeded/' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='1_AV_NOK' value='/VIRUS\ ([^\ ]*)/' readonly/></center></td>
				<td><center>
				  <select id='1_AV_DGN'>
				      <option value='1' <?php if ($_ENV['1_AV_DGN'] == 1) echo "selected=true"; ?>>1 day</option>
				      <option value='7' <?php if ($_ENV['1_AV_DGN'] == 7) echo "selected=true"; ?>>1 week</option>
				      <option value='10' <?php if ($_ENV['1_AV_DGN'] == 10) echo "selected=true"; ?>>10 days</option>
				      <option value='15' <?php if ($_ENV['1_AV_DGN'] == 15) echo "selected=true"; ?>>15 days</option>
				      <option value='31' <?php if ($_ENV['1_AV_DGN'] == 31) echo "selected=true"; ?>>1 month</option>
				  </select></center>
				</td>
			    </tr>
			    
			    
			    <tr>
			      <td><center>
				  <select id='2_AV_TYP' name='2_AV_TYP' disabled=true>
				      <option value='0' selected>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' id='2_AV_ACT' <?php if ($_ENV['2_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='2_AV_NAM' value='Comodo' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='2_AV_FRD' readonly>Analyse antivirale Comodo.</textarea><br/><textarea id='2_AV_END' readonly>Comodo antiviral analysis.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='2_AV_CMD' value='/opt/COMODO/cmdscan -v -s [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='2_AV_PTN' value='/opt/COMODO/scanners/*.cav' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='2_AV_OK' value='/Not\ Virus/' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='2_AV_NOK' value='/Malware\ Name\ is\ (.*)/' readonly/></center></td>
			      <td><center>
				  <select id='2_AV_DGN'>
				      <option value='1' <?php if ($_ENV['2_AV_DGN'] == 1) echo "selected=true"; ?>>1 day</option>
				      <option value='7' <?php if ($_ENV['2_AV_DGN'] == 7) echo "selected=true"; ?>>1 week</option>
				      <option value='10' <?php if ($_ENV['2_AV_DGN'] == 10) echo "selected=true"; ?>>10 days</option>
				      <option value='15' <?php if ($_ENV['2_AV_DGN'] == 15) echo "selected=true"; ?>>15 days</option>
				      <option value='31' <?php if ($_ENV['2_AV_DGN'] == 31) echo "selected=true"; ?>>1 month</option>
				  </select></center>
				</td>
			    </tr>



			    <tr>
			      <td><center>
				  <select id='3_AV_TYP' name='3_AV_TYP' disabled=true>
				      <option value='0'>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2' selected>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' name='3_AV_ACT' id='3_AV_ACT' onclick="document.getElementById('4_AV_ACT').checked = false;" <?php if ($_ENV['3_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='3_AV_NAM' value='Whitelist' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='3_AV_FRD' readonly>Autorise une liste de fichiers (extensions) ne présentant aucun risque de malveillance.</textarea><br/><textarea id='3_AV_END' readonly>Allows a files' list (extensions) presenting no risk of maliciousness.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='3_AV_CMD' value='file --mime-type -b [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='3_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center>

 					<select name='3_AV_OK[]' id='3_AV_OK' multiple='multiple' class="json-multiple-select0"></select>

				    <script type='text/javascript'>
						$.getJSON('./multipleselect.json', function (data) {
							$.each(data.sectors, function (i, sector) {
								var group = $('<optgroup />').attr('label', sector.title).appendTo('.json-multiple-select0');

								$.each(sector.extensions, function (i, extention) {
									if (extention.name.search("<?php echo $_ENV['3_AV_OK']; ?>") != -1)
										$('<option value="' + extention.value + '" selected=true/>').html(extention.name).appendTo(group);
									else
										$('<option value="' + extention.value + '" />').html(extention.name).appendTo(group);
								});
							});
						});

						setTimeout(
							function() 
							{
								$('#3_AV_OK').multiselect({
							    	enableClickableOptGroups: true,
							    	enableCollapsibleOptGroups: false,
							    	enableFiltering: true,
							    	maxHeight: 200,
							    	buttonWidth: '200px'
								});
							 }
							,500);
						
				    </script>


			      </center></td>


			      <td style='padding: 10px;'><center><input type='hidden' id='3_AV_NOK' value='' readonly/></center></td>
			      <td></td>
			    </tr>


			      <tr>
			      <td><center>
				  <select id='4_AV_TYP' name='4_AV_TYP' disabled=true>
				      <option value='0'>Antivirus</option>
				      <option value='1'>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3' selected>Blacklist</option>
				  </select></center>
				  </td>
			      <td style='padding: 10px;'><center><input type='checkbox' onclick="document.getElementById('3_AV_ACT').checked = false;" name='4_AV_ACT' id='4_AV_ACT' <?php if ($_ENV['4_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input  size=20 type='text' id='4_AV_NAM' value='Blacklist' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='4_AV_FRD' readonly>Bloque une liste de fichiers (extensions) présentant un risque de malveillance.</textarea><br/><textarea id='4_AV_END' readonly>Blocks a files' list (extensions) presenting a risk of maliciousness.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='4_AV_CMD' value='file --mime-type -b [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='4_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='4_AV_OK' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center>

 					<select name='4_AV_NOK[]' id='4_AV_NOK' multiple='multiple' class="json-multiple-select1"></select>


				    <script type='text/javascript'>
						$.getJSON('./multipleselect.json', function (data) {
							$.each(data.sectors, function (i, sector) {
								var group = $('<optgroup />').attr('label', sector.title).appendTo('.json-multiple-select1');

								$.each(sector.extensions, function (i, extention) {
									if (extention.name.search("<?php echo $_ENV['4_AV_NOK']; ?>") != -1)
										$('<option value="' + extention.value + '" selected="selected"/>').html(extention.name).appendTo(group);
									else
										$('<option value="' + extention.value + '" />').html(extention.name).appendTo(group);
								});
							});
						});

						setTimeout(
							function() 
							{
								$('#4_AV_NOK').multiselect({
							    	enableClickableOptGroups: true,
							    	enableCollapsibleOptGroups: false,
							    	enableFiltering: true,
							    	maxHeight: 200,
							    	buttonWidth: '200px'
								});
							 }
							,500);
						
				    </script>



			      </center></td>

			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select id='5_AV_TYP' name='5_AV_TYP' disabled=true>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' id='5_AV_ACT' <?php if ($_ENV['5_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='5_AV_NAM' value='OCR (Images)' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='5_AV_FRD' readonly>Blocage des images par reconnaissance optique de caractères (ROC).</textarea><br/><textarea id='5_AV_END' readonly>Blocking of images by optical character recognition (OCR).</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='5_AV_CMD' value='tesseract [FILE] stdout | grep \a' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='5_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='5_AV_OK' value='<?php echo $_ENV['5_AV_OK']; ?>' /></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='5_AV_NOK' value='<?php echo $_ENV['5_AV_NOK']; ?>' /></center></td>
			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select id='6_AV_TYP' name='6_AV_TYP' disabled=true>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' id='6_AV_ACT' <?php if ($_ENV['6_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='6_AV_NAM' value='OCR (PDF)' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='6_AV_FRD' readonly>Blocage des PDF par reconnaissance optique de caractères (ROC).</textarea><br/><textarea id='6_AV_END' readonly>Blocking of PDF by optical character recognition (OCR).</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='6_AV_CMD' value='pdftotext [FILE] -' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='6_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='6_AV_OK' value='<?php echo $_ENV['6_AV_OK']; ?>' /></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='6_AV_NOK' value='<?php echo $_ENV['6_AV_NOK']; ?>' /></center></td>
			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select id='7_AV_TYP' name='7_AV_TYP' disabled=true>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' id='7_AV_ACT' <?php if ($_ENV['7_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='7_AV_NAM' value='VBA Blocker' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='7_AV_FRD' readonly>Blocage des fichiers Office contenant des Macros.</textarea><br/><textarea id='7_AV_END' readonly>Blocking Office files containing Macros.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='7_AV_CMD' value='/opt/cyberhawk/oletools/oletools/olevba.py -a [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='7_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='7_AV_OK' value='<?php echo $_ENV['7_AV_OK']; ?>' /></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='7_AV_NOK' value='<?php echo $_ENV['7_AV_NOK']; ?>' /></center></td>
			      <td></td>
			    </tr>

			    <tr>
			      <td><center>
				  <select id='8_AV_TYP' name='8_AV_TYP' disabled=true>
				      <option value='0'>Antivirus</option>
				      <option value='1' selected>Command / Script</option>
				      <option value='2'>Whitelist</option>
				      <option value='3'>Blacklist</option>
				  </select></center>
				  </td>
				  <td style='padding: 10px;'><center><input type='checkbox' id='8_AV_ACT' <?php if ($_ENV['8_AV_ACT']) echo "checked"; ?>></center></td>
			      <td style='padding: 10px;'><center><input size=20 type='text' id='8_AV_NAM' value='Malicious VBA Blocker' readonly></center></td>
			      <td style='padding: 10px;'><center><textarea id='8_AV_FRD' readonly>Blocage des fichiers Office contenant des Macros potentiellement malveillantes.</textarea><br/><textarea id='8_AV_END' readonly>Blocking Office files containing potentially malicious macros.</textarea></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='8_AV_CMD' value='/opt/cyberhawk/oletools/oletools/mraptor.py [FILE]' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='hidden' id='8_AV_PTN' value='' readonly/></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='8_AV_OK' value='<?php echo $_ENV['8_AV_OK']; ?>' /></center></td>
			      <td style='padding: 10px;'><center><input type='text' id='8_AV_NOK' value='<?php echo $_ENV['8_AV_NOK']; ?>' /></center></td>
			      <td></td>
			    </tr>

			    <?php 
			    	$cpt = 9;

			    	while(isset($_ENV[$cpt . '_AV_TYP']))
			    	{
			    		echo "
			    		<tr>
			    			  <td><center>
							  <select id='". $cpt . "_AV_TYP' name='". $cpt . "_AV_TYP'>
							      <option value='0'"; if ($_ENV[$cpt . '_AV_TYP'] == "0") echo "selected"; echo ">Antivirus</option>
							      <option value='1'"; if ($_ENV[$cpt . '_AV_TYP'] == "1") echo "selected"; echo ">Command / Script</option>
							      <option value='2'"; if ($_ENV[$cpt . '_AV_TYP'] == "2") echo "selected"; echo ">Whitelist</option>
							      <option value='3'"; if ($_ENV[$cpt . '_AV_TYP'] == "3") echo "selected"; echo ">Blacklist</option>
							  </select></center>
							  <td style='padding: 10px;'><center><input type='checkbox' id='". $cpt . "_AV_ACT'"; if ($_ENV[$cpt . '_AV_ACT'] == 1) echo "checked"; echo "></center></td>
						      <td style='padding: 10px;'><center><input size=20 type='text' id='". $cpt . "_AV_NAM' value='"; echo $_ENV[$cpt . '_AV_NAM']; echo "' ></center></td>
						      <td style='padding: 10px;'><center><textarea id='". $cpt . "_AV_FRD'>"; echo $_ENV[$cpt . '_AV_DES'][0]; echo "</textarea><br/><textarea id='". $cpt . "_AV_END'>"; echo $_ENV[$cpt . '_AV_DES'][1]; echo "</textarea></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='". $cpt . "_AV_CMD' value='"; echo $_ENV[$cpt . '_AV_CMD']; echo "' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='". $cpt . "_AV_PTN' value='"; echo $_ENV[$cpt . '_AV_PTN']; echo "' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='". $cpt . "_AV_OK' value='"; echo $_ENV[$cpt . '_AV_OK']; echo "' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='". $cpt . "_AV_NOK' value='"; echo $_ENV[$cpt . '_AV_NOK']; echo "' /></center></td>
						      <td><center>
							  <select id='". $cpt . "_AV_DGN'>
							      <option value='1'  "; if ($_ENV[$cpt . '_AV_DGN'] == "1") echo "selected"; echo ">1 day</option>
							      <option value='7'  "; if ($_ENV[$cpt . '_AV_DGN'] == "7") echo "selected"; echo ">1 week</option>
							      <option value='10' "; if ($_ENV[$cpt . '_AV_DGN'] == "10") echo "selected"; echo ">10 days</option>
							      <option value='15' "; if ($_ENV[$cpt . '_AV_DGN'] == "15") echo "selected"; echo ">15 days</option>
							      <option value='31' "; if ($_ENV[$cpt . '_AV_DGN'] == "31") echo "selected"; echo ">1 month</option>
							  </select></center>
							</td>
					    </tr>
			    		";
			    		$cpt = $cpt + 1;
			    	}

			    ?>
			  </table>

			  		<center>
						&nbsp;</center>
					<center>
						<button onclick="add_row();" class="btn btn-success">
						<i class="glyphicon glyphicon-plus"></i>
						<span><?php echo $_ENV["Modules9"][$_SESSION['lang']]; ?></span>
						</button></center><br/>
						<center>
						<button id="param_modules_mgt" type="submit" class="btn btn-primary">
						<i class="glyphicon glyphicon-ok"></i>
						<span>OK</span>
						</button></center><br/>

			  
			   <script>
			  	cpt = 0;
			  	function add_row()
			  	{
			  		while (document.getElementById(cpt + "_AV_TYP"))
			  			cpt++;

			  		$('#modulesmgt > tbody').append(`
						    <tr>
						      <td><center>
							  <select id='`+cpt+`_AV_TYP' id='`+cpt+`_AV_TYP'>
							      <option value='0'>Antivirus</option>
							      <option value='1' selected>Command / Script</option>
							  </select></center>
							  </td>
							  <td style='padding: 10px;'><center><input type='checkbox' id='`+cpt+`_AV_ACT'></center></td>
						      <td style='padding: 10px;'><center><input size=20 type='text' id='`+cpt+`_AV_NAM'></center></td>
						      <td style='padding: 10px;'><center><textarea id='`+cpt+`_AV_FRD'></textarea><br/><textarea id='`+cpt+`_AV_END'></textarea></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='`+cpt+`_AV_CMD' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='`+cpt+`_AV_PTN' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='`+cpt+`_AV_OK' /></center></td>
						      <td style='padding: 10px;'><center><input type='text' id='`+cpt+`_AV_NOK' /></center></td>
						      <td><center>
								  <select id='`+cpt+`_AV_DGN'>
								      <option value='1'>1 day</option>
								      <option value='7'>1 week</option>
								      <option value='10' selected >10 days</option>
								      <option value='15'>15 days</option>
								      <option value='31'>1 month</option>
								  </select></center>
							</td>
						    </tr>
			  			`);
			  	}
			  </script>
			  </div>
	  
	<script type='text/javascript'>
		$("#param_modules_mgt").click(function(){ 
			var data = new FormData();

			cpt = 0;

			data.append("CSRF_TOKEN", "<?php echo generate_csrf_token(); ?>");

			while (document.getElementById(cpt + '_AV_TYP'))
			{

				data.append(cpt + "_AV_TYP", $("#" + cpt + "_AV_TYP").val());

				if ($("#" + cpt + "_AV_ACT").is(':checked'))
					data.append(cpt + "_AV_ACT", $("#" + cpt + "_AV_ACT").val());


				data.append(cpt + "_AV_NAM", $("#" + cpt + "_AV_NAM").val());
				data.append(cpt + "_AV_FRD", $("#" + cpt + "_AV_FRD").val());
				data.append(cpt + "_AV_END", $("#" + cpt + "_AV_END").val());
				data.append(cpt + "_AV_CMD", $("#" + cpt + "_AV_CMD").val());
				data.append(cpt + "_AV_PTN", $("#" + cpt + "_AV_PTN").val());

				if (cpt == 3)
				{
					var val = "";
					$("#3_AV_OK").each(function(){ val = $(this).val(); });
					(val == null) ? val="":val=val
					data.append(cpt + "_AV_OK", val);
					data.append(cpt + "_AV_NOK", "");
				}
				else 
				{
					if (cpt == 4)
					{
						var val = "";
						$("#4_AV_NOK").each(function(){ val = $(this).val(); });
						(val == null) ? val="":val=val
						data.append(cpt + "_AV_OK", "");
						data.append(cpt + "_AV_NOK", val);
					}
					else
					{
						data.append(cpt + "_AV_OK", $("#" + cpt + "_AV_OK").val());
						data.append(cpt + "_AV_NOK", $("#" + cpt + "_AV_NOK").val());
					}
				}
				
				data.append(cpt + "_AV_DGN", $("#" + cpt + "_AV_DGN").val());
				cpt++;
			}

			$.ajax({
				type: "POST",
				enctype: "multipart/form-data",
				processData : false,
				contentType: false,
				cache : false,
				url: "./param_modules.php",
				data: data,
				success: function(data, textStatus, jqXHR)
				{
				    if (data.status == true) {
						swal({ title: "<?php echo $_ENV["Accounts9"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Accounts45"][$_SESSION['lang']]; ?>", type: "success" },
						    function(isConfirm){ $('#modulesmgtdiv').toggle(); scroll(0,0); }
						);
				    }
				    else
						swal({ title: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", text: data.status, type: "error" });
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
					swal({ title: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", text: "<?php echo $_ENV["Logs4"][$_SESSION['lang']]; ?>", type: "error" });
				}
			});
		});
	</script>
