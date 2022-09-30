<?php
function textCalc($a, $m)
{
    $angle = $a * M_PI / 180; 
    $c = 230 * sqrt(2 * (1 - cos($angle)));
    $x = $c * $c / 460;
    $h = sqrt($c * $c - $x * $x);
    if ($m == 0)
        return $x;
    else
        return $h;
}
 echo 
'<form method="post">
  <input type="submit" value="Построить" name="button" />
  <input type="submit" value="Считать" name="button" />
</form>';
if (isset($_REQUEST['button']))
{
	$count=0;
$image = imageCreate(1000,500);
$colorback = imagecolorallocate($image, 245,245,245);
$colors= array();
$array=array();
	$colors_str= imagecolorallocate($image, 0,0,0);
  $x = 250;
    $y = 250; 
    $w = 400;
    $h = 400; 
    $start = 0;
if ($_REQUEST['button']=="Построить")
{
	$count = rand(2, 6); //кол-во секторов
        for ($i = 0; $i < $count; $i++) {
            $array[$i] = rand(0, 360);
            $colors[$i] = imagecolorallocate($image, rand(0, 255),rand(0, 255),rand(0, 255));
		}
}
	
else
{
	if ($_REQUEST['button']=="Считать")
	{
		$file=file("lab_6_1.txt");
$i=0;
foreach ($file as $v) 
{
   $a=preg_split("/[\s:]+/", $v);
   $array[$i]=$a[0];
   $colors[$i]= imagecolorallocate($image, $a[1],$a[2],$a[3]);
   $i++;
   $count++;
   
};
	};
};
	 $sum = array_sum($array);
    for ($i = 0; $i < count($array); $i++)
        $angles[$i] = round($array[$i] * 360 / $sum);
    for ($i = 0; $i < $count; $i++) {
        $end = $start + $angles[$i];
        imagefilledarc($image, $x, $y, $w, $h, $start, $end, $colors[$i], IMG_ARC_PIE); 

        $a = $start + ($end - $start) / 2;
        if ($a < 90) 
		{ 
            $x_text = 430 - textCalc($a, 0);
            $y_text = 250 + textCalc($a, 1);
        } else if ($a >= 90 && $a < 180)
		{ 
            $x_text = 250 - textCalc($a - 90, 1);
            $y_text = 430 - textCalc($a - 90, 0);
        } else if ($a >= 180 && $a < 270) 
		{ 
            $x_text = 10 + textCalc($a - 180, 0);
            $y_text = 250 - textCalc($a - 180, 1);
        } else 
		{ 
            $x_text = 250 + textCalc($a - 270, 1);
            $y_text = 10 + textCalc($a - 270, 0);
        }
        imagestring($image, 5, $x_text, $y_text, $array[$i], $colors_str);
        $start += $angles[$i]; 
    }
	imagepng($image,"1.png");
echo ('<img src="1.png">');
};
?>
