<?php 
    include 'config.php'; 

    if (!is_admin())
	exit(1);
?>

   		<style>
			canvas {
			    -moz-user-select: none;
			    -webkit-user-select: none;
			    -ms-user-select: none;
			}
    	</style>
		<div id="statmgt" style='display:none;'>
			<center><b><h4 style="margin-top:0px;cursor:pointer" onclick="$('#statmgt').toggle();"><?php echo $_ENV["Stats0"][$_SESSION['lang']]; ?></h4></b></center>
			<br/><br/>
			  <center>
				  <div id="canvas-holder" style="width:60%">
	        			<canvas id="chart-area-pie" />
	    		  </div>

	    		  	<div id="canvas-holder">
	        			<canvas id="chart-area-bar-1" />
	    		  </div>
    		  </center>

		    <script>
		    var randomScalingFactor = function() {
		        return Math.round(Math.random() * 100);
		    };

		    var config = {
		        type: 'doughnut',
		        data: <?php echo pie_chart_detections(); ?>,
		        options: {
		            responsive: true,
		            legend: {
		                position: 'right',
		                labels: {
			                generateLabels: function(chart) {
			                    var data = chart.data;
			                    if (data.labels.length && data.datasets.length) {
			                        return data.labels.map(function(label, i) {
			                            var meta = chart.getDatasetMeta(0);
			                            var ds = data.datasets[0];
			                            var arc = meta.data[i];
			                            var custom = arc && arc.custom || {};
			                            var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
			                            var arcOpts = chart.options.elements.arc;
			                            var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
			                            var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
			                            var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

										// We get the value of the current label
										var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

			                            return {
			                                // Instead of `text: label,`
			                                // We add the value to the string
			                                text: label + " : " + value,
			                                fillStyle: fill,
			                                strokeStyle: stroke,
			                                lineWidth: bw,
			                                hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
			                                index: i
			                            };
			                        });
			                    } else {
			                        return [];
			                    }
			                }
			            }
		            },
		            title: {
		                display: true,
		                text: '<?php echo $_ENV["Stats1"][$_SESSION["lang"]] ?>',
		                fontSize: 18
		            },
		            scale: {
		              ticks: {
		                beginAtZero: true
		              },
		              reverse: false
		            },
		            animation: {
		                animateRotate: false,
		                animateScale: true
		            }
		        }
		    };


		    var ctx = document.getElementById("chart-area-pie").getContext("2d");
		    window.myDoughnut = new Chart.PolarArea(ctx, config);

	        var color = Chart.helpers.color;
	        var horizontalBarChartData = <?php echo bar_chart_detections() ?>;


            var ctx = document.getElementById("chart-area-bar-1").getContext("2d");
            window.myHorizontalBar = new Chart(ctx, {
                type: 'horizontalBar',
                height:500,
                maintainAspectRatio:false,
                data: horizontalBarChartData,
                options: {
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                        }
                    },
                    responsive: true,
                    scales: {
	                    xAxes: [{
	                            stacked: true
	                        }],
	                    yAxes: [{
	                            barThickness: 25,
	                            stacked: true
	                        }]
	                },
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
			fontSize: 18,
                        text: '<?php echo $_ENV["Stats2"][$_SESSION["lang"]] ?>'
                    }
                }
            });
		   
		    </script>
		</div><br/>
