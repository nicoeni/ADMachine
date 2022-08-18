<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Airdrop Machine</title>

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="Airdrop_Machine">
		<meta name="twitter:image:src" content="https://coolscreeners.net/ADMachine/images/presentation.jpg">

		<link rel="apple-touch-icon" href="images/icone.png">
		<link rel="shortcut icon" href="images/icone.png">

		<link rel="stylesheet" href="styles/style.css">
	</head>
	<body>
		<?php

		if(isset($_POST['trustline']) && $_POST['trustline'] != "" && strlen($_POST['trustline']) > 25  ){
			$trustline = $_POST['trustline'];
			$name = "-- ? --";
	
		?>
		<h1>Airdrop Machine</h1>
		<h2>Tools to Airdrop on XRPL</h2>
		<h3>Richlist</h3>
		<p id="heure"></p>
		<br>
		<div class="nav">
			<a href="index.html"><img id = "home" src="images/home.png"></a>
			<a href=""><img id = "snapshot" src="images/snapshot.png"></a>
			<a href=""><img id = "instructions" src="images/instructions.png"></a>
			<a href=""><img id = "airdrop" src="images/airdrop.png"></a>		
		</div>
		<br>
		<div class="nav">
			<a href=""><img id = "rewards" src="images/rewards.png"></a>
			<a href="CheckAD/"><img id = "checkad" src="images/checkad.png"></a>
			<a href="richlist.php"><img id = "richlist" src="images/richlist.png"></a>
			<a href=""><img id = "contact" src="images/contact.png"></a>
			<a href=""><img id = "getcode" src="images/getcode.png"></a>
		</div>		
		<br>
		<div class="box">
			<h3>Information about the Token</h3>
			<br>
			<ul>
				<li id = "trustline"><b>Trustline Issuing Address : </b> <?php echo $trustline; ?></b> </li><br>
				<li id = "name"><b>Name : </b><?php echo $name; ?></li>
			</ul>	
		</div>

		<br>
		<div class="box">
			<h3>Statistics</h3>
			<br>
			<p class="centre">(excluded the top 3 wallets)</p><br>
			<div class="stats"><b>Distribution of wallets</b><br><canvas id="myChart1" ></canvas></div>
			<div class="stats"><b>Distribution of tokens</b><br><canvas id="myChart2" ></canvas></div>
		</div>
		
		<br>
		<div class="box">
			<h3>Richlist</h3>		
			<br>
			<div  class="centre">
				<img id ="reculeh" src = "images/recule.png" class="bouton_page"> 
				<img  src = "images/milieu.png" class="bouton_page">
				<img  src = "images/milieu.png" class="bouton_page">
				<img id ="avanceh" src = "images/avance.png" class="bouton_page"> 
			</div>
			<br>
			<div id="tableau" ></div>
			<br>
			<div  class="centre">
			<img id ="reculeb" src = "images/recule.png" class="bouton_page"> 
			<img  src = "images/milieu.png" class="bouton_page">
			<img  src = "images/milieu.png" class="bouton_page">
			<img id ="avanceb" src = "images/avance.png" class="bouton_page"> 
			</div>
		</div>		
		<br>
		
		<?php 
		$url = 'https://api.xrpscan.com/api/v1/account/'.$trustline.'/trustlines';

		$data = file_get_contents($url);
		$datas = json_decode($data);

		////////////////////////////////////////////
		$i = 0;
		$total = 0;
		$rich_l = array();
		$j = 0;
		$trust = true;
		foreach($datas as $element)
		{
			$var = (array) $element;
			$var1 = (array) $var['specification'];
			$name = $var1['currency'];
			if($j == 0){$nom = $name;}
			if($j == 1 && $name != $nom){$trust = false;}
			$j += 1;
			$wallet = $var1['counterparty'];
			if ($wallet == 'r3RaNVLvWjqqtFAawC6jbRhgKyFH7HvRS8'){$wallet = 'Bitrue';}
			if ($wallet == 'rwXEHNNuf3nctzXLtvL5JnQJGMyUZYGrVc'){$wallet = 'Probit';}
			$var1 = (array) $var['state'];
			$balance = floatval(str_replace("-","",$var1['balance']));
			if ($balance > 10000000000){$balance = 0;}
			$total += $balance;
			if(array_key_exists($wallet,$rich_l)){
				$rich_l[$wallet] = $rich_l[$wallet] + $balance;
			}
			else{
				$rich_l[$wallet] =  $balance;
			}
			$i = $i+1;
		}
		if($trust){
			$amounts = [0,0,0,0,0,0];
			$nb_wallets = [0,0,0,0,0,0];



		arsort($rich_l);
		$str = "";
		if (strlen($name) > 3){
			for($j=0;$j<strlen($name);$j+=2){
			if(substr($name,$j,2)!="00"){	$str .= chr(hexdec(substr($name,$j,2)));}
		}}
		else{$str= $name;}
		echo '<input type=hidden id="nom" value="'.$str.'">';
		echo '<input type=hidden id="nb" value="'.$i.'">';
		echo '<input type=hidden id="total" value="'.$total.'">';
		echo '<input type=hidden id="nb_wallets" value="'.json_encode($nb_wallets).'">';
		echo '<input type=hidden id="amounts" value="'.json_encode($amounts).'">';

		$liste_js = '<script language="javascript">';
		$liste_js .= 'var wallets = new Array();';
		$liste_js .= 'var balances = new Array();';
		$liste_js .= 'var page = 0;';
		foreach($rich_l as $cle => $valeur){

			$liste_js .= 'wallets.push("'.$cle.'");';
			$liste_js .= 'balances.push("'.$valeur.'");';
		}

		$liste_js .= '</script>'; 

		$richlist = '<script language="javascript">';
		$richlist .= 'function loadpage(){
		var table = "<table id=\'tableau\' style=\"border:1px solid black;margin-left:auto;margin-right:auto;\" width=\'90%\'>";
		table += "<tr ><td  style=\"border-bottom:1px solid black;border-right: 1px solid;text-align:center;padding: 4px;\"><b>Rank</b></td><td style=\"border-bottom:1px solid black;border-right: 1px solid;text-align:center;padding: 4px;\">🌊</td><td style=\"border-bottom:1px solid black;border-right: 1px solid;text-align:center;padding: 4px;\"><b>Wallet</b></td><td style=\"border-bottom:1px solid black;text-align:center;padding: 4px;\"><b>Amount</b></td></tr>";
		var i = 1;
		var bg = "";
		while(i<= 100 && (page*100+i)<nb ){
		image = "🐡";
				
		if (balances[page*100+(i-1)]>total/100000){image = "🦀️";}
		if (balances[page*100+(i-1)]>total/30000){image = "🦞️";}
		if (balances[page*100+(i-1)]>total/20000){image = "🐢️";}
		if (balances[page*100+(i-1)]>total/10000){image = "🐙️";}
		if (balances[page*100+(i-1)]>total/3000){image = "🦑️";}
		if (balances[page*100+(i-1)]>total/2000){image = "🐬️";}
		if (balances[page*100+(i-1)]>total/1000){image = "🦈️";}
		if (balances[page*100+(i-1)]>total/300){image = "🐳️";}
		if (balances[page*100+(i-1)]>total/200){image = "🐋️";}
		if (balances[page*100+(i-1)]>total/100){image = "🏝️";}
		if (balances[page*100+(i-1)]>total/20){image = "🔱";}
		if (balances[page*100+(i-1)]>total/2){image = "🌊";}
		if (i%2 == 0){bg = "style=\"background-color:white;\" ";}else{bg="";}
		$entier = Math.floor(balances[page*100+(i-1)]);
		$decimale = Math.floor((balances[page*100+(i-1)] - $entier)*100);
		$str_decimale = "";
		if ($decimale < 10){ $str_decimale = "0"+$decimale;}
		else { $str_decimale +=$decimale;}
		if (!isNaN(balances[page*100+(i-1)])){
			table += "<tr "+ bg +">";
		table += "<td style=\"border-right: 1px solid;padding: 4px;\">" + (page*100+i) + "</td>";
		table += "<td style=\"border-right: 1px solid;padding: 4px;\">" + image + "</td>";
		table += "<td style=\"border-right: 1px solid;padding: 4px;\">" + "<a href=\"http://xrpscan.com/account/"+wallets[page*100+(i-1)]+"\">" +wallets[page*100+(i-1)] +"</a>"+ "</td>";
		
		table += "<td style=\' text-align:right;padding: 4px;\'>" + $entier+"."+$str_decimale  + " "+ nom+"</td>";
		//Math.round(balances[page*100+(i-1)]*100)/100
		//$entier+"."+$str_decimale

		table += "</tr>";
		}
		
		i = i+1;
		}
		table += "</table>";
		document.getElementById("tableau").innerHTML = table;
	
		}
		loadpage();';

		$richlist .= '</script>';

		$bouton = '<script language="javascript">';
		$bouton .= "function goback(){
			var click_back = document.getElementById('reculeb');
			click_back.setAttribute ('src','images/recule_pressed.png');
			var click_back1 = document.getElementById('reculeh');
			click_back1.setAttribute ('src','images/recule_pressed.png');
		}
		function leftback(){
			var click_back = document.getElementById('reculeb');
			click_back.setAttribute ('src','images/recule.png');
			var click_back1 = document.getElementById('reculeh');
			click_back1.setAttribute ('src','images/recule.png');
		}
		function goavance(){
			var click_avance = document.getElementById('avanceb');
			click_avance.setAttribute ('src','images/avance_pressed.png');
			var click_avance1 = document.getElementById('avanceh');
			click_avance1.setAttribute ('src','images/avance_pressed.png');
		}
		function leftavance(){
			var click_avance = document.getElementById('avanceb');
			click_avance.setAttribute ('src','images/avance.png');
			var click_avance1 = document.getElementById('avanceh');
			click_avance1.setAttribute ('src','images/avance.png');
		}
		function page_recule(){
			if (page>0){
				page = page-1;
				loadpage();		
			}
			else{
				page = Math.floor(nb/100);
				loadpage();
			}
		}
		function page_avance(){
			if ((page+1)*100<nb){
				page += 1;
				loadpage();		
			}
			else{
				page=0;
				loadpage();
			}
		}

		var back = document.getElementById('reculeb');
		back.addEventListener('mouseover',goback);
		back.addEventListener('mouseout',leftback);
		back.addEventListener('click',page_recule);
		var back1 = document.getElementById('reculeh');
		back1.addEventListener('mouseover',goback);
		back1.addEventListener('mouseout',leftback);
		back1.addEventListener('click',page_recule);

		var avance = document.getElementById('avanceb');
		avance.addEventListener('mouseover',goavance);
		avance.addEventListener('mouseout',leftavance);
		avance.addEventListener('click',page_avance);
		var avance1 = document.getElementById('avanceh');
		avance1.addEventListener('mouseover',goavance);
		avance1.addEventListener('mouseout',leftavance);
		avance1.addEventListener('click',page_avance);
		";
		$bouton .= '</script>';
