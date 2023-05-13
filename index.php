
<!-- CSS formatting -->
<style>
h1 {text-align: center;
	font-size: 70px;}
	
h2 {text-align: center;
	font-size: 40px}

table { border:None;
		margin-left: auto;
  margin-right: auto;}
  
td {
    padding:0px 12px;
  }
  
th {
    padding:15px 12px;
  }
  

.red:before {
	background-color:red;
}


#container {
  position: relative;
}

#box{
	position:absolute;
}
</style>


<?php 

#require once the config file
require_once('config.php');

# Function to delete the order
function confirmView($arg3)
{
	
echo'
<br><br>
<h1><a href="./index.php?a=landing">Original Pizza Place</a></h1>';

# get path to file
$filename = "Pizza".md5($arg3).".txt";
$dir = dirname(__FILE__, 1);
$fn=$dir.'\\'.$filename;

# check if file exists
if(!is_file($fn)){
	echo '<h3 style="text-align:center;">Create new order!</h3>';
}

else{
echo '
<p style="text-align:center;">Are you sure you want to delete the bookmark:';echo '<b>'.$arg3.'</b>'; echo ' ?</p>
<form method="post">
  <div style="text-align:center;"> <input name="delete" type="submit" value="Confirm"> <input name="cancel" type="submit" value="Cancel"></div>
</form>  
';

# if cancel button is pressed
if(isset($_POST['cancel']))
{
	header("Location: ./index.php?a=landing");
    exit();
}

# if delete button is pressed
else if(isset($_POST['delete']))
{
	unlink($fn);
	header("Location: ./index.php?a=landing");
    exit();

}
}
}

