<?php

namespace Tapir\ChartsBundle\Charts;

/**
 * This class is part of the Andreybolonin\ChartjsBundle
 */
class Chartjs /* extends AbstractChart */ implements ChartInterface
{
	public $ChartData = array();
	public $ChartOptions;

	public $RenderTo;
	public $ChartType = 'Pie';

	private $DatasetNumber = 1;

	public $PresetColors = array(
			'#d08770',
			'#5b90bf',
			'#ebcb8b',
			'#a3be8c',
			'#96b5b4',
			'#bf616a',
			'#ab7967'
	);

	public $LinePresetColors = array (
	        1 => array('fillColor' => 'rgba(220,220,220,0.2)',
    	        'strokeColor' => 'rgba(220,220,220,1)',
                'pointColor' => 'rgba(220,220,220,1)',
                'pointHighlightStroke' => 'rgba(220,220,220,1)'),
	        2 => array('fillColor' => 'rgba(151,187,205,0.2)',
	                'strokeColor' => 'rgba(151,187,205,1)',
	                'pointColor' => 'rgba(151,187,205,1)',
	                'pointHighlightStroke' => 'rgba(151,187,205,1)')
	        );

	/**
	 * Adds a data set to a line chart.
	 *
	 * @param array $values
	 * @param array $labels
	 */
	public function AddLineDataSet($values, $labels = null) {
	    if($labels) {
            $this->ChartData['labels'] = $labels;
	    }

	    $dataset = array_merge($this->LinePresetColors[$this->DatasetNumber], array (
	        'label' => 'dataset' . $this->DatasetNumber,
            'pointStrokeColor' => '#fff',
            'pointHighlightFill' => '#fff',
	        'data' => $values
	    ));

	    $this->ChartData['datasets'][] = $dataset;

	    $this->DatasetNumber++;
	}

	public function AddPieValue($label, $value, $color = null) {
		if(!$this->ChartData) {
			$this->ChartData = array();
		}

		if(!$color) {
			$colorIndex = count($this->ChartData) % count($this->PresetColors);
			$color = $this->PresetColors[$colorIndex];
		}
		$this->ChartData[] = array(
			'label' => $label,
			'value' => $value,
			'color' => $color,
			'highlight' => $this->ColorBrightness($color, 0.8)
		);

		return $this;
	}


	public function AddOption($optionName, $optionValue) {
		if(!$this->ChartOptions) {
			$this->ChartOptions = array();
		}
		$this->ChartOptions[$optionName] = $optionValue;
		return $this;
	}


	protected function ColorBrightness($hex, $percent) {
		$hash = '';
		if (stristr ( $hex, '#' )) {
			$hex = str_replace ( '#', '', $hex );
			$hash = '#';
		}
		// / HEX TO RGB
		$rgb = array (
				hexdec ( substr ( $hex, 0, 2 ) ),
				hexdec ( substr ( $hex, 2, 2 ) ),
				hexdec ( substr ( $hex, 4, 2 ) )
		);
		// // CALCULATE
		for($i = 0; $i < 3; $i ++) {
			// See if brighter or darker
			if ($percent > 0) {
				// Lighter
				$rgb [$i] = round ( $rgb [$i] * $percent ) + round ( 255 * (1 - $percent) );
			} else {
				// Darker
				$positivePercent = $percent - ($percent * 2);
				$rgb [$i] = round ( $rgb [$i] * $positivePercent ) + round ( 0 * (1 - $positivePercent) );
			}
			// In case rounding up causes us to go to 256
			if ($rgb [$i] > 255) {
				$rgb [$i] = 255;
			}
		}
		// // RBG to Hex
		$hex = '';
		for($i = 0; $i < 3; $i ++) {
			// Convert the decimal digit to hex
			$hexDigit = dechex ( $rgb [$i] );
			// Add a leading zero if necessary
			if (strlen ( $hexDigit ) == 1) {
				$hexDigit = "0" . $hexDigit;
			}
			// Append to the hex string
			$hex .= $hexDigit;
		}
		return $hash . $hex;
	}




    /**
     * @param string $engine
     *
     * @return string
     */
    public function render($engine = 'jquery')
    {
        $chartJS = "";

    	if ($engine == 'jquery') {
            $chartJS .= "$(function () {\n";
        }

        $chartJS .= "    var chart_data = " . json_encode($this->ChartData, JSON_PRETTY_PRINT) . "\n";
        $chartJS .= "    var chart_options = " . json_encode($this->ChartOptions, JSON_PRETTY_PRINT) . "\n";

        $chartJS .= "    var chart_context = $(\"#" . $this->RenderTo . "\").get(0).getContext(\"2d\");\n";
        $chartJS .= "    new Chart(chart_context)." . $this->ChartType . "(chart_data, chart_options);\n";

        if ($engine == 'jquery') {
            $chartJS .= "});\n";
        }

        return trim($chartJS);
    }
}