?>
<script src="javascript/richlist.js"></script>
<script src="javascript/Chart.js"> </script>
<?php
		echo $liste_js;
		echo $richlist;
		echo $bouton;

		$graphique = '<script language="javascript">';
		$graphique .= "var label = [\"🏝️\",\"🐳️\",\"🦈️\",\"🐙️\"];
		var amounts = [0,0,0,0];
		var nb_wallets = [0,0,0,0];
		i = 3;
		while(i<nb){
			if (!isNaN(balances[i])){
	
			n = parseFloat(balances[i]);
			total = parseFloat(total);
			if(n <= total/1000 && n > 10000){
				amounts[3] = amounts[3] + n;
				if (n > total/10000){nb_wallets[3] = nb_wallets[3] + 1;}
			}
			else if(n > total/1000 && n <= total/300){
				amounts[2] = amounts[2] + n;
				nb_wallets[2] = nb_wallets[2] + 1;
			}
			else if(n > total/300 && n < total/100){
				amounts[1] = amounts[1] + n;
				nb_wallets[1] = nb_wallets[1] + 1;
			}
			else if (n>total/100){
				amounts[0] = amounts[0] + n;
				nb_wallets[0] = nb_wallets[0] + 1;
			}
			else{amounts[3] = amounts[3] + n;}
			}

			i += 1;
		}

		const datas = {
		labels: label,
		datasets: [{
  
    
		data: nb_wallets,
		backgroundColor: [
		'rgb(255, 99, 132)',
		'rgb(54, 162, 235)',
		'rgb(255, 205, 86)',
	    'rgb(55, 255, 132)'

		],

		hoverOffset: 4
		}]
		};
		const config = {
		type: 'doughnut',
		data: datas,
		};

		const ctx1 = document.getElementById('myChart1').getContext('2d');
		const myChart1 = new Chart(ctx1, config);

		const datas2 = {
		labels: label,
		datasets: [{
  
    
		data: amounts,
		backgroundColor: [
		'rgb(255, 99, 132)',
		'rgb(54, 162, 235)',
		'rgb(255, 205, 86)',
	    'rgb(55, 255, 132)'

		],

		hoverOffset: 4
		}]
		};
		const config2 = {
		type: 'doughnut',
		data: datas2,
		};

		const ctx2 = document.getElementById('myChart2').getContext('2d');
		const myChart2 = new Chart(ctx2, config2);

		</script>";
		$graphique .= '</script>';

		echo $graphique;
		}
		else{ 

			$texte = '<script>
			var texte = \'<h1>Airdrop Machine</h1>\';
			texte +=		\'<h2>Tools to Airdrop on XRPL</h2>\';
			texte +=		\'		<h3>Richlist</h3>\';
			texte +=		\'		<p id="heure"></p>\';
			texte +=		\'		<br>\';
			texte +=		\'		<div class="nav">\';
			texte +=		\'		<a href="index.html"><img id = "home" src="images/home.png"></a>\';
			texte +=		\'		<a href=""><img id = "snapshot" src="images/snapshot.png"></a>\';
			texte +=		\'		<a href=""><img id = "instructions" src="images/instructions.png"></a>\';
			texte +=		\'		<a href=""><img id = "airdrop" src="images/airdrop.png"></a>\';
			texte +=		\'		<a href=""><img id = "contact" src="images/contact.png"></a>\';
			texte +=		\'		<a href=""><img id = "getcode" src="images/Getcode.png"></a>\';
			texte +=		\'		</div>\';
			texte +=		\'		<br>\';	
			texte +=		\'<div class="nav">\';
			texte +=		\'		<a href="richlist.php"><img id = "richlist" src="images/richlist.png"></a>\';
			texte +=		\'</div>\';
			texte +=		\'<br>\';
			texte +=		\'<div class="box">\';
			texte +=		\'		<h3>Not a token</h3>\';		
			texte +=		\'<br>\';
			texte +=		\'</div>\';
			document.querySelector("body").innerHTML = texte;</script>';

			echo $texte;

		}

		////////////////////////////////////////////
	}
	else{ 
		//////////////////////////////////////////////////////
		//       if there is no code given					//
		//////////////////////////////////////////////////////
	?>

		<h1>Airdrop Machine</h1>
		<h2>Tools to Airdrop on XRPL</h2>
		<h3>Richlist</h3>
		<p id="heure"></p>
		<br>
		<div class="nav">
			<a href="index.html"><img id = "home" src="images/home.png"></a>
			<a href=""><img id = "snapshot" src="images/snapshot.png"></a>
			<a href=""><img id = "instructions" src="images/instructions.png"></a>
			<a href=""><img id = "airdrop" src="images/airdrop.png"></a>		
		</div>
		<br>	
		<div class="nav">
			<a href=""><img id = "rewards" src="images/rewards.png"></a>
			<a href="CheckAD/"><img id = "checkad" src="images/checkad.png"></a>
			<a href="richlist.php"><img id = "richlist" src="images/richlist.png"></a>
			<a href=""><img id = "contact" src="images/contact.png"></a>
			<a href=""><img id = "getcode" src="images/getcode.png"></a>
		</div>
		<br>
		<form METHOD="POST" ACTION="richlist.php">
			<div class="box">
				<h3>Information about the Token</h3>
				<h4>Enter information about the token</h4>
				<br>
				<label for="fname"><b>Trustline Issuing Address : </b></label>
				<input type="text" class="entry" name="trustline" size="36" pattern="[a-zA-Z0-9]{1,36}" maxlength="36" placeholder="rtATPmrZvb2xV7dZjvo9DFzma1AuTg48r9">
			</div>
			<br>
			<br>
			<h4><input type='submit' value='Valider'class="validate"></h4>
		</form>
		<br>
		<br>
	<?php
	}
	?>
	</body>
	<script src="javascript/script.js"></script>
</html>