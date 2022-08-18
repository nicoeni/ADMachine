<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<title>Airdrop Machine</title>

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="Airdrop_Machine">
		<meta name="twitter:image:src" content="https://coolscreeners.net/ADMachine/rewards/images/presentation.jpg">

		<link rel="apple-touch-icon" href="../images/icone.png">
		<link rel="shortcut icon" href="../images/icone.png">

		<link rel="stylesheet" href="../styles/style.css">
		<link
		rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
		/>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js"></script>
	</head>
	<body>
		<script src="https://unpkg.com/xrpl@2.3.0/build/xrpl-latest-min.js"></script>

	
		<h1>Airdrop Machine</h1>
		<h2>Airdrop / Reward verification</h2>
		<h3>Verify if the Airdrop / Reward was sent</h3>
		<p id="heure"></p>
		<br>
		<div class="nav">
			<a href="../index.html"><img id = "home" src="images/home.png"></a>
			<a href=""><img id = "snapshot" src="images/snapshot.png"></a>
			<a href=""><img id = "instructions" src="images/instructions.png"></a>
			<a href=""><img id = "airdrop" src="images/airdrop.png"></a>
		</div>
		<br>
		<div class="nav">
			<a href=""><img id = "rewards" src="images/rewards.png"></a>
			<a href="index.php"><img id = "checkad" src="images/checkad.png"></a>
			<a href="../richlist.php"><img id = "richlist" src="images/richlist.png"></a>
			<a href=""><img id = "contact" src="images/contact.png"></a>
			<a href=""><img id = "getcode" src="images/getcode.png"></a>
		</div>
		<br>
		<script src="../javascript/script.js"></script>
	
