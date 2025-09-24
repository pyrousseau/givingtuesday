<?php
/**
 * LIMB gallery
 * Frontend
 * Masonry view
 */
 
class GRSViewMasonry {
	
	//Private variables
	private $model;
	//Costructor
	public function __construct($model) {
		$this->model = $model;
    }

	public function display($counter) {
		?>
		<div id="grsGal<?php echo $counter; ?>" class="grsGal<?php echo $counter; ?> grsTemplate<?php echo $this->model->theme; ?>">
			<div class="grsGalCont" ng-controller="grsMasonry<?php echo $counter; ?>" ng-show="params.cssReady" >
				<grs-masonry params="params" resize scroll></grs-masonry>
			</div>
		</div>
		<script>
			var grsAtts<?php echo $counter; ?> = jQuery.parseJSON('<?php echo $this->model->atts; ?>');
			grsApp.controller('grsMasonry<?php echo $counter; ?>', ['$scope', '$filter', '$log',
				function ($scope, $filter, $log) {
					$scope.params = {
						shatts: grsAtts<?php echo $counter; ?>,
						grs: '<?php echo $counter; ?>',
						data: {
							images : [],
							comments: [],
							theme: {}
						},
						cssReady: false
					};
					insertCss(grsAtts<?php echo $counter; ?>, '<?php echo $counter; ?>');
				}
			]);
		</script>		
		<?php
    }
}