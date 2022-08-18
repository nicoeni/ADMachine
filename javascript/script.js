///////////////////////////////////////////////////
//  Heure sur le site                            //
///////////////////////////////////////////////////
function getDt(){
dt=new Date(); 
hrs=dt.getHours();
min=dt.getMinutes(); 
sec=dt.getSeconds(); 
tm=" "+((hrs<10)?"0":"") +hrs+":"; 
tm+=((min<10)?"0":"")+min+":";
tm+=((sec<10)?"0":"")+sec+" "; 
heure.textContent = 'Server time : ' + tm; 
setTimeout("getDt()",1000); 
} 

function gohome(){
	var click_home = document.getElementById('home');
	click_home.setAttribute ('src','images/home_pressed.png');
}
function lefthome(){
	var click_home = document.getElementById('home');
	click_home.setAttribute ('src','images/home.png');
}

var home = document.getElementById('home');
try{
home.addEventListener('mouseover',gohome);
home.addEventListener('mouseout',lefthome);
}
catch(err){}
function gorichlist(){
	var click_richlist = document.getElementById('richlist');
	click_richlist.setAttribute ('src','images/richlist_pressed.png');
}
function leftrichlist(){
	var click_richlist = document.getElementById('richlist');
	click_richlist.setAttribute ('src','images/richlist.png');
}

var richlist = document.getElementById('richlist');
try{
richlist.addEventListener('mouseover',gorichlist);
richlist.addEventListener('mouseout',leftrichlist);
}
catch(err){}
function gosnapshot(){
	var click_snapshot = document.getElementById('snapshot');
	click_snapshot.setAttribute ('src','images/snapshot_pressed.png');
}
function leftsnapshot(){
	var click_snapshot = document.getElementById('snapshot');
	click_snapshot.setAttribute ('src','images/snapshot.png');
}

var snapshot = document.getElementById('snapshot');
try{
snapshot.addEventListener('mouseover',gosnapshot);
snapshot.addEventListener('mouseout',leftsnapshot);
}
catch(err){}
/*function goairdrop(){
	var click_airdrop = document.getElementById('airdrop');
	click_airdrop.setAttribute ('src','images/airdrop_pressed.png');
}
function leftairdrop(){
	var click_airdrop = document.getElementById('airdrop');
	click_airdrop.setAttribute ('src','images/airdrop.png');
}

var airdrop = document.getElementById('airdrop');
airdrop.addEventListener('mouseover',goairdrop);
airdrop.addEventListener('mouseout',leftairdrop);*/

function goinstructions(){
	var click_instructions = document.getElementById('instructions');
	click_instructions.setAttribute ('src','images/instructions_pressed.png');
}
function leftinstructions(){
	var click_instructions = document.getElementById('instructions');
	click_instructions.setAttribute ('src','images/instructions.png');
}

var instructions = document.getElementById('instructions');
try{
instructions.addEventListener('mouseover',goinstructions);
instructions.addEventListener('mouseout',leftinstructions);
}
catch(err){}
function goairdrop(){
	var click_airdrop = document.getElementById('airdrop');
	click_airdrop.setAttribute ('src','images/airdrop_pressed.png');
}
function leftairdrop(){
	var click_airdrop = document.getElementById('airdrop');
	click_airdrop.setAttribute ('src','images/airdrop.png');
}

var airdrop = document.getElementById('airdrop');
try{
airdrop.addEventListener('mouseover',goairdrop);
airdrop.addEventListener('mouseout',leftairdrop);
}
catch(err){}


function gorewards(){
	var click_rewards = document.getElementById('rewards');
	click_rewards.setAttribute ('src','images/rewards_pressed.png');
}
function leftrewards(){
	var click_rewards = document.getElementById('rewards');
	click_rewards.setAttribute ('src','images/rewards.png');
}

var rewards = document.getElementById('rewards');
try{
rewards.addEventListener('mouseover',gorewards);
rewards.addEventListener('mouseout',leftrewards);
}
catch(err){}

function gocontact(){
	var click_contact = document.getElementById('contact');
	click_contact.setAttribute ('src','images/contact_pressed.png');
}
function leftcontact(){
	var click_contact = document.getElementById('contact');
	click_contact.setAttribute ('src','images/contact.png');
}

var contact = document.getElementById('contact');
try{
contact.addEventListener('mouseover',gocontact);
contact.addEventListener('mouseout',leftcontact);
}
catch(err){}
function gotwitter(){
	var click_twitter = document.getElementById('twitter');
	click_twitter.setAttribute ('src','images/twitter_pressed.png');
}
function leftwitter(){
	var click_twitter = document.getElementById('twitter');
	click_twitter.setAttribute ('src','images/twitter.png');
}

var twitter = document.getElementById('twitter');
try{
	twitter.addEventListener('mouseover',gotwitter);
twitter.addEventListener('mouseout',leftwitter);
}
catch(err){}

function fbstop(){
	var click_stop = document.getElementById('bstop');
	click_stop.setAttribute ('src','images/stop_pressed.png');
}
function leftstop(){
	var click_stop = document.getElementById('bstop');
	click_stop.setAttribute ('src','images/stop.png');
}



var bstop = document.getElementById('bstop');
try{

bstop.addEventListener('mouseover',fbstop);
bstop.addEventListener('mouseout',leftstop);

}
catch(err){}

function ongetcode(){
	var getc = document.getElementById('getcode');
	getc.setAttribute ('src','images/Getcode_pressed.png');
}
function offgetcode(){
	var getcc = document.getElementById('getcode');
	getcc.setAttribute ('src','images/Getcode.png');
}



var gget = document.getElementById('getcode');
try{

gget.addEventListener('mouseover',ongetcode);
gget.addEventListener('mouseout',offgetcode);

}
catch(err){}

function oncheckad(){
	var checkadc = document.getElementById('checkad');
	checkadc.setAttribute ('src','images/checkad_pressed.png');
}
function offcheckad(){
	var checkadcc = document.getElementById('checkad');
	checkadcc.setAttribute ('src','images/checkad.png');
}



var checkad = document.getElementById('checkad');
try{

checkad.addEventListener('mouseover',oncheckad);
checkad.addEventListener('mouseout',offcheckad);

}
catch(err){}


/*function showSelectedFile(){
	var selectedfile = document.getElementById('selectedfile');
    selectedfile.value= document.getElementById("inputfile").value; 
	alert("--"+document.getElementById("inputfile").value+"--");
}*/
try{
	document.getElementById('selectedfile').addEventListener('change', function() {
		//document.getElementById("inputfile").value = "";			
        var fr=new FileReader();
        fr.onload=function(){
            document.getElementById('output').innerHTML=fr.result;
        }
        fr.readAsText(this.files[0]);
        })
}
catch(err){}

getDt();