<?php 
	
	if(isset($_POST['rliste'])){
	
		$trustline = $_POST['token'];
		$distributeur = $_POST['wname'];
		$rliste = $_POST['rliste'];
		$liste_wallet=explode("\n",$rliste);
		$dfin1 = $_POST['wdate'];
		$dfin = explode("/",$dfin1);
		$datedepart = strtotime("2000/01/01 0:0:0");
		if(count($dfin) == 3){
			$texte = $dfin[2].'/'.$dfin[1].'/'.$dfin[0]; $datefin = strtotime($texte." 0:0:0");
		}
		else{$datefin = $datedepart;}
		$daterecherche = $datefin - $datedepart;
	
		//recup currency
		$url = 'https://api.xrpscan.com/api/v1/account/'.$trustline.'/trustlines';

		$data = file_get_contents($url);
		$datas = json_decode($data);
		$var = (array) $datas[0];
		$var1 = (array) $var['specification'];
		$curr = $var1['currency'];
					
		////////////////////////////////////////////
		$i = 0;
		$j = 0;
		$trust = [];
		$trust1 = '\'';
		foreach($datas as $element)
		{
			$var = (array) $element;
			$var1 = (array) $var['specification'];
			$wallet = $var1['counterparty'];

			array_push($trust,trim($wallet));
			$trust1 .= ''.trim($wallet).',';
		}
		$trust1 .= '\'';
		$okk = 0;

		$liste_wallet1 = '\'';
		$nb = 0;
		foreach($liste_wallet as $elt){
		$nb += 1;
		$liste_wallet1 .=''.trim($elt).',';}
		$liste_wallet1 .= '\'';

		$ssent ="";
		$nosent ="";
		$notrust = "";
		$noaccount = "";

		////////////////////////////////////////////


?>
		<div class="box " id="affichelink">
			<h3>Here is the result for the token sent</h3>
			<br><br>
			<div style="overflow:auto;">
				<div class="enbloc" >
					<p class="centre" id ="check"></p>
					<div  class="divg" >
						<p id="sent" class="ttitre">Token received :</p>
						<textarea id="sent_r" cols = "37" rows="20"></textarea>
					</div>
					<div class="divd" >
						<p id="no_sent" class="ttitre">Token not received (last 200 transactions):</p>
						<textarea id="no_sent_r" cols = "37" rows="20"></textarea>
					</div>
				</div>
				<br><br>
		
				<div class="centre"  >
					<p id="no_trust" class="ttitre">No trustline :</p>
					<textarea id="no_trust_r" cols = "37" rows="20"></textarea>
				</div>
				<div class="spacer" style="clear;both;"></div>
			</div>
		</div>

		<script>
			var received = "";
			var noreceived = "";
			var notrust = "";
			var nbreceived = 0;
			var nbnoreceived = 0;
			var nbnotrust = 0;
			var noaccount = "";
			var dateADe = <?php echo $daterecherche; ?> 
			<?php echo 'var curr =  "'.$curr.'";'; ?>
			<?php echo 'var distributeur =  "'.$distributeur.'";'; ?>
			var trusts1 = <?php echo($trust1); ?>;
			var trusts = trusts1.split(',');
			var listewallet1 = <?php echo($liste_wallet1); ?>;
			var listewallet = listewallet1.split(',');

	
			async function main() {
				var mainnet = "wss://xrplcluster.com/"
				var serveur = mainnet

				const client = new xrpl.Client(serveur);
				await client.connect();
	
				var i = 0;
				var j = 0;
				var okk = 0;
				var nb = listewallet.length;
	
				while(i < listewallet.length){
					document.getElementById("check").innerHTML = i + " / " + nb + " wallets done";
					if(listewallet[i] != ''){
						wallet = listewallet[i];
						trustline = 1
						if((trusts.indexOf(wallet) === -1) || (wallet.trim() == "")){
							//// trustline not ok
							trustline = 0
							notrust += wallet + "\n"
							nbnotrust += 1
		
							document.getElementById("no_trust_r").innerHTML = notrust;
							document.getElementById("no_trust").innerHTML = "No trustline : " + nbnotrust;
						}
						else{
							//// trustline ok	
							await new Promise(async (resolve, reject) => {		
							ok = 0;

							prep = {"command": "account_tx",
								"account":wallet}
							transactions = await client.request(prep)
							datas = transactions.result.transactions
		
							j = 0
							okAD = 0
							k = 0
		
							while(j < datas.length){
								elt = datas[j]
								dateAD = elt.tx.date
								origine = elt.tx.Account
								typeAD = elt.tx.TransactionType
								if(origine == distributeur && typeAD == "Payment" && dateAD > dateADe){
									okAD = 1
									k = j
								}
								j += 1			
							}
							if(okAD){
								//AD ok
								received = wallet + "\n" + received
								nbreceived += 1
								document.getElementById("sent_r").innerHTML = received;
								document.getElementById("sent").innerHTML = "Token received : " + nbreceived;
							}
							else{
								//AD not ok
								noreceived = wallet + "\n" + noreceived
								nbnoreceived += 1
								document.getElementById("no_sent_r").innerHTML = noreceived;
								document.getElementById("no_sent").innerHTML = "Token not received (last 200 transactions): " + nbnoreceived;
							}
							resolve()
							reject()		
							});
						}
					}
					i += 1;
				}
	
				document.getElementById("check").innerHTML = "Verification done";
				client.disconnect()
			}
		
			main()			
		</script>
<?php  
	}
	else
	{
?>
		<div class="divgd " id="affichelink">
			<form METHOD="POST" ACTION="index.php" class="centre_form">
			<div class="centre">
				<div class="recherche">
					<input type="search" name="token" id="token" class="search-field" size="36" pattern="[a-zA-Z0-9]{1,36}" maxlength="36" placeholder="Token Issuer Account" value="">
				</div>
				<br>
				<br>
				<div class="recherche">
					<input type="search" name="wname" id="wname" class="search-field" size="36" pattern="[a-zA-Z0-9]{1,36}" maxlength="36" placeholder="Wallet which sent the Token" value="">
				</div>
				<br>
				<br>			
				<div class="recherche">
					<input type="search" name="wdate" id="wdate" class="search-field" size="36" pattern="[0-9/]{1,10}" maxlength="10" placeholder="JJ/MM/YYYY  (Date of Airdrop)" value="">
				</div>
				<br>
				<br>			
				<div class="recherche">			
					<textarea id="rliste" name="rliste" cols = "37" rows="20" placeholder="1 wallet per line"></textarea >
				</div>
			</div>		
			<br><br>			
			<div class="centre">	
				<div class="recherche">
					<INPUT type="submit" id="envoi" class="search-submit button" value="&#xf101">		
				</div>
			</div>
			</form>
		</div>

<?php } ?>
	</body>
</html>