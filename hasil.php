
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
while ($row = $result->fetch_object()) {
  array_push($X[1], round($row->C1, 2));
  array_push($X[2], round($row->C2, 2));
  array_push($X[3], round($row->C3, 2));
  array_push($X[4], round($row->C4, 2));
  echo "<tr class='center'>
  <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
  <td>" . round($row->C1, 2)  . "</td>
  <td>" . round($row->C2, 2) . "</td>
  <td>" . round($row->C3, 2) . "</td>
  <td>" . round($row->C4, 2) . "</td>
  <td>
  <a href='keputusan-hapus.php?id={$row->id_alternative}' class='btn btn-danger btn-sm'>Hapus</a>
  </td>
  </tr>\n";
}
$total_C1 = array_sum($X[1]);
$total_C2 = array_sum($X[2]);
$total_C3 = array_sum($X[3]);
$total_C4 = array_sum($X[4]);
echo "
  <tr class='center'>
  <th>Total</th>
  <td>" . array_sum($X[1]) . "</td>
  <td>" . array_sum($X[2]) . "</td>
  <td>" . array_sum($X[3]) . "</td>
  <td>" . array_sum($X[4]) . "</td>
  </tr>\n";
$result->free();

?>
</table><br><br>

<table class="table table-striped mb-0">
    <caption>
        Normalisasi Matrik X
    </caption>
    <tr>
        <th rowspan='2'>Alternatif</th>
        <th colspan='6'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
        <th colspan="2"></th>
    </tr>
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
while ($row = $result->fetch_object()) {
  array_push($X[1], round($row->C1, 2));
  array_push($X[2], round($row->C2, 2));
  array_push($X[3], round($row->C3, 2));
  array_push($X[4], round($row->C4, 2));
  $normalisasi_C1 = round(($row->C1/$total_C1), 3);
  $normalisasi_C2 = round(($row->C2/$total_C2), 3);
  $normalisasi_C3 = round(($row->C3/$total_C3), 3);
  $normalisasi_C4 = round(($row->C4/$total_C4), 3);
  echo "<tr class='center'>
  <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
  <td>" . $normalisasi_C1  . "</td>
  <td>" . $normalisasi_C2  . "</td>
  <td>" . $normalisasi_C3  . "</td>
  <td>" . $normalisasi_C4  . "</td>
  
  </tr>\n";
}
$result->free();

?>
</table><br><br>





<table class="table table-striped mb-0">
    <caption>
      Matriks Keputusan Berbobot Yang Ternormalisasi
    </caption>
    <tr>
        <th rowspan='2'>Alternatif</th>
        <th colspan='6'>Kriteria</th>
    </tr>
    <tr>
        <th>C1</th>
        <th>C2</th>
        <th>C3</th>
        <th>C4</th>
        <th colspan="2"></th>
    </tr>
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4
        FROM
          saw_criterias";
$result2 = $db->query($sql2);
while($weight = $result2->fetch_object()){
  $bobot_C1 = round($weight->B1, 2);
  $bobot_C2 = round($weight->B2, 2);
  $bobot_C3 = round($weight->B3, 2);
  $bobot_C4 = round($weight->B4, 2);
}
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
while ($row = $result->fetch_object()) {
  array_push($X[1], round($row->C1, 2));
  array_push($X[2], round($row->C2, 2));
  array_push($X[3], round($row->C3, 2));
  array_push($X[4], round($row->C4, 2));
  $normalisasi_C1 = round(($row->C1/$total_C1), 3);
  $normalisasi_C2 = round(($row->C2/$total_C2), 3);
  $normalisasi_C3 = round(($row->C3/$total_C3), 3);
  $normalisasi_C4 = round(($row->C4/$total_C4), 3);
  $bobot_ternormalisasi_C1 = round(($normalisasi_C1*$bobot_C1), 3);
  $bobot_ternormalisasi_C2 = round(($normalisasi_C2*$bobot_C2), 3);
  $bobot_ternormalisasi_C3 = round(($normalisasi_C3*$bobot_C3), 3);
  $bobot_ternormalisasi_C4 = round(($normalisasi_C4*$bobot_C4), 3);
  echo "<tr class='center'>
  <th>A<sub>{$row->id_alternative}</sub> {$row->name}</th>
  <td>" . $bobot_ternormalisasi_C1 . "</td>
  <td>" . $bobot_ternormalisasi_C2 . "</td>
  <td>" . $bobot_ternormalisasi_C3 . "</td>
  <td>" . $bobot_ternormalisasi_C4 . "</td>
  
  
  </tr>\n";
}
$result->free();

?>
</table><br><br>