# Function to create or edit pizza
function editPizzaView($arg4, $arg5)
{

session_start(); 
$session_top= array();
$session_name=array();
$session_price=array();

# read in the check box values
if(is_file("Pizza".md5('Saucy Pie').".txt") and $arg4=='Saucy Pie')
{
	
	if(array_key_exists("tops", $_SESSION)) 
	{
	  if($_SESSION["tops"] != null)
	  {
		$session_top = $_SESSION["tops"];
		$session_name=$_SESSION["names"];
		$session_price=$_SESSION["prices"];
	  }
	}
}
else if(is_file("Pizza".md5('Fromage Delight').".txt") and $arg4=='Fromage Delight')
{
	
	if(array_key_exists("topf", $_SESSION)) 
	{
	  if($_SESSION["topf"] != null)
	  {
		$session_top = $_SESSION["topf"];
		$session_name=$_SESSION["namef"];
		$session_price=$_SESSION["pricef"];
	  }
	}
}
else if(is_file("Pizza".md5('Peppy Pizzazz').".txt")and $arg4=='Peppy Pizzazz')
{
	
	if(array_key_exists("topp", $_SESSION)) 
	{
	  if($_SESSION["topp"] != null)
	  {
		$session_top = $_SESSION["topp"];
		$session_name=$_SESSION["namep"];
		$session_price=$_SESSION["pricep"];
	  }
	}
}



echo'

<br><br>
<h1><a href="./index.php?a=landing">Original Pizza Place</a></h1>

<h2 style="margin-bottom:0; padding-bottom:0; margin-left: -450px;">Pie Editor</h2>
<form method="post">
<div style="margin-bottom:10px;margin-left: 450px;"><input type="text" placeholder="Pizza Name" title="Pizza Name" style="width:1.5in;" name="name" '; if(!empty($session_name)) echo "value='$session_name' "; echo'/> <input type="text" placeholder="Price" title="Price" style="width:0.5in;" name="price"';if(!empty($session_price)) echo "value='$session_price'"; echo' /></div>
		
<div style="margin-left: 450px;"><b>Toppings:</b></div>
<table style="margin-left: 390px;">
<tbody>
<tr>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="red-sauce" value="red-sauce"';if(in_array("red-sauce", $session_top)) echo "checked='checked'"; echo'><label for="red-sauce">Red sauce</label></div></td>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="peppers" value="peppers"';if(in_array("peppers", $session_top)) echo "checked='checked'"; echo'><label for="peppers">Green Peppers</label></div></td>
</tr>
<tr>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="mozarella" value="mozarella"';if(in_array("mozarella", $session_top)) echo "checked='checked'"; echo'><label for="mozarella">Mozarella</label></div></td>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="ham" value="ham"';if(in_array("ham", $session_top)) echo "checked='checked'"; echo'><label for="ham">Ham</label></div></td>
</tr>
<tr>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="pepperoni" value="pepperoni"';if(in_array("pepperoni", $session_top)) echo "checked='checked'"; echo'><label for="pepperoni">Pepperoni</label></div></td>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="mushrooms" value="mushrooms"';if(in_array("mushrooms", $session_top)) echo "checked='checked'"; echo'><label for="mushrooms">Mushrooms</label></div></td>
</tr>
<tr>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="pineapple" value="pineapple"';if(in_array("pineapple", $session_top)) echo "checked='checked'"; echo'><label for="pineapple">Pineapple</label></div></td>
<td style="padding:0 60px;"><div><input type="checkbox" name="top[]" id="anchovies" value="anchovies"';if(in_array("anchovies", $session_top)) echo "checked='checked'"; echo'><label for="anchovies">Anchovies</label></div></td>
</tr>

</tbody>
</table>


<div style="margin-left: 530px; padding:10px;"> <input type="submit" value="Create" name="submit"></div>
</form>
';

# on pressing create button
if(isset($_POST['submit'])){

    if((!empty($_POST['top']) AND !empty($_POST['name']) AND !empty($_POST['price'])) OR (!empty($_POST['top1']) AND !empty($_POST['name']) AND !empty($_POST['price']))){
		
			# Saucy Pie pizza 
			if(($_POST['name'])=='Saucy Pie' AND ($_POST['price']=='12'))
			{ 
				$file = "Pizza".md5($_POST['name']).".txt";

				//Use the function is_file to check if the file already exists or not.
				// if file doesnt exist then create a new file
				if(!is_file($file)){
					
				# store data in serialized array
				$topings = implode(',', $_POST['top']);
				$content=serialize($topings);
				file_put_contents($file,$content );
				echo '<h3 style="text-align:center;">Order created successfully!</h3>';
				
				
				if(isset($_POST['top']))
				{ 
					$_SESSION['tops'] = $_POST['top'];
					$_SESSION['names']=$_POST['name'];
					$_SESSION['prices']=$_POST['price'];
				}
			}
				# When edit option is chosen, update the existing file
				else
				{
					
					if(isset($_POST['top']))
					{ 
						$_SESSION['tops'] = $_POST['top'];
					}
					#update the file
					if (!empty($_POST['top']))
					{$topings = implode(',', $_POST['top']);
					$content=serialize($topings);
					file_put_contents($file,$content );
					header("Location: ./index.php?a=edit&arg4=Create&arg5=Order%20updated%20successfully");
					exit();}
					
				}
		
			}
			
			# Fromage Delight pizza
			else if(($_POST['name'])=='Fromage Delight' AND ($_POST['price']=='13'))
			{ 
				$file = "Pizza".md5($_POST['name']).".txt";

				//Use the function is_file to check if the file already exists or not.
				if(!is_file($file)){
				
				$topings = implode(',', $_POST['top']);
				$content=serialize($topings);
				file_put_contents($file,$content);
				echo '<h3 style="text-align:center;">Order created successfully!</h3>';
				if(isset($_POST['top']))
				{ 
					$_SESSION['topf'] = $_POST['top'];
					$_SESSION['namef']=$_POST['name'];
					$_SESSION['pricef']=$_POST['price'];
				}
			}
				# edit the pizza
				else
				{
					
					if(isset($_POST['top']))
					{ 
						$_SESSION['topf'] = $_POST['top'];
					}
					
					if (!empty($_POST['top']))
					{$topings = implode(',', $_POST['top']);
					$content=serialize($topings);
					file_put_contents($file,$content );
					header("Location: ./index.php?a=edit&arg4=Create&arg5=Order%20updated%20successfully");
					exit();}
					
				}
		
		
			}
			
			#Peppy Pizzazz pizza
			else if(($_POST['name'])=='Peppy Pizzazz' AND ($_POST['price']=='15'))
			{ 
				$file = "Pizza".md5($_POST['name']).".txt";

				//Use the function is_file to check if the file already exists or not.
				if(!is_file($file)){
					
				$topings = implode(',', $_POST['top']);
				$content=serialize($topings);
				file_put_contents($file, $content);
				echo '<h3 style="text-align:center;">Order created successfully!</h3>';
				if(isset($_POST['top']))
				{ 
					$_SESSION['topp'] = $_POST['top'];
					$_SESSION['namep']=$_POST['name'];
					$_SESSION['pricep']=$_POST['price'];
				}
			}
				# edit the pizza
				else
				{
					
					if(isset($_POST['top']))
					{ 
						$_SESSION['topp'] = $_POST['top'];
					}
					#update the file
					if (!empty($_POST['top']))
					{$topings = implode(',', $_POST['top']);
					$content=serialize($topings);
					file_put_contents($file,$content );
					header("Location: ./index.php?a=edit&arg4=Create&arg5=Order%20updated%20successfully");
					exit();}
					
				}
		
		
			}
			
			else {echo 'Enter Correct Pizza name and price';}
			
    }
	else{	echo 'Data Missing! Check if Pizza name, price and toppings are entered';}

}

echo '<h3 style="text-align:center;">'.$arg5.'</h3>';

}


