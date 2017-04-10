<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnalizeData
 *
 * @author Artemiusz Znojek
 */
    class AnalizeData{
 
        private $data;
		
		//private $genders = array( 'male' => 0, 'female' => 0 );
       
        private $weights;
 
        private $heights;
       
        public function __construct(){
            $this->getData();
        }
       
		
		public function printChartValues(){
		?>
		[<?php echo $this->calculateMin($this->weights); ?>, <?php echo $this->calculateFirstQuartile($this->weights); ?>,<?php echo $this->calculateMedian($this->weights); ?>, <?php echo $this->calculateThirdQuartile($this->weights); ?>, <?php echo $this->calculateMax($this->weights); ?>],
		
		[<?php echo $this->calculateMin($this->heights); ?>, <?php echo $this->calculateFirstQuartile($this->heights); ?>,<?php echo $this->calculateMedian($this->heights); ?>, <?php echo $this->calculateThirdQuartile($this->heights); ?>, <?php echo $this->calculateMax($this->heights); ?>]
		<?php
		}
		
        public function printResults(){
            ?>
			<table style="width:100%">
			  <tr>
				<th>Tytuł</th>
				<th>Min</th>
				<th>Max</th> 
				<th>Średnia</th> 
				<th>Mediana</th> 
				<th>Dominanta</th> 
				<th>Pierwszy kwartyl</th> 
				<th>Trzeci kwartyl</th> 
			  </tr>
			  <tr>
				<td><strong>Wagi</strong></td>
				<td><?php echo $this->calculateMin($this->weights); ?></td>
				<td><?php echo $this->calculateMax($this->weights); ?></td>
				<td><?php echo $this->calculateAverage($this->weights); ?></td>
				<td><?php echo $this->calculateMedian($this->weights); ?></td>
				<td><?php echo $this->calculateDominant($this->weights); ?></td>
				<td><?php echo $this->calculateFirstQuartile($this->weights); ?></td>
				<td><?php echo $this->calculateThirdQuartile($this->weights); ?></td>
			  </tr>
			  <tr>
				<td><strong>Wzrosty</strong></td>
				<td><?php echo $this->calculateMin($this->heights); ?></td>
				<td><?php echo $this->calculateMax($this->heights); ?></td>
				<td><?php echo $this->calculateAverage($this->heights); ?></td>
				<td><?php echo $this->calculateMedian($this->heights); ?></td>
				<td><?php echo $this->calculateDominant($this->heights); ?></td>
				<td><?php echo $this->calculateFirstQuartile($this->heights); ?></td>
				<td><?php echo $this->calculateThirdQuartile($this->heights); ?></td>
			  </tr>
			</table>
			<hr><br/>
            <?php
        }
          
		public function getJsData(){
			$count = ( count($this->weights) == count($this->heights) )? count($this->weights) : NULL;

			$data = '';
			for ($i=0; $i < $count; $i++) {
				$data .= '['.$this->weights[$i].','.$this->heights[$i].'],';
			}

			return $data;
		}		  
        
        //Wczytywanie danych z pliku csv
        private function getData(){
            $data_file = fopen('01_heights_weights_genders.csv', 'r');
            $loop = 0;
            while (($line = fgetcsv($data_file)) !== FALSE) {
                if( $loop !== 0 ){
					//$this->genders[strtolower($line[0])]++;
					
                    $this->heights[] = $line[1];
 
                    $this->weights[] = $line[2];
 
                    $data[] = $line;
                }
                $loop++;
            }
            fclose($data_file);
 
            array_shift($data);
            $this->data = $data;
        }    
      
    //Obliczanie minimalnej wartosci
    private function calculateMin($array){
        return min($array);
    }
    
    //Obliczanie maksymalnej wartosci
    private function calculateMax($array){
        return max($array);
    }
    
    //Obliczanie sredniej arytmetycznej
    private function calculateAverage($array){
        return array_sum($array) / count($array);
    }
    
    //Obliczanie mediany
    private function calculateMedian($array) {
        //sortowanie tablicy
	sort($array, SORT_NUMERIC);
        //obliczanie ilosci elementow w tablicy
	$count = count($array);
        //wyznaczanie srodka, czyli wartosci sredniej
	$mid = floor($count/2);	

        // zalezne od parzystosci elementow w tablicy
	if (($mid%2) == 0) {
            return ($array[$mid] + $array[$mid--])/2;		
	} else {
		return $array[$mid];
        }
    }
    
    //Obliczanie dominanty
    private function calculateDominant($array){     
		$counter = array_count_values($array); 
		$dominant = array_search(max($counter), $counter);
        return $dominant;
    }
  
    //Obliczanie pierwszego kwartyla
    private function calculateFirstQuartile($array){
        //sortowanie tablicy
	sort($array, SORT_NUMERIC);
        //obliczanie ilosci elementow w tablicy
	$count = count($array);
        
        $k = round(($count+1)*1/4) - 1;
    
        $quartile = $array[$k];
        return $quartile;  
    }
    
    //Obliczanie trzecie kwartyla
    private function calculateThirdQuartile($array){
        //sortowanie tablicy
	sort($array, SORT_NUMERIC);
        //obliczanie ilosci elementow w tablicy
	$count = count($array);
        
        $k = round(($count+1)*3/4) - 1;
    
        $quartile = $array[$k];
        return $quartile;  
    }   
 }
?>