<table class="table table-striped mb-0">
    <caption>
      Perhitungan memaksimalkan
    </caption>
    <tr>
      <th colspan='2'>S+i = C2 + C3 + C4</th>
      <th colspan='2'>Si = C1</th>
    </tr>
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4
        FROM
          saw_criterias";
$result2 = $db->query($sql2);
while($weight = $result2->fetch_object()){
  $bobot_C1 = round($weight->B1, 2);
  $bobot_C2 = round($weight->B2, 2);
  $bobot_C3 = round($weight->B3, 2);
  $bobot_C4 = round($weight->B4, 2);
}
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
$array_cost = array();
$array_benefit = array();
while ($row = $result->fetch_object()) {
  array_push($X[1], round($row->C1, 2));
  array_push($X[2], round($row->C2, 2));
  array_push($X[3], round($row->C3, 2));
  array_push($X[4], round($row->C4, 2));
  $normalisasi_C1 = round(($row->C1/$total_C1), 3);
  $normalisasi_C2 = round(($row->C2/$total_C2), 3);
  $normalisasi_C3 = round(($row->C3/$total_C3), 3);
  $normalisasi_C4 = round(($row->C4/$total_C4), 3);
  $bobot_ternormalisasi_C1 = round(($normalisasi_C1*$bobot_C1), 3);
  $bobot_ternormalisasi_C2 = round(($normalisasi_C2*$bobot_C2), 3);
  $bobot_ternormalisasi_C3 = round(($normalisasi_C3*$bobot_C3), 3);
  $bobot_ternormalisasi_C4 = round(($normalisasi_C4*$bobot_C4), 3);
  $benefit = $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4;
  $cost = $bobot_ternormalisasi_C1;
  array_push($array_cost, $cost);
  $total_cost = round(array_sum($array_cost), 2);
  array_push($array_benefit, $benefit);
  $total_benefit = round(array_sum($array_benefit), 2);
  echo "<tr class='center'>
  <th>S<sub>{$row->id_alternative}</sub></th>
  <td>" . $benefit . "</td>
  <th>S<sub>{$row->id_alternative}</sub></th>
  <td>" . $cost . "</td>

  
  
  
  </tr>\n";
}
echo "
  <tr class='center'>
  <th>Total</th>
  <td>" .$total_benefit. "</td>
  <th>Total</th>
  <td>" .$total_cost. "</td>
  
  </tr>\n";
$result->free();

?>
</table><br><br>


<table class="table table-striped mb-0">
    <caption>
      Perhitungan bobot relatif tiap alternatif
    </caption>
    <tr>
      <th colspan='2'>1/Si</th>
      <th colspan='2'>Si * total 1/Si</th>
      <th colspan='2'>Bobot Relatif</th>
    </tr>
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4
        FROM
          saw_criterias";
$result2 = $db->query($sql2);
while($weight = $result2->fetch_object()){
  $bobot_C1 = round($weight->B1, 2);
  $bobot_C2 = round($weight->B2, 2);
  $bobot_C3 = round($weight->B3, 2);
  $bobot_C4 = round($weight->B4, 2);
}
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
$array_cost = array();
$array_benefit = array();
$array_relatif = array();
$array_maxq = array();

while ($row = $result->fetch_object()) {
  array_push($X[1], round($row->C1, 2));
  array_push($X[2], round($row->C2, 2));
  array_push($X[3], round($row->C3, 2));
  array_push($X[4], round($row->C4, 2));
  $normalisasi_C1 = round(($row->C1/$total_C1), 3);
  $normalisasi_C2 = round(($row->C2/$total_C2), 3);
  $normalisasi_C3 = round(($row->C3/$total_C3), 3);
  $normalisasi_C4 = round(($row->C4/$total_C4), 3);
  $bobot_ternormalisasi_C1 = round(($normalisasi_C1*$bobot_C1), 3);
  $bobot_ternormalisasi_C2 = round(($normalisasi_C2*$bobot_C2), 3);
  $bobot_ternormalisasi_C3 = round(($normalisasi_C3*$bobot_C3), 3);
  $bobot_ternormalisasi_C4 = round(($normalisasi_C4*$bobot_C4), 3);
  $benefit = $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4;
  $cost = $bobot_ternormalisasi_C1;
  array_push($array_cost, $cost);
  $total_cost = round(array_sum($array_cost), 3);
  array_push($array_benefit, $benefit);
  $total_benefit = round(array_sum($array_benefit), 3);
  $bobot_relatif = round((1/$bobot_ternormalisasi_C1), 3);
  array_push($array_relatif, $bobot_relatif);
  $total_relatif = round(array_sum($array_relatif), 3);
  $relatif2 = round(($bobot_ternormalisasi_C1*212.436), 3);

  $relatif3 = round($benefit+(0.300/$relatif2), 3);
  array_push($array_maxq, $relatif3);
  $maxq = max($array_maxq);
  echo "<tr class='center'>
  <th>S<sub>{$row->id_alternative}</sub></th>
  <td>" . $bobot_relatif . "</td>
  <th>S<sub>{$row->id_alternative}</sub></th>
  <td>" . $relatif2 . "</td>
  <th>Q<sub>{$row->id_alternative}</sub></th>
  <td>" . $relatif3. "</td>
  
  </tr>\n";
}