# Function to draw and view the pizza
function detailView($arg1, $arg2)
{
	#Keep count of number of times the page is visited for popularity hearts

if ($arg1=='Saucy Pie')
{	session_start();
	   
	if(isset($_SESSION['views1']))
		$_SESSION['views1'] = $_SESSION['views1']+1;
	else
		$_SESSION['views1']=1;
		  
	$val1=$_SESSION['views1'];
	$content = file_get_contents('config.php'); 

	$new_content = preg_replace('/\$v1=\"(.*?)\";/', '$v1="'.$val1.'";', $content);

	file_put_contents('config.php', $new_content);
	
	
	}

else if ($arg1=='Fromage Delight')
{	session_start();
	   
	if(isset($_SESSION['views2']))
		$_SESSION['views2'] = $_SESSION['views2']+1;
	else
		$_SESSION['views2']=1;
		  
	$val2=$_SESSION['views2'];
	$content = file_get_contents('config.php'); 

	$new_content = preg_replace('/\$v2=\"(.*?)\";/', '$v2="'.$val2.'";', $content);

	file_put_contents('config.php', $new_content);
	
	
	}
	
else if($arg1=='Peppy Pizzazz')
{	session_start();
	   
	if(isset($_SESSION['views3']))
		$_SESSION['views3'] = $_SESSION['views3']+1;
	else
		$_SESSION['views3']=1;
		  
	$val3=$_SESSION['views3'];
	$content = file_get_contents('config.php'); 

	$new_content = preg_replace('/\$v3=\"(.*?)\";/', '$v3="'.$val3.'";', $content);

	file_put_contents('config.php', $new_content);
	
	}

echo 

'<br><br>
<h1><a href="./index.php?a=landing">Original Pizza Place</a></h1>
<h2><?php echo $arg1 ?></h2>';
echo '<h2>'.$arg1.'</h2>';

echo'
<div style="float:left;margin-left: 720px;margin-top: 0px;"><b>Price: $';echo $arg2; echo'</b></div>';
echo '<ul style="float:left;margin-left: 720px;margin-top: 10px;">';


# read toppings data from file
if(is_file("Pizza".md5($arg1).".txt")){
$topngs = unserialize(file_get_contents("Pizza".md5($arg1).".txt"));
$array = explode (",", $topngs); 
}
else{
	echo '<h3 style="margin-left: -60px">Create an order!</h3>';
	exit();
	
}

# store the data in an array
for ($i = 0;$i < count($array);$i++)
{
	if($array[$i]=='red-sauce') $array[$i]='Red Sauce';
	if($array[$i]=='peppers') $array[$i]='Green Peppers';
	echo '<li>'.ucwords($array[$i]).'</li>';
}
echo '</ul>
<div style="float:left;margin-left: 720px;padding:5px;"><a href="./index.php?a=landing">Back</a></div>
<div class="main" >
<div id="container" style="border-radius:0.6in; border:2px solid black; width:1.2in; height:1.2in ;margin-left: 580px;">';

# draw the respective toppings
for ($i = 0;$i < count($array);$i++)
{
	#echo $array[$i];
	if($array[$i]=='Red Sauce') echo'<div id="box" class="red" style="background-color:red;border-radius:0.5in; border:2px solid black; width:1in; height:1in ;margin-top: 7px;margin-left: 7px;"></div>';
	if($array[$i]=='Green Peppers') echo'<div id="box" style="background-color:green;border-radius:1px; border:1px solid black; width:10px; height:10px ;margin-top: 30px;margin-left: 25px;"></div>';
	if($array[$i]=='mozarella') echo'<div  id="box" style="background-color:white;border-radius:0.3in; border:1px solid black; width:0.3in; height:0.3in;margin-top: 45px;margin-left: 30px;"></div>';
	if($array[$i]=='ham') echo'<div id="box" style="background-color:#FFC0CB	;border-radius:0.2in; border:1px solid black; width:0.2in; height:0.2in ;margin-top: 70px;margin-left: 70px;"></div>';
	if($array[$i]=='pepperoni') echo'<div id="box" style="background-color:#A52A2A;border-radius:0.2in; border:1px solid black; width:0.2in; height:0.2in ;margin-top: 10px;margin-left: 50px;"></div>';
	if($array[$i]=='anchovies') echo'<div id="box" style="background-color:#555;border-radius:1px; border:1px solid black; width:15px; height:3px ;margin-top: 40px;margin-left: 57px;"></div>';
	if($array[$i]=='pineapple') echo'<div id="box" style="background-color:;border-radius:1px; border:; width:0; height:0 ;border-top: 15px solid transparent;border-left: 25px solid #FFFF00;border-bottom: 15px solid transparent;margin-top: 70px;margin-left: 47px;"></div>';
	if($array[$i]=='mushrooms') echo'<div id="box" style="background-color:white;border-radius:0.2in; border:3px solid black; width:0.1in; height:0.1in;margin-top: 30px;margin-left: 75px;"></div>';
	
}


echo'</div></div>';



}

# Function to generate the landing page
    
function menuView()
{

echo 

'<br><br>
<h1><a href="./index.php?a=landing">Original Pizza Place</a></h1>

<h2>Menu</h2>


<table>
<tbody>
<tr>
<th>Pizza</th>
<th>Price</th>
<th>Popularity</th>
<th>Actions</th>
</tr>

<tr>
<td><a href="./index.php?a=detail&arg1=Saucy%20Pie&arg2=12">Saucy Pie</a></td>
<td>$12</td>
<td>';

# read page view count to draw hearts
include 'config.php';

$hearts1=floor(log($v1,5));
$hearts2=floor(log($v2,5));
$hearts3=floor(log($v3,5));

# saucy pie pizza
if($hearts1<5)
{
for ($x = 0; $x <= $hearts1; $x++) {
  echo "💗";
}
}
echo'</td>
<td><button><a href="./index.php?a=edit&arg4=Saucy%20Pie&arg5=%20" style="text-decoration:none; color: inherit; cursor:default;">✏️</a></button>
<div ><button ><a href="./index.php?a=confirm&arg3=Saucy%20Pie" style="text-decoration:none; color: inherit; cursor:default;">🗑️</a></button></div></td>
</td>
</tr>


<tr>
<td><a href="./index.php?a=detail&arg1=Fromage%20Delight&arg2=13">Fromage Delight</a></td>
<td>$13</td>
<td>';

# fromage delight pizza
if($hearts2<5)
{
for ($x = 0; $x <= $hearts2; $x++) {
  echo "💗";
}
}
echo'</td>
<td><button><a href="./index.php?a=edit&arg4=Fromage%20Delight&arg5=%20" style="text-decoration:none; color: inherit; cursor:default;">✏️</a></button>
<div ><button ><a href="./index.php?a=confirm&arg3=Fromage%20Delight" style="text-decoration:none; color: inherit; cursor:default;">🗑️</a></button></div></td>
</td>
</tr>

<tr>
<td><a href="./index.php?a=detail&arg1=Peppy%20Pizzazz&arg2=15">Peppy Pizzazz</a></td>
<td>$15</td>
<td>';

# peppy pizzazz pizza
if($hearts3<5)
{
for ($x = 0; $x <= $hearts3; $x++) {
  echo "💗";
}
}
echo'</td>
<td><button><a href="./index.php?a=edit&arg4=Peppy%20Pizzazz&arg5=%20" style="text-decoration:none; color: inherit; cursor:default;">✏️</a></button>
<div ><button ><a href="./index.php?a=confirm&arg3=Peppy%20Pizzazz" style="text-decoration:none; color: inherit; cursor:default;">🗑️</a></button></div></td>
</tr>

</tbody>
</table>

<div style="text-align:center"><button ><a href="./index.php?a=edit&arg4=Create&arg5=%20" style="text-decoration:none; color: inherit; cursor:default;">Add Pie</a></button></div>

';


}

# based on the a attribute value in the href link, execute respective functions
if (isset($_GET['a'])) 
	$linkchoice=$_GET['a'];
	

else $linkchoice='';

switch($linkchoice){

case 'detail' :
    detailView($_GET['arg1'],$_GET['arg2']);
    break;

case 'edit' :
    editPizzaView($_GET['arg4'],$_GET['arg5']);
    break;
	
case 'confirm' :
    confirmView($_GET['arg3']);
    break;
	
case 'landing' :
    menuView();
    break;	
	
default :
    menuView();
    break;
	
}

?>