$getMaxq = $maxq;
echo "
  <tr class='center'>
  <th>Total</th>
  <td>" .$total_relatif. "</td>
  <th></th>
  <td></td>
  <th>Max Q<sub>i</sub></th>
  <td>" .$maxq.  "</td>
  
  </tr>\n";
$result->free();

?>
</table><br><br>


<table class="table table-striped mb-0">
    <caption>
      Perhitungan utilitas kuantitatif
    </caption>
    <tr>
      <th colspan='2'>Utilitas Kuantitatif</th>
    </tr>
    <?php
$sql = "SELECT
          a.id_alternative,
          b.name,
          SUM(IF(a.id_criteria=1,a.value,0)) AS C1,
          SUM(IF(a.id_criteria=2,a.value,0)) AS C2,
          SUM(IF(a.id_criteria=3,a.value,0)) AS C3,
          SUM(IF(a.id_criteria=4,a.value,0)) AS C4
        FROM
          saw_evaluations a
          JOIN 
          saw_alternatives b 
          USING(id_alternative)
        GROUP BY a.id_alternative
        ORDER BY a.id_alternative";
$result = $db->query($sql);
$sql2 = "SELECT
          weight as bobot,
          sum(if(id_criteria = 1, weight, 0)) as B1,
          sum(if(id_criteria = 2, weight, 0)) as B2,
          sum(if(id_criteria = 3, weight, 0)) as B3,
          sum(if(id_criteria = 4, weight, 0)) as B4
        FROM
          saw_criterias";
$result2 = $db->query($sql2);
while($weight = $result2->fetch_object()){
  $bobot_C1 = round($weight->B1, 2);
  $bobot_C2 = round($weight->B2, 2);
  $bobot_C3 = round($weight->B3, 2);
  $bobot_C4 = round($weight->B4, 2);
}
$X = array(1 => array(), 2 => array(), 3 => array(), 4 => array());
$array_cost = array();
$array_benefit = array();
$array_relatif = array();
$array_maxq = array();

while ($row = $result->fetch_object()) {
  array_push($X[1], round($row->C1, 2));
  array_push($X[2], round($row->C2, 2));
  array_push($X[3], round($row->C3, 2));
  array_push($X[4], round($row->C4, 2));
  $normalisasi_C1 = round(($row->C1/$total_C1), 3);
  $normalisasi_C2 = round(($row->C2/$total_C2), 3);
  $normalisasi_C3 = round(($row->C3/$total_C3), 3);
  $normalisasi_C4 = round(($row->C4/$total_C4), 3);
  $bobot_ternormalisasi_C1 = round(($normalisasi_C1*$bobot_C1), 3);
  $bobot_ternormalisasi_C2 = round(($normalisasi_C2*$bobot_C2), 3);
  $bobot_ternormalisasi_C3 = round(($normalisasi_C3*$bobot_C3), 3);
  $bobot_ternormalisasi_C4 = round(($normalisasi_C4*$bobot_C4), 3);
  $benefit = $bobot_ternormalisasi_C2 + $bobot_ternormalisasi_C3 + $bobot_ternormalisasi_C4;
  $cost = $bobot_ternormalisasi_C1;
  array_push($array_cost, $cost);
  $total_cost = round(array_sum($array_cost), 3);
  array_push($array_benefit, $benefit);
  $total_benefit = round(array_sum($array_benefit), 3);
  $bobot_relatif = round((1/$bobot_ternormalisasi_C1), 3);
  array_push($array_relatif, $bobot_relatif);
  $total_relatif = round(array_sum($array_relatif), 3);
  $relatif2 = round(($bobot_ternormalisasi_C1*212.436), 3);
  $relatif3 = round($benefit+(0.300/$relatif2), 3);
  array_push($array_maxq, $relatif3);
  $maxq = max($array_maxq);

  $utilitas = round(($relatif3/$getMaxq), 3);
  echo "<tr class='center'>
  
  <th>U<sub>{$row->id_alternative}</sub></th>
  <td>" . $utilitas. "</td>
  
  </tr>\n";
}



$result->free();

?>
</table><br><br>

